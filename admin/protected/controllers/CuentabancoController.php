<?php

class CuentabancoController extends Controller
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
				'actions'=>array('create','update','admin','delete'),
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
		$model=new CuentaBanco;

		$this->performAjaxValidation($model);
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_cuenta_banco`) as `max` FROM `cuentasbancos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->codigo = $id_lead_new;
		
		if(isset($_POST['CuentaBanco']))
		{
			$model->attributes=$_POST['CuentaBanco'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_cuenta_banco));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['CuentaBanco']))
		{
			$model->attributes=$_POST['CuentaBanco'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_cuenta_banco));
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
		$dataProvider=new CActiveDataProvider('CuentaBanco');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new CuentaBanco('search');
		if(isset($_GET['CuentaBanco']))
			$model->attributes=$_GET['CuentaBanco'];
   		echo "llll";
   		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=CuentaBanco::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cuenta-banco-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
