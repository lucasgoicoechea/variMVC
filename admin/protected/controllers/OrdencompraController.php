<?php

class OrdencompraController extends Controller
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
				'actions'=>array('create','update','admin','adminPagas','imprimirOrden'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array('delete'),
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
		$model=new OrdenCompra;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_orden`) as `max` FROM `ordenes_compra` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->numero_orden = $id_lead_new;
		$this->performAjaxValidation($model);

		if(isset($_POST['OrdenCompra']))
		{
			$model->attributes=$_POST['OrdenCompra'];
			$model->Fecha = LGHelper::functions()->undisplayFecha($model->Fecha);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_orden));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['OrdenCompra']))
		{
			$model->attributes=$_POST['OrdenCompra'];
			$model->Fecha = LGHelper::functions()->undisplayFecha($model->Fecha);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_orden));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('OrdenCompra');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new OrdenCompra('search');
		if(isset($_GET['OrdenCompra']))
			$model->attributes=$_GET['OrdenCompra'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAdminPagas()
	{
		$model=new OrdenCompra('search');
		$model->Pagada = 1;
		if(isset($_GET['OrdenCompra']))
			$model->attributes=$_GET['OrdenCompra'];
	
		$this->render('admin',array(
				'model'=>$model,
		));
	}
	
	public function actionImprimirOrden() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION ORDEN DE COMPRA';
		$model->Detalle =  str_replace("\n", "<br />", $model->Detalle);
		$html = $this->renderPartial( 'ordenImpresion', array (
					'titulo' => $titulo,
					'model' => $model,
			), true );
		$style = file_get_contents(Yii::app()->request->hostInfo.'/'.Yii::app()->theme->baseUrl.'/css/estilos-min.css');
		LGHelper::functions()->generarPDF($html,$titulo,$style);
			exit;
	}
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=OrdenCompra::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-compra-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
