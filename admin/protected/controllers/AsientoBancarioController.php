<?php

class AsientoBancarioController extends Controller
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
				'actions'=>array('admin','create','update','saldos','crearAsiento','borrar'),
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
		$model=new AsientoBancario;

		$this->performAjaxValidation($model);

		if(isset($_POST['AsientoBancario']))
		{
			$model->attributes=$_POST['AsientoBancario'];
		

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_cuenta));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['AsientoBancario']))
		{
			$model->attributes=$_POST['AsientoBancario'];
		
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_cuenta));
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
		$dataProvider=new CActiveDataProvider('AsientoBancario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new AsientoBancario('search');
		if(isset($_GET['AsientoBancario']))
			$model->attributes=$_GET['AsientoBancario'];

		$this->render('saldoBanco',array(
			'model'=>$model,
		));
	}

	public function actionSaldos()
	{
		$this->layout = "//layouts/column1wide";
		$asientos = new AsientoBancario();
		$asienMov = new AsientosMovimientos(); 
		if(isset($_GET['AsientoBancario']))
			$asientos->attributes=$_GET['AsientoBancario'];
		if(isset($_GET['AsientosMovimientos']))
			$asienMov->attributes=$_GET['AsientosMovimientos'];

		$this->render('saldoBanco',array(
			'asientos'=>$asientos,
			'asienMov'=>$asienMov,
		));
	}

	public function actionBorrar()
	{
		//echo "d";
		$model= $this->loadModel();
		//echo "d1";
		$origenmov = $model->getMovimientoOrigen();
		//$origenmov->asentado=0;
		//$origenmov->save();
		$sql = 'update '.$origenmov->tableName().' set asentado=0  where '.$origenmov->tableSchema->primaryKey.'='.$origenmov->getPrimaryKey();
		//echo $sql;
		Yii::app()->db->createCommand($sql)->execute();
		$model->delete();
		$this->redirect(array('saldos'));
	}

	public function actionCrearAsiento(){
		$idtipo = $_GET['id_tipo_asiento'];
		$n_tipo = $_GET['n_tipo_asiento'];
		$asientomo = AsientosMovimientos::model()->find(' id_tipo_asiento='.$idtipo.' and n_tipo_asiento='.$n_tipo);
		$this->crearAsientoPorOrigenDato($asientomo);
		//echo "SE REGISTRO UN NUEVO ASIENTO";
		$this->redirect(array('saldos'));
	}

	public static function crearAsientoPorOrigenDato($objetoVistaMovimientos){

		$asiento = new AsientoBancario();
		$asiento->tipo_asiento = $objetoVistaMovimientos->tipo_asiento;
		$asiento->n_tipo_asiento = $objetoVistaMovimientos->n_tipo_asiento;
		$asiento->id_tipo_asiento = $objetoVistaMovimientos->id_tipo_asiento;
		$asiento->fecha_log = $objetoVistaMovimientos->fecha_log;
		$asiento->monto = $objetoVistaMovimientos->monto ;
		$asiento->id_cuenta = $objetoVistaMovimientos->id_cuenta;
		$asiento->caja_id = $objetoVistaMovimientos->caja_id;
		$saldoi =  0.00;
		$dd = "SELECT  `saldo` as `saldo` FROM `asiento_bancario` order by `id_asiento_bancario` desc limit 1";
		$result  = Yii::app()->db->createCommand($dd)->queryScalar ();
		$saldoi = $saldoi + $result; //+  $this->calcularSaldo();
		$asiento->saldo = $objetoVistaMovimientos->monto * $objetoVistaMovimientos->tipoAsiento->multiplicador  + $saldoi;
		$asiento->save();
		$ob = $asiento->getMovimientoOrigen();
		$sql = 'update '.$ob->tableName().' set asentado=1  where '.$ob->tableSchema->primaryKey.'='.$ob->getPrimaryKey();
		//echo $sql;
		Yii::app()->db->createCommand($sql)->execute();
		/*$ob->asentado=1;
		if (!$ob->save()){
			$errores = "d";
			foreach ( $ob->getErrors () as $error )
								$errores = $errores . ' ' . $error;
			echo "Fallo al Registrar, motivo: " . $errores;
		}*/

	}

	public function calcularSaldo(){
		$result = 100.00;
		/*$dd = "SELECT  `saldo` as `saldo` FROM `asiento_bancario` order by `id_asiento_bancario` desc limit 1";
		$result  = Yii::app()->db->createCommand($dd)->queryScalar ();*/
		return $result;
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AsientoBancario::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='AsientoBancario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
