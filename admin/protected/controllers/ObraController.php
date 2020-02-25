<?php
class ObraController extends Controller {
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
								'adminTerminadas',
								'create',
								'update',
								'delete',
								'autoCompleteBuscar' ,
								'autoCompleteBuscarAll'
						),
						'users' => array (
								'@' 
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
		$model = new Obra ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_obra`) as `max` FROM `obras` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->Codigo = $id_lead_new;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Obra'] )) {
			$model->attributes = $_POST ['Obra'];
			$model->FechaInicio = LGHelper::functions()->undisplayFecha($model->FechaInicio);
			$model->FechaFin = LGHelper::functions()->undisplayFecha($model->FechaFin);
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_obra 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Obra'] )) {
			$model->attributes = $_POST ['Obra'];
			$model->FechaInicio = LGHelper::functions()->undisplayFecha($model->FechaInicio);
			$model->FechaFin = LGHelper::functions()->undisplayFecha($model->FechaFin);
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_obra 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
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
		$dataProvider = new CActiveDataProvider ( 'Obra' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Obra ( 'search' );
		if (isset ( $_GET ['Obra'] ))
			$model->attributes = $_GET ['Obra'];
		else
			$model->Codigo = '';
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionAdminTerminadas() {
		$model = new Obra ( 'search' );
		$model->terminada = 1;
		if (isset ( $_GET ['Obra'] ))
			$model->attributes = $_GET ['Obra'];
		else
			$model->Codigo = '';
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition('Nombre', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('Codigo', $_GET ['term'],true, 'OR');
			$criteria->compare ( 'terminada',0,true );
			//$criteria->compare ( 'Codigo', $_GET ['term'], true );
			$model = new Obra ();
			// $qtxt ="SELECT concat(codigo,nombre) FROM obras WHERE nombre LIKE :nombre";
			// $command =Yii::app()->db->createCommand($qtxt);
			// $command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
			// $res =$command->query;
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion(),
						'value' => $model->getDescripcion(),
						'id' => $model->id_obra,
						'Direccion' => $model->Direccion,
						'nombre' => $model->Nombre 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionAutoCompleteBuscarAll() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition('Nombre', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('Codigo', $_GET ['term'],true, 'OR');
			//$criteria->compare ( 'terminada',0,true );
			//$criteria->compare ( 'Codigo', $_GET ['term'], true );
			$model = new Obra ();
			// $qtxt ="SELECT concat(codigo,nombre) FROM obras WHERE nombre LIKE :nombre";
			// $command =Yii::app()->db->createCommand($qtxt);
			// $command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
			// $res =$command->query;
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion(),
						'value' => $model->getDescripcion(),
						'id' => $model->id_obra,
						'Direccion' => $model->Direccion,
						'nombre' => $model->Nombre
				);
			}
		}
	
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Obra::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'obra-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
