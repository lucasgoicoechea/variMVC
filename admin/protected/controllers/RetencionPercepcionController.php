<?php
class RetencionPercepcionController extends Controller {
	public $layout = '//layouts/column2';
	private $_model;
	public function filters() {
		return array (
				'accessControl' 
		);
	}
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'index',
								'view' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'admin',
								'create',
								'update',
								'delete' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'' 
						),
						'users' => array (
								'admin' 
						) 
				),
				array (
						'deny',
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function actionCreate() {
		$model = new RetencionPercepcion ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['RetencionPercepcion'] )) {
			$model->attributes = $_POST ['RetencionPercepcion'];
			if ($model->save ())
				$this->redirect ( array (
						'update',
						'id' => $model->id_retencion_percepcion 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		if (isset ( $_POST ['RetencionPercepcionValores'] )) {
			$valor = new RetencionPercepcionValores ();
			$valor->id_retencion_percepcion = $model->id_retencion_percepcion;
			$valor->valor = $_POST ['RetencionPercepcionValores'] ['valor'];
			if ($valor->save ()) {
			} else
				echo print_r ( $valor->getErrors () );
		}
		if (isset ( $_POST ['RetencionPercepcion'] )) {
			$model->attributes = $_POST ['RetencionPercepcion'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_retencion_percepcion 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			if (isset ( $_POST ['RetencionPercepcionValores'] )) {
				$valor = RetencionPercepcionValores::model ()->findbyPk ( $_GET ['id'] );
				$valor->delete();
			} else {
				$this->loadModel ()->delete ();
			}
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'RetencionPercepcion' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new RetencionPercepcion ( 'search' );
		if (isset ( $_GET ['RetencionPercepcion'] ))
			$model->attributes = $_GET ['RetencionPercepcion'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = RetencionPercepcion::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'retencion-percepcion-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
