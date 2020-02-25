<?php
class CuentaController extends Controller {
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
								'create',
								'update',
								'admin',
								'admincerradas',
								'delete',
								'transferencias',
								'verTransferencias',
								'autoCompleteBuscar',
								'autoCompleteBuscarCobradora',
								'autoCompleteBuscarAdministradora' 
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
	
	public function actionAdmincerradas() {
		$model = new Cuenta ( 'search' );
		if (isset ( $_GET ['Cuenta'] ))
			$model->attributes = $_GET ['Cuenta'];
			$model->cerrada=1;
			$this->render ( 'admin', array (
					'model' => $model
			) );
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function actionTransferencias() {
		$model = new Cuenta ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cuenta'] )) {
			$model->attributes = $_POST ['Cuenta'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cuenta 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionCreate() {
		$model = new Cuenta ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cuenta'] )) {
			$model->attributes = $_POST ['Cuenta'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cuenta 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cuenta'] )) {
			$model->attributes = $_POST ['Cuenta'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cuenta 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionAutoCompleteBuscarCobradora() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition ( 'Nombre', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'Codigo', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'es_cobradora', true, true, 'AND' );
			$criteria->compare ( 'cerrada',0,true );
			$model = new Cuenta ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion (),
						'value' => $model->getDescripcion (),
						'id' => $model->id_cuenta,
						'nombre' => $model->Nombre 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionAutoCompleteBuscarAdministradora() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition ( 'Nombre', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'Codigo', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'es_administracion', true, true, 'AND' );
			$criteria->compare ( 'cerrada',0,true );
			$model = new Cuenta ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion (),
						'value' => $model->getDescripcion (),
						'id' => $model->id_cuenta,
						'nombre' => $model->Nombre 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition ( 'Nombre', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'Codigo', $_GET ['term'], true, 'OR' );
			$criteria->compare ( 'cerrada',0,true );
			
			$model = new Cuenta ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion (),
						'value' => $model->getDescripcion (),
						'id' => $model->id_cuenta,
						'nombre' => $model->Nombre 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$this->loadModel ()->delete ();
			
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Cuenta' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Cuenta ( 'search' );
		if (isset ( $_GET ['Cuenta'] ))
			$model->attributes = $_GET ['Cuenta'];
			$model->cerrada=0;
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Cuenta::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'cuenta-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
