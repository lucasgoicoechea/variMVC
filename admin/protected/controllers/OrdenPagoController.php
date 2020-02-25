<?php
class OrdenPagoController extends Controller {
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
								'cuentaCorriente',
								'admin',
								'adminPagas',
								'imprimirOrden',
								'agregarComprobante',
								'agregarComprobantePlano',
								'verComprobante',
								'actualizarTotalesGrales',
								'deleteComprobante',
								'deleteComprobantePlano',
				'delete' 
				),
						'users' => array ('@')
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
				'users' => array ('*')
		)
								);
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function actionCreate() {
		$model = new OrdenPago ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_orden_pago`) as `max` FROM `orden_pago` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->numero_op = $id_lead_new;
		$model->id_orden_pago = $id_lead_new;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['OrdenPago'] )) {
			$model->attributes = $_POST ['OrdenPago'];
			if ( $model->id_proveedor === null || $model->id_proveedor == 0 ){
				$model->addError ('id_proveedor','DEBE INGRESAR UN PROVEEDOR');
			} else {
				$model->pagada = 0;
				$idprov = $model->id_proveedor;
				if ($model->save ()){
					//5 obra - gastos generales
					$pag = Pago::model()->crearNuevoPagoPendiente(5, $model->id_proveedor, $model->id_cuenta, $model->fecha);
					if(!$pag->save()) 
					   {
						   print_r($pop->getErrors());
						   exit();
					   }
					$pop = new PagoOrdenPago();
					$pop->id_pago = $pag->id_pago;
					$pop->id_orden_pago = $model->id_orden_pago;
					if(!$pop->save()) 
					   {
						   print_r($pop->getErrors());
						   exit();
					   }
				}
				$this->redirect ( array (
							'update',
							'id' => $model->id_orden_pago,
							'id_proveedor' => $idprov  
				) );
			}	
		}

		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function  listaComprobantesAPagar($model){
		$gasto = new Gasto();
        $pagoi = OrdenPago::getPago($model->id_orden_pago);
			$this->render ( 'adminGastos', array (
					'gasto' => $gasto,
					'id_orden_pago' => $model->id_orden_pago,
					'model' => $model,
					'id_pago'=> $pagoi!=null?$pagoi->id_pago:null,
					'urlOperationAction' => 'ordenPago/agregarComprobante/' . $_GET ['id_orden_pago'],
					'grillaPosgrados' => 'list_entrevistas',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
							)
							), true);
	}
	public function actionAgregarComprobantePlano() {
		$model = new OrdenPagoGasto ();
		if (isset ( $_GET ['id'] ))
			$model->id_orden_pago = $_GET ['id'];
		if (isset ( $_POST ['OrdenPagoGasto'] ))
			$model->attributes = $_POST ['OrdenPagoGasto'];
		$gasto = new Gasto ();
		$gasto->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Gasto'] ))
			$gasto->attributes = $_GET ['Gasto'];
		$gasto->id_proveedor = PagoOrdenPago::model()->getIDProveedorPorOP($model->id_orden_pago);
		if (isset ( $_POST ['gasto-grid_c0'] )) {
				$seleccionados = $_POST ['gasto-grid_c0'];
				$exito = true;
				foreach ( $seleccionados as $idgastogrid ) {
					//echo "entro con".$idgastogrid;
					$modelOGasto = $this->robarComprobanteAOtraOP($model->id_orden_pago,$idgastogrid);
				    $exito = !$modelOGasto->hasErrors ();
					if ($exito) {
						//echo "fue exito";
						Gasto::model()->agregarEnOP($modelOGasto->id_gasto);
					}
					else {
						//echo "fue exito no-";
						Yii::app ()->user->setFlash ( 'mensaje', $modelOGasto->getErrors () );
						$errores = '';
						foreach ( $modelOGasto->getErrors () as $error )
							$errores = $errores . ' ' . $error;
						return  $errores . $model->id_orden_pago;
					}
				}
				echo "Comprobantes agregados";
				//Yii::app ()->end ();
			}
			$modelop = OrdenPago::model ()->findbyPk ( $model->id_orden_pago );
			$modelop->id_proveedor =$gasto->id_proveedor;
			$this->renderPartial ( 'adminComprobantesCarga', array (
				'model' => $modelop,
     		) );
		}
	
		public function robarComprobanteAOtraOP($id_orden_pago, $idgastogrid){
			$modelOGasto = OrdenPagoGasto::model ()->find(' id_gasto='.$idgastogrid);
			//echo "entro a robar";
			if ($modelOGasto !== null){
				//echo "entro a modelOGAto distinto null";
				//busco op q existe y reaasigno gasto
				$idopexiste = $modelOGasto->id_orden_pago;
				$modelOGasto->id_orden_pago = $id_orden_pago;
				$modelOGasto->save();
				//busco y reasigno pago
				$pagoop = PagoOrdenPago::model ()->find(' id_orden_pago='.$idopexiste);
				$pagoop->id_orden_pago = $id_orden_pago;
				$pagoop->save();
			}
			else {
				
				//echo "entro a modelOGAto igual null";
				$modelOGasto = new OrdenPagoGasto ();
				$modelOGasto->id_orden_pago = $id_orden_pago;
				$modelOGasto->id_gasto = $idgastogrid;
				$modelOGasto->save ();
			}
			 return $modelOGasto;	
			}
				
	public function actionAgregarComprobante() {
		$model = new OrdenPagoGasto ();
		if (isset ( $_GET ['id_orden_pago'] ))
		$model->id_orden_pago = $_GET ['id_orden_pago'];
		if (isset ( $_POST ['OrdenPagoGasto'] ))
		$model->attributes = $_POST ['OrdenPagoGasto'];
		$gasto = new Gasto ();
		$gasto->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Gasto'] ))
		$gasto->attributes = $_GET ['Gasto'];
		$gasto->id_proveedor = PagoOrdenPago::model()->getIDProveedorPorOP($model->id_orden_pago);
		if (! isset ( $_GET ['refresh'] )) {
			// $model= UsuariosEntrevistas::model()->findByPk($_GET['id']);
			if (isset ( $_POST ['gasto-grid_c0'] )) {
				// $model->attributes=$_POST['OrdenPagoGasto'];
				// if($model->saveConMultipleSelect()){
				$seleccionados = $_POST ['gasto-grid_c0'];
				$exito = true;
				foreach ( $seleccionados as $idgastogrid ) {
					$modelOGasto = new OrdenPagoGasto ();
					$modelOGasto->id_orden_pago = $model->id_orden_pago;
					$modelOGasto->id_gasto = $idgastogrid;
					$exito = $modelOGasto->save ();
					if ($exito) {
						Gasto::model()->agregarEnOP($modelOGasto->id_gasto);
					}
					if (! $exito) {
						Yii::app ()->user->setFlash ( 'mensaje', $modelOGasto->getErrors () );
						$errores = '';
						foreach ( $modelOGasto->getErrors () as $error )
						$errores = $errores . ' ' . $error;
						return  $errores . $model->id_orden_pago;
					}
				}
				echo "Comprobantes agregados";
				Yii::app ()->end ();
			}
			if (! empty ( $_GET ['asDialog'] ))
			$this->layout = '//layouts/main';
			$pagoi = OrdenPago::getPago($model->id_orden_pago);
			$this->render ( 'adminGastos', array (
					'gasto' => $gasto,
					'id_orden_pago' => $model->id_orden_pago,
					'model' => $model,
					'id_pago'=> $pagoi!=null?$pagoi->id_pago:null,
					'urlOperationAction' => 'ordenPago/agregarComprobante/' . $_GET ['id_orden_pago'],
					'grillaPosgrados' => 'list_entrevistas',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
							)
							), false );
		} else {
			$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $model->id_orden_pago );
			$montoTotalOP = 0.00;
			if ($resultadosEntrev != null) {
				$this->widget ( 'zii.widgets.CListView', array (
						'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
						'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
						'itemView' => '_viewGasto',
				// 'viewData' => array( 'data' => null ),
						'ajaxUpdate' => false,
				// 'enablePagination'=>true
						'pager' => array (
								'header' => 'Ir a', // text before it
								'maxButtonCount' => 28 
				)
				) );
				$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
				foreach ( $resultados as $value ) {
					$temp = LGHelper::functions ()->unformatNumber( $value->gasto->Monto);
					$montoTotalOP = $montoTotalOP + $temp;
				}
				echo '<div class="contenedor-fila">		<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
						class="contenedor-columna-90">
								<b><label>MONTO TOTAL - ORDEN DE PAGO</label></b> <b>$ '.LGHelper::functions ()->formatNumber( $montoTotalOP).'</b>
							</div>
						</div>';
			} else {
				echo "NO POSEE COMPROBANTES SELECCIONADOS";
			}
		}
	}
	public function actionVerComprobante() {
		$model = new OrdenPagoGasto ();
		if (isset ( $_GET ['direction'] ) && $_GET ['direction']!='up'  )
		{
			if (isset ( $_GET ['id_orden_pago'] ))
			$model->id_orden_pago = $_GET ['id_orden_pago'];
			if (isset ( $_POST ['OrdenPagoGasto'] ))
			$model->attributes = $_POST ['OrdenPagoGasto'];
			$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $model->id_orden_pago );
			$montoTotalOP = 0.00;
			if ($resultadosEntrev != null) {
				$this->widget ( 'zii.widgets.CListView', array (
						'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
						'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
						'itemView' => '_viewGastoRow',
				// 'viewData' => array( 'data' => null ),
						'ajaxUpdate' => false,
				// 'enablePagination'=>true
						'pager' => array (
								'header' => 'Ir a', // text before it
								'maxButtonCount' => 28 
				)
				) );
				$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
				foreach ( $resultados as $value ) {
					$montoTotalOP = $montoTotalOP + $value->gasto->Monto;
				}
				echo '<div class="contenedor-fila">		<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
						class="contenedor-columna-90">
								<b><label>MONTO TOTAL - ORDEN DE PAGO</label></b> <b>$ '.LGHelper::functions ()->formatNumber($montoTotalOP).'</b>
							</div>
						</div>';
			} else {
				echo "NO POSEE COMPROBANTES SELECCIONADOS";
			}
		}
		else echo "";

	}

	public function actionUpdate() {
		$model = $this->loadModel ();

		//$this->layout = "//layouts/column1";
		$this->performAjaxValidation ( $model );

		if (isset ( $_POST ['OrdenPago'] )) {
			$model->attributes = $_POST ['OrdenPago'];

			if ($model->save ())
			$this->redirect ( array (
						'view',
						'id' => $model->id_orden_pago 
			) );
		}

		$this->render ( 'update', array (
				'model' => $model,
				'id_orden_pago' => $model->id_orden_pago 
		) );
	}

	public function actionCuentaCorriente() {
		//$model = $this->loadModel ();
		$model = new OrdenPago();
		$this->layout = "//layouts/column1";
		$this->performAjaxValidation ( $model );

		if (isset ( $_POST ['OrdenPago'] )) {
			$model->attributes = $_POST ['OrdenPago'];
		}

		$this->render ( 'cuentaCorriente', array (
				'model' => $model,
		) );
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$op = $this->loadModel ();
			if ($op->validarParaBorrar()) {
				//sino tiene pago el validar da true
				//y paso a borrar OrdenPagoGasto y la OP
				$op->borrarComprobantes();
				$op->delete ();
				echo "<div class='flash-success'>ORDEN DE PAGO ELIMINADA</div>";
			}
			else  {
				echo "<div class='flash-error'>NO SE PUEDE BORRAR, TIENE UN PAGO ASOCIADO</div>";
			}

			if (! isset ( $_GET ['ajax'] ))
			$this->redirect ( array (
						'index' 
						) );
		} else
		throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionDeleteComprobante() {
		$modelo = null;
		$model = new OrdenPagoGasto ();
		if (! isset ( $_GET ['refresh'] )) {
			if ($modelo === null) {
				if (isset ( $_GET ['id'] ))
				$modelo = OrdenPagoGasto::model ()->findbyPk ( $_GET ['id'] );
				if ($modelo === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
			}
			if ($modelo != null) {
				$model = OrdenPago::model ()->findbyPk ( $modelo->id_orden_pago );
				$modelo->delete ();
				Gasto::model()->sacarEnOP($modelo->id_gasto);
			}
			$this->layout = '//layouts/main';
			$this->render ( 'deleteGastos', array (
					'id_orden_pago' => $model->id_orden_pago,
					'model' => $model,
					'urlOperationAction' => 'ordenPago/deleteComprobante/' . $_GET ['id'],
					'grillaPosgrados' => 'list_entrevistas',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px"
							)
							), false );
		} else {
			$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $_GET ['id_orden_pago'] );
			$montoTotalOP = 0.00;
			if ($resultadosEntrev != null) {
				$this->widget ( 'zii.widgets.CListView', array (
						'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
						'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
						'itemView' => '_viewGasto',
				// 'viewData' => array( 'data' => null ),
						'ajaxUpdate' => false,
				// 'enablePagination'=>true
						'pager' => array (
								'header' => 'Ir a', // text before it
								'maxButtonCount' => 28 
				)
				) );
				$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO (  $_GET ['id_orden_pago'] );
				foreach ( $resultados as $value ) {
					$temp = LGHelper::functions ()->unformatNumber($value->gasto->Monto);
					$montoTotalOP = $montoTotalOP + $temp;
				}
				echo '<div class="contenedor-fila">		<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
						class="contenedor-columna-90">
								<b><label>MONTO TOTAL - ORDEN DE PAGO</label></b> <b>$ '.LGHelper::functions ()->formatNumber($montoTotalOP).'</b>
							</div>
						</div>';
			} else {
				echo "NO POSEE COMPROBANTES SELECCIONADOS";
			}
		}
		/*
		 * if (! isset ( $_GET ['ajax'] )) $this->redirect ( array ( 'index' ) );
		 */
	}
	public function actionDeleteComprobantePlano() {
		$modelo = null;
		$IDOP = null;
		$gasto  = null;
		if ($modelo === null) {
			if (isset ( $_GET ['id'] )){
				$modelo = OrdenPagoGasto::model ()->findbyPk ( $_GET ['id'] );
			}
			if ($modelo === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'El comprobante YA FUE BORRADO, REFRESCA LA PAGINA.' ) );
		}
		if ($modelo != null) {
			$IDOP = $modelo->id_orden_pago;
			$gasto = Gasto::model ()->findByPk ( $modelo->id_gasto );			
			Gasto::model()->sacarEnOP($modelo->id_gasto);
			$modelo->delete ();
		}
		$modelop = OrdenPago::model ()->findbyPk ( $IDOP);
		$modelop->id_proveedor =$gasto->id_proveedor;
		$this->renderPartial ( 'adminComprobantesCarga', array (
							'model' => $modelop,
		) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'OrdenPago' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new OrdenPago ( 'search' );
		if (isset ( $_GET ['OrdenPago'] ))
		$model->attributes = $_GET ['OrdenPago'];

		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
			$this->_model = OrdenPago::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
			 throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
			else { 
			if (isset ( $_GET ['id_proveedor'] ))
			   $this->_model->id_proveedor= $_GET ['id_proveedor'];
			}    
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'orden-pago-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionAdminPagas() {
		$model = new OrdenPago ( 'search' );
		$model->pagada = 1;
		if (isset ( $_GET ['OrdenPago'] ))
		$model->attributes = $_GET ['OrdenPago'];

		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionImprimirOrden() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION ORDEN DE PAGO';
		$html = $this->renderPartial ( 'ordenImpresion', array (
				'titulo' => $titulo,
				'model' => $model 
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function actionActualizarTotalesGrales() {
		$idPago = $_GET ['id_orden_pago'];
		$this->actualizarTotalesGrales ( $idPago );
	}
	public function actualizarTotalesGrales($idordenPago) {
		$op = OrdenPago::model ()->findByPk ( $idordenPago );
		$montoTotalPAGAR = 0.00;
		$montoTotalPAGAR = $montoTotalPAGAR + $op->getMonto ();
		$montoTotalPAGADO = $op->getPago ($op->id_orden_pago)!=null?$op->getPago ($op->id_orden_pago)->getMontoPagado():0.00;
		
		$html =  '<div class="contenedor-fila">	<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
			class="contenedor-columna"><b><label>TOTAL A PAGAR</label></b> <b>$ ';
		$html= $html . $montoTotalPAGAR  . '</b>';
		$html= $html . ' 		</div>	<div 	style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
					class="contenedor-columna">
					<b><label>TOTAL PAGADO</label></b> <b>$ ';
		$html= $html .  $montoTotalPAGADO  . '</b>';
		$html= $html .	'</div>	</div>	</div>';
		echo  $html;
	}
}
