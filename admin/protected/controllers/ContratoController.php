<?php

class ContratoController extends Controller
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
				'actions'=>array('create','update','admin','delete','autoCompleteBuscar','imprimirContrato'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array(''),
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
		$model=new Contrato;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_contrato`) as `max` FROM `contratos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->id_contrato = $id_lead_new;
		$this->performAjaxValidation($model);

		if(isset($_POST['Contrato']))
		{
			$model->attributes=$_POST['Contrato'];
			$model->Fecha = LGHelper::functions()->undisplayFecha($model->Fecha);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_contrato));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Contrato']))
		{
			$model->attributes=$_POST['Contrato'];
			$model->Fecha = LGHelper::functions()->undisplayFecha($model->Fecha);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_contrato));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition('t.Detalle', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('t.Codigo', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('t.id_contrato', $_GET ['term'],true, 'OR');
			$obra  = Obra::model()->tablename();
			$prov = Proveedor::model()->tablename();
			$criteria->join =
			' left join '.$obra.' PXC on PXC.id_obra = t.id_obra'
			.' left join '.$prov.' PX on PX.id_proveedor = t.id_proveedor';
			$criteria->addSearchCondition('PXC.Codigo', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('PXC.Nombre', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('PX.Nombre', $_GET ['term'],true, 'OR');
					
			$model = new Contrato();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcionCompleta(),
						'value' => $model->getDescripcionCompleta(),
						'id' => $model->id_contrato,
						'obra' => $model->obra->getDescripcion(),
						'proveedor'=> $model->proveedor->getDescripcion()
				);
			}
		}
	
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Contrato');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Contrato('search');
		if(isset($_GET['Contrato']))
			$model->attributes=$_GET['Contrato'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Contrato::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contrato-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionImprimirContrato() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION SUBCONTRATO DE MANO DE OBRA';
		$html = $this->renderPartial ( 'contratoImpresion', array (
				'titulo' => $titulo,
				'model' => $model
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
}
