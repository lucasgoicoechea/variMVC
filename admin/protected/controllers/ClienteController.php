<?php
class ClienteController extends Controller {
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
								'delete',
								'partidosByProvincia',
								'ciudadByPartido',
								'autoCompleteBuscar', 
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
		$model = new Cliente ();
		
		
		$this->performAjaxValidation ( $model );
		
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`codigo`) as `max` FROM `clientes` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->codigo= $id_lead_new;
		
		if (isset ( $_POST ['Cliente'] )) {
			$model->attributes = $_POST ['Cliente'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cliente 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cliente'] )) {
			$model->attributes = $_POST ['Cliente'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cliente 
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
		$dataProvider = new CActiveDataProvider ( 'Cliente' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Cliente ( 'search' );
		if (isset ( $_GET ['Cliente'] ))
			$model->attributes = $_GET ['Cliente'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Cliente::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'cliente-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionPartidosByProvincia() {
		$list = Partido::model ()->findAll ( "c_id_provincia=?", array (
				$_POST ["Cliente"] ["id_provincia"] 
		) );
		// $primerPartido = 0;
		foreach ( $list as $data ) {
			// $primerPartido==0?$primerPartido=$data->c_id:'';
			echo "<option value=\"{$data->c_id}\">{$data->d_descripcion}</option>";
		}
		// $_POST ["Usuarios"] ["id_partido"]=$primerPartido;
		// $this->actionCiudadByPartido();
	}
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition('nombre', $_GET ['term'],true, 'OR');
			$criteria->addSearchCondition('codigo', $_GET ['term'],true, 'OR');
			//$criteria->compare ( 'Codigo', $_GET ['term'], true );
			$model = new Cliente();
			// $qtxt ="SELECT concat(codigo,nombre) FROM obras WHERE nombre LIKE :nombre";
			// $command =Yii::app()->db->createCommand($qtxt);
			// $command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
			// $res =$command->query;
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcion(),
						'value' => $model->getDescripcion(),
						'id' => $model->id_cliente,
						'nombre' => $model->nombre 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionCiudadByPartido() {
		$list = Localidad::model ()->findAll ( "c_id_partido=?", array (
				$_POST ["Cliente"] ["id_partido"] 
		) );
		foreach ( $list as $data )
			echo "<option value=\"{$data->c_id}\">{$data->d_descripcion}</option>";
	}
}
