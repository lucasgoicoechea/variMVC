<?php
class ContratoCabeceraController extends Controller {
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
								'autoCompleteBuscar',
								'imprimirContrato',
								'agregarItemSubcontrato' 
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
		$model = new ContratoCabecera ();
		
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_contrato_cabecera`) as `max` FROM `contrato_cabecera` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->codigo = $id_lead_new;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['ContratoCabecera'] )) {
			$model->attributes = $_POST ['ContratoCabecera'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_contrato_cabecera 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['ContratoCabecera'] )) {
			$model->attributes = $_POST ['ContratoCabecera'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_contrato_cabecera 
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
		$dataProvider = new CActiveDataProvider ( 'ContratoCabecera' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new ContratoCabecera ( 'search' );
		if (isset ( $_GET ['ContratoCabecera'] ))
			$model->attributes = $_GET ['ContratoCabecera'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = ContratoCabecera::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'contrato-cabecera-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionAutoCompleteBuscar() {
		$returnVal = array ();
		if (isset ( $_GET ['term'] )) {
			$criteria = new CDbCriteria ();
			$criteria->addSearchCondition ( 't.Descripcion', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 't.Codigo', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 't.id_contrato_cabecera', $_GET ['term'], true, 'OR' );
			$obra = Obra::model ()->tablename ();
			$prov = Proveedor::model ()->tablename ();
			$criteria->join = ' left join ' . $obra . ' PXC on PXC.id_obra = t.id_obra' . ' left join ' . $prov . ' PX on PX.id_proveedor = t.id_proveedor';
			$criteria->addSearchCondition ( 'PXC.Codigo', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'PXC.Nombre', $_GET ['term'], true, 'OR' );
			$criteria->addSearchCondition ( 'PX.Nombre', $_GET ['term'], true, 'OR' );
			
			$model = new ContratoCabecera ();
			$models = $model->findAll ( $criteria );
			foreach ( $models as $model ) {
				$returnVal [] = array (
						'label' => $model->getDescripcionCompleta (),
						'value' => $model->getDescripcionCompleta (),
						'id' => $model->id_contrato_cabecera,
						'obra' => $model->obra->getDescripcion (),
						'proveedor' => $model->proveedor->getDescripcion () 
				);
			}
		}
		
		echo CJSON::encode ( $returnVal );
		Yii::app ()->end ();
	}
	public function actionImprimirContrato() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION SUBCONTRATO DE MANO DE OBRA';
                $items = $this->renderPartial ( '_viewPagosImpresion', array (
		'model' => $model
                ), true );
                $html = $this->renderPartial ( 'contratoImpresion', array (
				'titulo' => $titulo,
				'model' => $model,
                                'items'  => $items
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function actionAgregarItemSubcontrato() {
		$model = new Contrato ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$cabecera = ContratoCabecera::model ()->findbyPk ( $_GET ['id_contrato_cabecera'] );
			echo $this->renderPartial ( '_viewContrato', array (
					'model' => $cabecera 
			) );
		} else {
			if (isset ( $_GET ['Contrato'] )) {
				$model->attributes = $_GET ['Contrato'];
				if (isset ( $_GET ['id_contrato_cabecera'] )) {
					$cabecera = ContratoCabecera::model ()->findbyPk ( $_GET ['id_contrato_cabecera'] );
					$model->id_proveedor = $cabecera->id_proveedor;
					$model->id_obra = $cabecera->id_obra;
					$model->Acuerdo = $cabecera->Acuerdo;
					$model->id_empresa = $cabecera->id_empresa;
					$model->id_usuario_autorizo = $cabecera->id_usuario_autorizo;
					$model->id_usuario_solicito = $cabecera->id_usuario_solicito;
					$model->id_contrato_cabecera = $_GET ['id_contrato_cabecera'];
					$model->codigo = $cabecera->codigo;
				}
				if ($model->save ()) {
					//$cabecera->Precio = $cabecera->Precio + $model->Precio;
					//$cabecera->Plazo = $cabecera->Plazo + $model->Plazo;
					//$cabecera->save ();
					echo "Transferencia Registrada";
				} 

				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			}
		}
	}
}
