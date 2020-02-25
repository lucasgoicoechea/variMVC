<?php

class TipoGastoController extends Controller
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
		$model=new TipoGasto;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_tipo_gasto`) as `max` FROM `tipogasto` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->codigo = $id_lead_new;
		
		$this->performAjaxValidation($model);

		if(isset($_POST['TipoGasto']))
		{
			$model->attributes=$_POST['TipoGasto'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_tipo_gasto));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['TipoGasto']))
		{
			$model->attributes=$_POST['TipoGasto'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_tipo_gasto));
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
		$dataProvider=new CActiveDataProvider('TipoGasto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new TipoGasto('search');
		if(isset($_GET['TipoGasto']))
			$model->attributes=$_GET['TipoGasto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=TipoGasto::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-gasto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
