<?php

class ComunicacionController extends Controller
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
				'actions'=>array('create','update','admin','delete','marcarLeido'),
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
		$model=new Comunicacion;

		$this->performAjaxValidation($model);

		if(isset($_POST['Comunicacion']))
		{
			$model->attributes=$_POST['Comunicacion'];
		    $model->fecha_emision = CTimestamp::formatDate ( 'Y-m-d H:i:s' );
		    $model->id_userslogin_origen = Yii::app ()->user->id;

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Comunicacion']))
		{
			$model->attributes=$_POST['Comunicacion'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_comunicacion));
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
		$dataProvider=new CActiveDataProvider('Comunicacion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Comunicacion('search');
		if(isset($_GET['Comunicacion']))
			$model->attributes=$_GET['Comunicacion'];

		$this->render('admin',array(
			'model'=>$model,
			'id_userslogin' => Yii::app ()->user->id	
		));
	}
	
	public function actionMarcarLeido() {
		$comunica = new Comunicacion();
		// cheque original
		if (isset ( $_GET ['id'] ))
			$comunica = Comunicacion::model ()->findByPk ( $_GET ['id'] );
		else {
			echo $_GET ['id'];
			Yii::app ()->end ();
		}
		Comunicacion::model ()->marcaLeida( $comunica->id_comunicacion);
		$this->redirect(Yii::app()->homeUrl);
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Comunicacion::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comunicacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
