<?php

class TransferenciaPagoController extends Controller
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
				'actions'=>array('admin','delete','create','update'),
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
		$model=new TransferenciaPago;

		$this->performAjaxValidation($model);

		if(isset($_POST['TransferenciaPago']))
		{
			$model->attributes=$_POST['TransferenciaPago'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_transferencia_pago));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['TransferenciaPago']))
		{
			$model->attributes=$_POST['TransferenciaPago'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_transferencia_pago));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel();
			$caja = Caja::model ()->getUltimaCaja ();
			if ($caja->id_caja!=$this->_model->caja_id) {  //si la caja no es la caja abierta
				$model = Pago::model ()->findbyPk ( $this->_model->id_pago );
				BajaMedioPago::saveBajaTransferenciaPago($this->_model,$model->id_cuenta);
			}
			$this->_model->delete();
			

			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TransferenciaPago');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new TransferenciaPago('search');
		if(isset($_GET['TransferenciaPago']))
			$model->attributes=$_GET['TransferenciaPago'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=TransferenciaPago::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transferencia-pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
