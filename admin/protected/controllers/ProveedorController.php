<?php

class ProveedorController extends Controller
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
				'actions'=>array('create','update','admin','delete','autoCompleteBuscar','borrarMultiples'),
				'users'=>array('@'),
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
		$model=new Proveedor;

		$this->performAjaxValidation($model);
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_proveedor`) as `max` FROM `proveedores` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->id_proveedor = $id_lead_new;
		
		if(isset($_POST['Proveedor']))
		{
			$model->attributes=$_POST['Proveedor'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_proveedor));
		}
		

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Proveedor']))
		{
			$model->attributes=$_POST['Proveedor'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_proveedor));
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
		$dataProvider=new CActiveDataProvider('Proveedor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Proveedor('search');
		if(isset($_GET['Proveedor']))
			$model->attributes=$_GET['Proveedor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			//$criteria->compare ( 'Nombre', $_GET ['term'], true );
			$criteria->addSearchCondition('Nombre', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('id_proveedor', $_GET ['term'],true, 'OR');
			$model = new Proveedor ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcionShort(),
						'value' => $model->getDescripcionShort(),
						'id' => $model->id_proveedor,
						'nombre' => $model->Nombre,
						'telefono' => $model->Telefono,
				);
			}
		}
	
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Proveedor::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='proveedor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionBorrarMultiples(){
		if(isset($_GET['proveedor-grid_c0'])){
			$ids = $_GET['proveedor-grid_c0'];
			foreach ($ids as $id)
				Proveedor::model()->borrar($id);
		}
	}
}
