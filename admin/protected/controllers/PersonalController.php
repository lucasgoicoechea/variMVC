<?php

class PersonalController extends Controller
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
					'actions'=>array('exportar','create','update','admin','adminInactivos','delete','autoCompleteBuscar'),
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
		$model=new Personal;

		$this->performAjaxValidation($model);

		if(isset($_POST['Personal']))
		{
			$model->attributes=$_POST['Personal'];
			$exito = $model->crearProveedorSetearId();
			//primero generar un Proveedor,  
			//y ese id_proveedor setearlo aca
		    if($exito){
				//luego guardar
				if($model->save())
					$this->redirect(array('view','id'=>$model->id_proveedor));
				}
			else {
               $model->addError('Fallo Datos básicos como Proveedor');
			}	
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionExportar($nombreArchivo) { // con JPhpExcel
		$model=new Personal();
		$model->nulear();
			$model->activo = 1;
		if (isset ( $_GET ['Personal'] )) {
			$model->attributes = $_GET ['Personal'];
		}
		$dataprovider = $model->search ();
		/*foreach ( $dataprovider->getData () as $personal ) {
			echo "junte";
			exit();
		}*/
		$data = $dataprovider->getData ();
		Yii::import ( 'application.extensions.phpexcel.JPhpExcel' );
		$xls = new JPhpExcel ( 'UTF-8', false, 'Personal' );
		$xls->addArray ( $data );
		/*
		 * $xls->getProperties()->setCreator("VARI S.R.L."); $xls->getProperties()->setLastModifiedBy("VARI S.R.L."); $xls->getProperties()->setTitle("Office 2007 XLSX Test Document"); $xls->getProperties()->setSubject("Office 2007 XLSX Test Document"); $xls->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		 */
		$xls->generateXML ( $nombreArchivo );
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Personal']))
		{
			$model->attributes=$_POST['Personal'];
		
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
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Personal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		//$model=new Personal('search');
		$model=new Personal();
		$model->nulear();
			$model->activo = 1;
		if(isset($_GET['Personal']))
			$model->attributes=$_GET['Personal'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	public function actionAdminInactivos()
	{
		//$model=new Personal('search');
		$model=new Personal();
		$model->nulear();
		$model->activo = 0;
		if(isset($_GET['Personal']))
			$model->attributes=$_GET['Personal'];		
			$this->render('admin',array(
					'model'=>$model,
			));
	}
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Personal::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='personal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			
			$criteria->addSearchCondition('Nombre', '%'.$_GET ['term'].'%',false, 'OR');
			$criteria->addSearchCondition('Apellido', '%'.$_GET ['term'].'%',false, 'OR');
			$criteria->addCondition('activo=1');
			$model = new Personal();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion(),
						'value' => $model->getDescripcion(),
						'id' => $model->id_proveedor,
						'nombre' => $model->getDescripcion(),
						'categoria' => $model->getCategoria (),
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
}
