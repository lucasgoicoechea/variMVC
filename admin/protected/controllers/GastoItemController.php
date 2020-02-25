<?php

class GastoItemController extends Controller
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
				'actions'=>array('index','view','admin','autoCompleteBuscarMaterial','delete','exportarSinPaginas'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('create','update','materialesFiltros','materialesObras'),
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
		$model=new GastoItem;

		$this->performAjaxValidation($model);

		if(isset($_POST['GastoItem']))
		{
			$model->attributes=$_POST['GastoItem'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_ingreso));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionAutoCompleteBuscarMaterial() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			//$criteria->compare ( 'Nombre', $_GET ['term'], true );
			$criteria->addSearchCondition('Nombre', $_GET ['term'],true, 'OR');
			//$criteria->addSearchCondition('id_proveedor', $_GET ['term'],true, 'OR');
			$model = new Material ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcionShort(),
						'value' => $model->getDescripcionShort(),
						'id' => $model->id_material,
						'Medida' => $model->Medida,
						
				);
			}
		}
	
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['GastoItem']))
		{
			$model->attributes=$_POST['GastoItem'];
		
			if($model->save())
				$this->redirect(array('update','id'=>$model->id_gasto_item));
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
			$this->_model->delete();

			/*if(!isset($_GET['ajax']))
				$this->redirect(array('index'));*/
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('GastoItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new GastoItem('search');
		if(isset($_GET['GastoItem']))
			$model->attributes=$_GET['GastoItem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=GastoItem::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ingreso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionMaterialesObras(){
		$this->layout = "//layouts/column1";
		$model = new GastoItem ();
		$model->nulearValores();
		if (isset ( $_GET['GastoItem'] )) {
			$model->attributes = $_GET ['GastoItem'];
			$model->validate ();
			$busqeuda = true;
		}
		$this->render ( 'adminMaterialesObra', array (
				'model' => $model,
				'busqueda' => $busqeuda 
		) );
	}

	public function actionExportarSinPaginas($nombreArchivo) {
		$model = new Gasto ();
		$gastoitem = new GastoItem ();
		$gastoitem->nulearValores();
		if (isset ( $_GET ['GastoItem'] )) {
			$model->attributes = $_GET ['Gasto'];
		}
		$dataprovider = $gastoitem->searchFiltrosConMedioPagoSinPaginar ($model);
		foreach ( $dataprovider->getData () as $gastoi ) {
			$gastoi->gasto->en_blanco = $gasto->en_blanco == 0 ? 'No' : 'Si';
			$gastoi->gasto->pagada = $gasto->pagada == 0 ? 'No' : 'Si';
			$gastoi->gasto->en_orden_pago = $gastoi->gasto->getMontoTotal ();
		}
		Yii::import ( 'ext.ECSVExport' );
		$csv = new ECSVExport ( $dataprovider );
		$this->preparateAndExecuteCSV ( $csv, $nombreArchivo );
	}

	public function actionMaterialesFiltros() {
		$this->layout = "//layouts/column1";
		//$model = new Gasto ( 'search' );
		$model = new GastoItem ();
		$model->nulearValores();
		$comprobante = new Gasto ();
		$comprobante->NumComprobante=null;
		$busqeuda = false;
		if (isset ( $_GET['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
			/*$model->fechaAsientoDesde= $_POST ['Gasto']['fechaAsientoDesde'];
			$model->fechaAsientoHasta= $_POST ['Gasto']['fechaAsientoHasta'];
			$model->fechaAsientoDesde= $_POST ['Gasto']['fechaAsientoDesde'];
			$model->fechaAsientoDesde= $_POST ['Gasto']['fechaAsientoDesde'];*/
			$model->validate ();
			$busqeuda = true;
		}
		$this->render ( 'adminMaterialesFiltros', array (
				'model' => $model,
				'comprobante' =>$comprobante,
				'busqueda' => $busqeuda 
		) );
	}
	public function actionGastosPorObraAjax() {
		$model = new Gasto ();
		if (isset ( $_GET['GastoItem'] )) {
			$model->attributes = $_GET ['GastoItem'];
			// $model->validate ();
		}
		$html = $this->renderPartial ( '_resultadoGastosPorObra', array (
				'model' => $model 
		), true );
		return $html;
	}
}
