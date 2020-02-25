<?php

class QuincenaController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;

	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', 
					'actions'=>array('actualizarImporte','actualizarImporteFinal','create','update','view', 'delete','admin', 'adminQuincenal'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$model=new Quincena();
		//que el indice se iguale cno el id_quincena que surge autoincremental
		//que sino existe el quincenal lo agregue nuevo
		//guarde el valor calculado de subtotal y final
		//y luego registra el gasto, como un gasto efectivo
		//a la cuenta 
		//compartiendo obra y proveedor
		$model->id_cuenta = Cuenta::model()->findByPk(35);
		$this->performAjaxValidation($model);
		if(isset($_POST['Quincena']))
		{
			$model->attributes=$_POST['Quincena'];
			$fecha =  $_POST['Quincena']['Fecha'] ;
			//echo $fecha.'probando';
			$model->Fecha =LGHelper::functions ()->undisplayFecha ( $fecha );
			//exit();
			if($model->save()){
				$model->Quincena = $model->quincenal->getDescripcion(); 
				$model->Indice = $model->id_quincena;
				$model->nro_secuencia_quincena = Quincena::model()->getNroSecuenciaQuincena($model->id_quincenal);
				$model->save();
				$RESULT = Gasto::model()->createQuincenaPagado($model);
				if (!($RESULT=="GUARDADO")){
					//$model->addError('common',$RESULT);
					echo'resultado:'.$RESULT;
				}
				else $this->redirect(array('view','id'=>$model->id_quincena));
			}
		}
		//$model->Fecha = LGHelper::functions ()->displayFecha ($fecha);
		$model->formatearMoneda();
		$this->render('create',array(
				'model'=>$model,
				'urlOperationAction' => 'quincena/actualizarImporte',
				'urlOperationAFinalction' => 'quincena/actualizarImporteFinal',
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();
        //si cambia el Final se debe cambiar el Monto en el gasto asociado
		$this->performAjaxValidation($model);
        $model->id_cuenta = $model->gasto->getPago()->id_cuenta;
		if(isset($_POST['Quincena']))
		{
			$model->attributes=$_POST['Quincena'];
			$model->formatearMoneda();
			$fecha =  $_POST['Quincena']['Fecha'] ;
			echo $fecha.'probando';
			$model->Fecha =LGHelper::functions ()->undisplayFecha ( $fecha );
			//exit();
			if($model->save()){
				$model->Quincena = $model->quincenal->getDescripcion(); 
				$model->Indice = $model->id_quincena;
				$model->nro_secuencia_quincena = Quincena::model()->getNroSecuenciaQuincena($model->id_quincenal);
				$model->save();
				echo "GUARDANDO RESULTADO";
				//ACTUALIZAR EL GASTO ASOCIADO, SI LA CAJA ESTA CERRADA HACER UN BAJA MEDIO DE PAGO Y UN NUEVO GASTO
				$RESULT = Gasto::model()->bajaYCreateQuincenaPagado($model);
				if (!($RESULT=="GUARDADO")){
					//$model->addError('common',$RESULT);
					echo'resultado:'.$RESULT;
				}
				else $this->redirect(array('view','id'=>$model->id_quincena));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'urlOperationAction' => 'quincena/actualizarImporte/' . $model->id_quincena,
			'urlOperationAFinalction' => 'quincena/actualizarImporteFinal/' . $model->id_quincena,
		));
	}

	public function actionActualizarImporte(){
		$model=new Quincena;
		if(isset($_POST['Quincena']))
		{
			$model->attributes=$_POST['Quincena'];
			$model->desformatearMoneda();
			$model->calcularImportes();
			$model->formatearMoneda();
			//return CHtml::activeTextField($model,'subtotal',array('size'=>20,'maxlength'=>12,'id'=>'Quincena_subtotal'));
			echo $model->subtotal;
		}
		else echo "VALORES INVALIDOS";
	}
	public function actionActualizarImporteFinal(){
		$model=new Quincena;
		if(isset($_POST['Quincena']))
		{
			$model->attributes=$_POST['Quincena'];
			$model->desformatearMoneda();
			$model->calcularImportes();
			$model->formatearMoneda();
			//return CHtml::activeTextField($model,'Final',array('size'=>20,'maxlength'=>12,'id'=>'Quincena_Final'));
			echo $model->Final;
		}
		else echo "VALORES INVALIDOS";
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$mdoelo = $this->loadModel();
			$mdoelo->gasto->borrarGastoConOPyPagos();
			$mdoelo->delete(); //no hace falta porque se borra desde el gasto

			if(!isset($_GET['ajax']))
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Quincena');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{   
		$this->layout = '//layouts/column1wide';
		$model=new Quincena();
		$model->nulearImportes();
		if(isset($_GET['Quincena']))
			$model->attributes=$_GET['Quincena'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionAdminQuincenal($id_quincenal)
	{
		$model=new Quincena();
		$model->nulearImportes();
		$model->id_quincenal=$id_quincenal;
		if(isset($_GET['Quincena']))
			$model->attributes=$_GET['Quincena'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Quincena::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='quincena-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
