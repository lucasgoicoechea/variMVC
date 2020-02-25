<?php
class ChequeController extends Controller {
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
								'emitirCheque',
								'createChequera',
								'adminAnulados',
								'modificarCheque',
								'reemplazarCheque',
								'anularCheque',
								'reemplazarChequePopUp' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'delete' 
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
		$model = new Cheque ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cheque'] )) {
			$model->attributes = $_POST ['Cheque'];
			// FechaEmision, FechaPago
			$model->FechaPago = LGHelper::functions ()->undisplayFecha ( $model->FechaPago );
			$model->FechaEmision = LGHelper::functions ()->undisplayFecha ( $model->FechaEmision );
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cheque 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionCreateChequera() {
		$model = new Cheque ();
		//$model->chequeNroHasta = 10;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cheque'] )) {
			$model->attributes = $_POST ['Cheque'];
			$model->chequeNroHasta = $_POST ['Cheque']['chequeNroHasta'];
			$todoOk = false;
			for($nro = $model->Numero; $nro < $model->chequeNroHasta + 1; $nro ++) {
				$modelTmp = new Cheque ();
				$modelTmp->attributes = $model->attributes;
				$modelTmp->Numero = $nro;
				$todoOk = $modelTmp->save ();
			}
			if ($todoOk)
				$this->render ( 'showChequera', array (
						'model' => $model 
				) );
			else
				$this->render ( 'createChequera', array (
						'model' => $model 
				) );
		}
		
		$this->render ( 'createChequera', array (
				'model' => $model 
		) );
	}
	public function actionReemplazarCheque() {
		$model = new Cheque ();
		$model = $this->loadModel ();
		// hay que buscar el otro cheuque y referenciar el el FK,
		// y ademas si esta en un Pago hay que copiarle el Importe
		// al cheque que reemplaza y referenciarlo al Pago
		$this->render ( 'reemplazar', array (
				'model' => $model 
		) );
	}
	public function actionAnularCheque() {
		$chequeOriginal = new Cheque ();
		// cheque original
		if (isset ( $_GET ['id'] ))
			$chequeOriginal = Cheque::model ()->findByPk ( $_GET ['id'] );
		else {
			echo $_GET ['id'];
			Yii::app ()->end ();
		}
		Cheque::model ()->anularCheque ( $chequeOriginal->id_cheque );
		echo "Cheque ANULADO CON EXITO";
	}
	public function actionReemplazarChequePopUp() {
		$chequeOriginal = new Cheque ();
		// cheque original
		if (isset ( $_GET ['id_cheque'] ))
			$chequeOriginal = Cheque::model ()->findByPk ( $_GET ['id_cheque'] );
		else {
			echo $_GET ['id_cheque'];
			Yii::app ()->end ();
		}
		if (! isset ( $_GET ['refresh'] )) {
			
			$cheque = new Cheque ();
			$cheque->unsetAttributes (); // clear any default values
			if (isset ( $_GET ['Cheque'] ))
				$cheque->attributes = $_GET ['Cheque'];
			if (! isset ( $_GET ['refresh'] )) {
				// $model= UsuariosEntrevistas::model()->findByPk($_GET['id']);
				if (isset ( $_POST ['cheque-grid_c0'] )) {
					$seleccionados = $_POST ['cheque-grid_c0'];
					$exito = true;
					$criteria = new CDbCriteria ();
					$criteria->condition = ' id_cheque=' . $chequeOriginal->id_cheque;
					$results = PagoCheque::model ()->find ( $criteria );
					$id_pago = null;
					if ($results != null) {
						$id_pago = $results->id_pago;
					}
					foreach ( $seleccionados as $idChequegrid ) {
						$modelCheque = Cheque::model ()->findByPk ( $idChequegrid );
						if ($id_pago != null) {
							PagoCheque::model ()->registrarReemplazo ( $idChequegrid, $id_pago );
							Cheque::model ()->agregarEnPago ( $idChequegrid, $id_pago );
						}
						Cheque::model ()->copiarParaReemplazo ( $chequeOriginal, $modelCheque );
						if (! $exito) {
							Yii::app ()->user->setFlash ( 'mensaje', $modelCheque->getErrors () );
							$errores = '';
							foreach ( $modelOP->getErrors () as $error )
								$errores = $errores . ' ' . $error;
							return $errores . $model->id_pago;
						}
					}
					// Cheque::model ()->anularCheque ( $chequeOriginal->id_cheque );
					echo "Cheques reemplazaron a Cheque Anulado";
					Yii::app ()->end ();
				}
				// if (! empty ( $_GET ['asDialog'] ))
				$this->layout = '//layouts/main';
				$this->render ( 'adminCheques', array (
						'cheque' => $cheque,
						// 'id_pago' => $_GET ['id_pago'],
						'model' => $chequeOriginal,
						'urlOperationAction' => 'cheque/reemplazarChequePopUp/id_cheque/' . $_GET ['id_cheque'],
						// 'urlOperationAction' => 'pago/reemplazarCheque/' . $_GET ['id_pago'],
						'grillaPosgrados' => 'list_cheques',
						'conFormulario' => true,
						'htmloptionscheck' => array (
								'style' => "width: 100px" 
						) 
				), false );
			} else {
				// $this->redibujarListaCheques ();
			}
		} else {
			echo $this->renderPartial ( 'chequesReemplazantes', array (
					'model' => $chequeOriginal 
			) );
		}
	}
	public function redibujarListaCheques() {
		$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $_GET ['id_pago'] );
		if ($resultadosEntrev != null) {
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
					// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Cheques	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
					// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewCheque',
					// 'viewData' => array( 'data' => null ),
					'ajaxUpdate' => false,
					// 'enablePagination'=>true
					'pager' => array (
							'header' => 'Ir a', // text before it
							'maxButtonCount' => 28 
					) 
			) );
			$montoTotalCheque = 0.00;
			$resultados = PagoCheque::model ()->searchWithPagoOO ( $_GET ['id_pago'] );
			foreach ( $resultados as $value ) {
				if (! $value->cheque->anulado) {
					$montoTotalCheque = $montoTotalCheque + LGHelper::functions ()->unformatNumber($value->cheque->Importe);
				}
			}
			echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalCheque ) . '</b></div></div>';
		} else {
			echo "NO POSEE ORDENES DE PAGO SELECCIONADAS";
			$montoTotalCheque = 0.00;
			echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalCheque ) . '</b></div></div>';
		}
	}
	public function actionEmitirCheque() {
		$model = new Cheque ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cheque'] )) {
			$model->attributes = $_POST ['Cheque'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cheque 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cheque'] )) {
			$model->attributes = $_POST ['Cheque'];
			$model->FechaPago = LGHelper::functions ()->undisplayFecha ( $model->FechaPago );
			$model->FechaEmision = LGHelper::functions ()->undisplayFecha ( $model->FechaEmision );
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cheque 
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
		$dataProvider = new CActiveDataProvider ( 'Cheque' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Cheque ( 'search' );
		if (isset ( $_GET ['Cheque'] ))
			$model->attributes = $_GET ['Cheque'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionAdminAnulados() {
		$model = new Cheque ();
		$model->anulado = 1;
		if (isset ( $_GET ['Cheque'] ))
			$model->attributes = $_GET ['Cheque'];
		
		$this->render ( 'adminAnulados', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Cheque::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'cheque-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
