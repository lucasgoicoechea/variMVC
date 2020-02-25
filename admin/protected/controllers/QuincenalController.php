<?php

class QuincenalController extends Controller
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
				'actions'=>array('autoCompleteBuscar','create','update','admin','delete'),
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
		$model=new Quincenal;

		$this->performAjaxValidation($model);

		if(isset($_POST['Quincenal']))
		{
			$model->attributes=$_POST['Quincenal'];
			$model->descripcion = $model->quincena==1?'Primera':'Segunda'.'-'.$model->mes.'-'.$model->anio;

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_quincenal));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Quincenal']))
		{
			$model->attributes=$_POST['Quincenal'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_quincenal));
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
		$dataProvider=new CActiveDataProvider('Quincenal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Quincenal();
		$model->nulear();
		if(isset($_GET['Quincenal']))
			$model->attributes=$_GET['Quincenal'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Quincenal::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='quincenal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			//$criteria->compare ( 'anio', $_GET ['term'], true );
			$criteria->compare ( 'descripcion', $_GET ['term'], true );
			//$criteria->compare ( 'quincena', $_GET ['term'], true );
			//$criteria->compare ( 'mes', $_GET ['term'], true );
			$model = new Quincenal();
			$models = $model->findAll ( $criteria );
			
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion(),
						'value' => $model->getDescripcion(),
						'id' => $model->id_quincenal,
						'nombre' => $model->getDescripcion(),
						//'' => $model->Telefono,
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
}
