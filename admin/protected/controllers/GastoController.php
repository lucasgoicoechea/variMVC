<?php
// hago esto pq el buscar se me satura
set_time_limit (55550);
//set_time_limit (0);
//ini_set('memory_limit', '-1');
ini_set ( 'memory_limit', '124M' );
class GastoController extends Controller {
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
								'adminFiltros',
								'adminFacturas',
								'adminComprobantes',
								'cambiarComprobante',
								'cambiarComprobanteSinBoton',
								'cambiarComprobantePagado',
								'cambiarComprobanteContratoPagado',
								'imprimirComprobante',
								'imprimirComprobanteContrato',
								'updatePagado',
								'createPagado',
								'createPendiente',
								'createContratoPagado',
								'updateContratoPagado',
								'modificarCheque',
								'agregarRetencionGasto',
								'agregarDetalleItem',
								'agregarNuevaRetencion',
								'valoresByRetPercep',
								'calcularTotalGasto',
								'calcularTotalGastoPagado',
								'createContratoPagado',
								'exportar',
								'balanceMensuales',
								'delete',
								'gastosPorObra',
								'gastosMAAjax',
								'exportarSinPaginas',
								'gastosPorObraAjax',
								'updatePrePagado',
								'listarSubcontratos',
								'imprimirGastosPorObraPages',
								'imprimirGastosPorObra' ,
								'borrarGastoContrato',
								'createPagadoConMedio',
								'cambiarComprobantePagadoSinBoton',
								'updatePagadoConMedio'
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
		$model = new Gasto ();
		$model->Monto = 0.00;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->Codigo = $id_lead_new;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			/*
			 * $caja = Caja::model ()->getPorFecha ( $model->FechaAsiento );
			 * if ($caja->cerrada == 1) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			if ($model->save ()) {
				// $model->agregarRetencionesPercepciones ();
				if ($model->tipoComprobante->iva_iibb_fijados) {
					$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
				}
				$this->redirect ( array (
						'update',
						'id' => $model->id_gasto 
				) );
			}
			// }
		}
		
		$this->render ( 'create', array (
				'model' => $model,
				'formulario' => '_form',
				'labelBotonSummit' => 'Guardar y Agregar Retenciones/Percepciones' 
		) );
	}
	public function actionCreatePagado($id_exito = null) {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		$modelPago = new Pago ();
		// $idCuenta = isset($_POST ['Pago'] ['id_cuenta'])?$_POST ['Pago'] ['id_cuenta']:null;
		/*
		 * if ($idCuenta == null || $idCuenta == 0) {
		 * $idCuenta = 1; // SETEA facturas a Pagar
		 * }
		 */
		// $modelPago->id_cuenta=$idCuenta;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_ + 1;
		$model->Codigo = $id_lead_new;
		$this->performAjaxValidation ( $model );
		if (isset ( $_POST ['Gasto'] )) {
			
			$id_exito = null;
			$model->attributes = $_POST ['Gasto'];
			$model->id_contrato_cabecera = $_POST ['Gasto']['id_contrato_cabecera'];
			if (! $model->existeComprobante ()) {
				//$model->pagada = 1;
				$model->pagada = 0;
				$model->en_orden_pago =0;
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
				// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
				$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
				$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
				
				if ($model->id_tipo_comprobante == 18) {
					$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
					$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
				}
				
				$idCuenta = $_POST ['Pago'] ['id_cuenta'];
				if ($idCuenta == null || $idCuenta == 0) {
					$idCuenta = 1; // SETEA facturas a Pagar
				}
				$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
				$modelPago->id_cuenta = $idCuenta;
				$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
				// Guardar el gasto
				if ($model->save ()) {
					// $model->agregarRetencionesPercepciones ();
					if ($model->tipoComprobante->iva_iibb_fijados) {
						$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
					}
					
					$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
					$newOP->id_cuenta = $idCuenta;
					// Crear un numero de OP
					if ($newOP->save ()) {
						$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
						$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
						// crear un Pago
						if ($pago->save ()) {
							// unir el gasto con la op
							$opGasto = new OrdenPagoGasto ();
							$opGasto->id_orden_pago = $newOP->id_orden_pago;
							$opGasto->id_gasto = $model->id_gasto;
							if ($opGasto->save ()) {
								$pagoOP = new PagoOrdenPago ();
								$pagoOP->id_orden_pago = $newOP->id_orden_pago;
								$pagoOP->id_pago = $pago->id_pago;
								// unir la op con el pago
								// poner todo en pagado=true
								if ($pagoOP->save ()) {
									$this->redirect ( array (
											'updatePagado',
											'id' => $model->id_gasto 
									) );
								} else
									echo "<p class='error'>Fallo al unir el Pago a la OP</p>";
							} else
								echo "<p class='error'>Fallo al relacionar el Comprobante a la OP</p>";
						} else
							echo "<p class='error'>Fallo al relacionar el Comprobante a la OP</p>";
					} else
						echo "<p class='error'>Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () ) . "</p>";
				}
			} else {
				echo "<p class='error'>Ya existe un Comprobante con ese Número para ese Proveedor</p>";
			}
			// }
		}
		
		$this->render ( 'createPagado', array (
				'model' => $model,
				'readOnlyContrato' => true,
				'formulario' => '_form',
				'id_exito' => $id_exito,
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		) );
	}
	public function actionCreatePagadoConMedio($id_exito = null) {
		$model = new Gasto ();
		$modelPago = new Pago ();
		// $idCuenta = isset($_POST ['Pago'] ['id_cuenta'])?$_POST ['Pago'] ['id_cuenta']:null;
		/*
		* if ($idCuenta == null || $idCuenta == 0) {
		* $idCuenta = 1; // SETEA facturas a Pagar
		* }
		*/
		// $modelPago->id_cuenta=$idCuenta;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
				$this->performAjaxValidation ( $model );
				if (isset ( $_POST ['Gasto'] ) && $_POST ['Gasto']['id_tipo_comprobante']!="") {
							
				$id_exito = null;
				$model->attributes = $_POST ['Gasto'];
				$medioPagoForm = new MedioPagoForm();
				$model->id_contrato_cabecera = $_POST ['Gasto']['id_contrato_cabecera'];
				if ($model->validate() && !$model->existeComprobante ()) {
					$model->pagada = 1;
					$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
					$id_lead_new = $id_lead_last + 1;
					$model->Codigo = $id_lead_new;
					// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
					$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
					$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
	
					if ($model->id_tipo_comprobante == 18) {
						$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
						$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
					}
	
					$idCuenta = $_POST ['Pago'] ['id_cuenta'];
					if ($idCuenta == null || $idCuenta == 0) {
						$idCuenta = 1; // SETEA facturas a Pagar
					}
					$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
					$modelPago->id_cuenta = $idCuenta;
					$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
					// Guardar el gasto
					if ($model->save ()) {
						// $model->agregarRetencionesPercepciones ();
						if ($model->tipoComprobante->iva_iibb_fijados) {
							$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
						}
							
						$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
						$newOP->id_cuenta = $idCuenta;
						// Crear un numero de OP
						if ($newOP->save ()) {
							$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
							$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
							// crear un Pago
							if ($pago->save ()) {
								// unir el gasto con la op
								$opGasto = new OrdenPagoGasto ();
								$opGasto->id_orden_pago = $newOP->id_orden_pago;
								$opGasto->id_gasto = $model->id_gasto;
								if ($opGasto->save ()) {
									$pagoOP = new PagoOrdenPago ();
									$pagoOP->id_orden_pago = $newOP->id_orden_pago;
									$pagoOP->id_pago = $pago->id_pago;
									// unir la op con el pago
									// poner todo en pagado=true
									if ($pagoOP->save ()) {
										$medioPagoForm->detalle = $_POST ['MedioPagoForm']['detalle'];
										$medioPagoForm->monto = $_POST ['MedioPagoForm']['monto'];
										$medioPagoForm->saveMedioPago($pago->id_pago);										
										/*$this->redirect ( array (
												'updatePagadoConMedio',
												'id' => $model->id_gasto
										) );*/
										$this->redirect ( array (
												'updatePagado',
												'id' => $model->id_gasto
										) );
									} else
										echo "<p class='error'>Fallo al unir el Pago a la OP</p>";
								} else
									echo "<p class='error'>Fallo al relacionar el Comprobante a la OP</p>";
							} else
								echo "<p class='error'>Fallo al relacionar el Comprobante a la OP</p>";
						} else
							echo "<p class='error'>Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () ) . "</p>";
					}
				} else {
					echo "<p class='error'>Ya existe un Comprobante con ese Número para ese Proveedor</p>";
				}
				// }
				}
	
				$this->render ( 'createPagadoConMedio', array (
						'model' => $model,
						'readOnlyContrato' => true,
						'formulario' => '_form',
						'id_exito' => $id_exito,
						'modelPago' => $modelPago,
						'labelBotonSummit' => 'Pagar'
				) );
		}
	public function actionCreatePendiente($id_exito = null) {
		$model = new Gasto ();
		$modelPago = new Pago ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->Codigo = $id_lead_new;
		$modelPago->id_cuenta = 1; // fuerza defecto facturas a pagar.
		$this->performAjaxValidation ( $model );
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			$model->pagada = 0;
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			/*
			 * $caja = Caja::model ()->getPorFecha ( $model->FechaAsiento );
			 * if ($caja->cerrada == 1) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			// Guardar el gasto
			if ($model->save ()) {
				// $model->agregarRetencionesPercepciones ();
				if ($model->tipoComprobante->iva_iibb_fijados) {
					$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
				}
				$idCuenta = $_POST ['Pago'] ['id_cuenta'];
				if ($idCuenta == null || $idCuenta == 0) {
					$idCuenta = 1; // SETEA facturas a Pagar
				}
				$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
				$newOP->id_cuenta = $idCuenta;
				// Crear un numero de OP
				
				if ($newOP->save ()) {
					$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
					$pago = Pago::model ()->crearNuevoPagoPendiente ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
					// crear un Pago
					if ($pago->save ()) {
						// unir el gasto con la op
						$opGasto = new OrdenPagoGasto ();
						$opGasto->id_orden_pago = $newOP->id_orden_pago;
						$opGasto->id_gasto = $model->id_gasto;
						if ($opGasto->save ()) {
							$pagoOP = new PagoOrdenPago ();
							$pagoOP->id_orden_pago = $newOP->id_orden_pago;
							$pagoOP->id_pago = $pago->id_pago;
							// unir la op con el pago
							// poner todo en pagado=true
							if ($pagoOP->save ()) {
								
								$this->redirect ( array (
										'updatePagado',
										'id' => $model->id_gasto 
								) );
							} else
								echo "Fallo al unir el Pago a la OP";
						} else
							echo "Fallo al relacionar el Comprobante a la OP";
					} else
						echo "Fallo al relacionar el Comprobante a la OP";
				} else
					echo "Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () );
			}
			// }
		}
		
		$this->render ( 'createPagado', array (
				'model' => $model,
				'readOnlyContrato' => true,
				'id_exito' => $id_exito,
				'formulario' => '_form',
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		) );
	}
	public function actionUpdatePrePagado() {
		$model = new Gasto ();
		$model = $this->loadModel ();
		$modelPago = new Pago ();
		$this->performAjaxValidation ( $model );
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			$model->pagada = 1;
			$model->pagada = 1;
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			// $caja = Caja::model ()->getPorFecha ( $model->FechaAsiento );
			/*
			 * $caja = Caja::model ()->getByID ( $model->caja_id );
			 * if ($caja->cerrada == 1 && $model->tienePago()) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			// Guardar el gasto
			if ($model->save ()) {
				// $model->agregarRetencionesPercepciones ();
				if ($model->tipoComprobante->iva_iibb_fijados) {
					$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
				}
				$idCuenta = $_POST ['Pago'] ['id_cuenta'];
				if ($idCuenta == null || $idCuenta == 0) {
					$idCuenta = 1; // SETEA facturs a pagar
				}
				$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
				$newOP->id_cuenta = $idCuenta;
				// Crear un numero de OP
				
				if ($newOP->save ()) {
					$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
					$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
					// crear un Pago
					if ($pago->save ()) {
						// unir el gasto con la op
						$opGasto = new OrdenPagoGasto ();
						$opGasto->id_orden_pago = $newOP->id_orden_pago;
						$opGasto->id_gasto = $model->id_gasto;
						if ($opGasto->save ()) {
							$pagoOP = new PagoOrdenPago ();
							$pagoOP->id_orden_pago = $newOP->id_orden_pago;
							$pagoOP->id_pago = $pago->id_pago;
							// unir la op con el pago
							// poner todo en pagado=true
							if ($pagoOP->save ()) {
								
								$this->redirect ( array (
										'updatePagado',
										'id' => $model->id_gasto 
								) );
							} else
								echo "Fallo al unir el Pago a la OP";
						} else
							echo "Fallo al relacionar el Comprobante a la OP";
					} else
						echo "Fallo al relacionar el Comprobante a la OP";
				} else
					echo "Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () );
			}
			// }
		}
		
		$this->render ( 'createPagado', array (
				'model' => $model,
				'readOnlyContrato' => true,
				'formulario' => '_form',
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		) );
	}
	public function actionCreateContratoPagado() {
		$model = new Gasto ();
		$modelPago = new Pago ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->Codigo = $id_lead_new;
		$this->performAjaxValidation ( $model );
		if (isset ( $_GET ['id_contrato_cabecera'] )) {
			$model->contratoCabecera = ContratoCabecera::model ()->findbyPk ( $_GET ['id_contrato_cabecera'] );
			$model->id_contrato_cabecera = $model->contratoCabecera->id_contrato_cabecera;
			$model->id_tipo_comprobante = 5; // _formComprobante
			$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
			$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			if (! isset ( $_POST ['Gasto'] )) {
				$model->Detalle = 'Pago de SubContrato a: ' . $model->proveedor->Nombre . ', POR OBRA:' . $model->obra->getDescripcion ();
			}
		}
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			$model->pagada = 1;
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			/*
			 * $caja = Caja::model ()->getPorFecha ( $model->FechaAsiento );
			 * if ($caja->cerrada == 1) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			
			/*if($model->contratoCabecera->getPrecioMasAdicionales()<$model->Monto){
			   $model->addError ( 'Monto', 'El monto supera el Precio del Subcontrato' );
			}*/
			
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			$idCuenta = $_POST ['Pago'] ['id_cuenta'];
			//echo $_POST ['Pago'] ['id_cuenta'].'k';
			if (!isset($_POST ['Pago'] ['id_cuenta']) || $idCuenta==null){
				$model->addError ( 'DEBE INGRESAR LA CUENTA A IMPUTAR', 'Debe Ingresar su Cuenta donde imputa el Pago del Gasto' );
			}
			else {
			// Guardar el gasto
				if ($model->save ()) {
					// $model->agregarRetencionesPercepciones ();
					if ($model->tipoComprobante->iva_iibb_fijados) {
						$this->generateRetencionIVA ( $model->id_gasto, $model->Monto );
					}
					
					$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
					$newOP->id_cuenta = $idCuenta;
					// Crear un numero de OP
					
					if ($newOP->save ()) {
						$fechaCobro = $_POST ['Pago'] ['fecha_cobro'];
						$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
						// crear un Pago
						if ($pago->save ()) {
							// unir el gasto con la op
							$opGasto = new OrdenPagoGasto ();
							$opGasto->id_orden_pago = $newOP->id_orden_pago;
							$opGasto->id_gasto = $model->id_gasto;
							if ($opGasto->save ()) {
								$pagoOP = new PagoOrdenPago ();
								$pagoOP->id_orden_pago = $newOP->id_orden_pago;
								$pagoOP->id_pago = $pago->id_pago;
								// unir la op con el pago
								// poner todo en pagado=true
								if ($pagoOP->save ()) {
									
									$this->redirect ( array (
											'updateContratoPagado',
											'id' => $model->id_gasto 
									) );
								} else
									echo "Fallo al unir el Pago a la OP";
							} else
								echo "Fallo al relacionar el Comprobante a la OP";
						} else
							echo "Fallo al relacionar el Comprobante a la OP";
					} else
						echo "Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () );
				}
				// }
		}
		}
		
		$this->render ( 'createContratoPagado', array (
				'model' => $model,
				'readOnlyContrato' => true,
				'formulario' => '_form',
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		) );
	}
	public function actionCambiarComprobantePagado() {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			if ($model->Codigo == null) {
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
			}
		}
		$modelPago = new Pago ();
		// $modelPago->id_cuenta = 1;
		if (isset ( $_POST ['Pago'] )) {
			$modelPago->attributes = $_POST ['Pago'];
		}
		$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
		echo $this->renderPartial ( $formulario, array (
				'model' => $model,
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		), 
				// 'form' => $form
				false, true );
	}
	public function actionCambiarComprobantePagadoSinBoton() {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			if ($model->Codigo == null) {
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
			}
		}
		$modelPago = new Pago ();
		// $modelPago->id_cuenta = 1;
		if (isset ( $_POST ['Pago'] )) {
			$modelPago->attributes = $_POST ['Pago'];
		}
		$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
		echo $this->renderPartial ( $formulario, array (
				'model' => $model,
				'modelPago' => $modelPago,
				'labelBotonSummit' => '--',
				'sinBoton' =>true
		),
				// 'form' => $form
				false, true );
	}
	public function actionCambiarComprobanteContratoPagado() {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			if ($model->Codigo == null) {
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
			}
		}
		$modelPago = new Pago ();
		if (isset ( $_POST ['Pago'] )) {
			$modelPago->attributes = $_POST ['Pago'];
		}
		$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
		echo $this->renderPartial ( $formulario, array (
				'model' => $model,
				'subcontrato' => true,
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Pagar' 
		), 
				// 'form' => $form
				false, true );
	}
	public function actionCambiarComprobante() {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			if ($model->Codigo == null) {
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
			}
		}
		$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
		echo $this->renderPartial ( $formulario, array (
				'model' => $model,
				'labelBotonSummit' => 'Guardar y Agregar Retenciones/Percepciones' 
		), 
				// 'form' => $form
				false, true );
	}
	public function actionCambiarComprobanteSinBoton() {
		$model = new Gasto ();
		$model->Monto = LGHelper::functions ()->formatNumber (0.00);
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			if ($model->Codigo == null) {
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
			}
		}
		$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
		echo $this->renderPartial ( $formulario, array (
				'model' => $model,
				'sinBoton' => true,
				'labelBotonSummit' => 'Guardar y Agregar Retenciones/Percepciones' 
		), 
				// 'form' => $form
				false, true );
	}
	public function actionImprimirComprobante() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION COMPROBANTE DE COMPRA';
		$html = $this->renderPartial ( 'gastoImpresion', array (
				'titulo' => $titulo,
				'model' => $model 
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function actionImprimirComprobanteContrato() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION COMPROBANTE DE PAGO DE SUBCONTRATO';
		$html = $this->renderPartial ( 'gastoImpresionSubcontrato', array (
				'titulo' => $titulo,
				'model' => $model,
				'contrato' => $model->getContrato () 
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function actionBorrarGastoContrato() {
		$model = $this->loadModel ();
		//$model->borrarGastoContrato();
		//COMENTO EL SIGUIENTE IF 5/7/18 porque se borra todo
		$model->borrarGastoConOPyPagos();
		exit ();
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		if ($model->pagada == 1 && $model->tienePago ()) {
			$this->redirect ( array (
					'updatePagado',
					'id' => $model->id_gasto 
			) );
		}
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			// $caja = Caja::model ()->getPorFecha ( LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento ) );
			/*
			 * $caja = Caja::model ()->getByID ($model->caja_id);
			 * if ($caja->cerrada == 1) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
				//echo $model->id_obra . 'dd';
				// Yii::app()->end();
			}
			if ($model->save ()) {
				// $model->actualizarRetencionesPercepciones();
				$this->redirect ( array (
						'view',
						'id' => $model->id_gasto 
				) );
			}
			// }
		}
		$this->render ( 'update', array (
				'model' => $model,
				'formulario' => '_form',
				'labelBotonSummit' => 'Guardar' 
		) );
	}
	public function actualizarTotalesGrales($idPago) {
		$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $idPago );
		$montoTotalPAGAR = 0;
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalPAGAR = $montoTotalPAGAR + $value->ordenPago->getMonto ();
			}
		}
		$montoTotalPAGADO = Pago::model ()->getMontoPagadoID ( $idPago );
		echo '<div class="contenedor-fila">	<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
			class="contenedor-columna">
			<b><label>TOTAL A PAGAR</label></b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalPAGAR ) . '</b>
				</div>	<div
					style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
					class="contenedor-columna">
					<b><label>TOTAL PAGADO</label></b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalPAGADO ) . '</b>
				</div>	</div>	</div>';
	}
	public function actionUpdatePagado() {
		$model = $this->loadModel ();
		// echo $model->getPago()->id_pago;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			$modelPago = $model->getPago ();
			$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
			$modelPago->id_cuenta = $_POST ['Pago'] ['id_cuenta'];
			
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			if ($model->save ()) {
				if (isset ( $_POST ['Pago'] )) {
					$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
					$modelPago = $model->getPago ();
					$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
					$modelPago->id_cuenta = $_POST ['Pago'] ['id_cuenta'];
					$modelPago->save ();
				}
				$this->redirect ( array (
						'createPagado',
						'id_exito' => $model->id_gasto 
				) );
			}
			// }
		}
		$modelPago = $model->getPago ();
		$model->id_pago = $modelPago->id_pago;
		
		$this->render ( 'updatePagado', array (
				'model' => $model,
				'formulario' => '_form',
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Guardar' 
		) );
	}
	public function actionUpdatePagadoConMedio() {
		$model = $this->loadModel ();
		// echo $model->getPago()->id_pago;
		$this->performAjaxValidation ( $model );
	
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			$modelPago = $model->getPago ();
			$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
			$modelPago->id_cuenta = $_POST ['Pago'] ['id_cuenta'];
				
			if ($model->id_tipo_comprobante == 18) {
				$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
				$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			}
			if ($model->save ()) {
				if (isset ( $_POST ['Pago'] )) {
					$fechaCobro = LGHelper::functions ()->undisplayFecha ( $_POST ['Pago'] ['fecha_cobro'] );
					$modelPago = $model->getPago ();
					$modelPago->fecha_cobro = $_POST ['Pago'] ['fecha_cobro'];
					$modelPago->id_cuenta = $_POST ['Pago'] ['id_cuenta'];
					$modelPago->save ();
				}
				$this->redirect ( array (
						'createPagado',
						'id_exito' => $model->id_gasto
				) );
			}
			// }
		}
		$modelPago = $model->getPago ();
		$model->id_pago = $modelPago->id_pago;
	
		$this->render ( 'createPagadoConMedio', array (
				'model' => $model,
				'formulario' => '_form',
				'modelPago' => $modelPago,
				'labelBotonSummit' => 'Guardar'
		) );
	}
	public function actionUpdateContratoPagado() {
		$model = $this->loadModel ();
		// echo $model->getPago()->id_pago;
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Gasto'] )) {
			$model->attributes = $_POST ['Gasto'];
			// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
			$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $model->FechaFactura );
			$model->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $model->FechaAsiento );
			/*
			 * $caja = Caja::model ()->getByID ( $model->caja_id );
			 * if ($caja->cerrada == 1) {
			 * $model->addError ( 'CAJA DIARIA CERRADA', 'No se puede modificar este Comprobante porque la Caja del ' . $caja->fecha . ' ESTA CERRADA' );
			 * } else {
			 */
			$model->id_obra = $model->contratoCabecera != null ? $model->contratoCabecera->id_obra : null;
			$model->id_proveedor = $model->contratoCabecera != null ? $model->contratoCabecera->id_proveedor : null;
			if ($model->save ()) {
				// $model->actualizarRetencionesPercepciones();
				$this->redirect ( array (
						'updateContratoPagado',
						'id' => $model->id_gasto 
				) );
			}
			// }
		}
		$model->id_pago = $model->getPago ()->id_pago;
		$this->render ( 'updateContratoPagado', array (
				'model' => $model,
				'formulario' => '_form',
				'labelBotonSummit' => 'Guardar' 
		) );
	}
	public function actionModificarCheque() {
		$model = new Cheque ();
		if (isset ( $_GET ['id_pago'] ))
			$idPago = $_GET ['id_pago'];
		else
			echo "ALGO SIN ID PAGO";
		if (isset ( $_GET ['id_cheque'] )) {
			$model = Cheque::model ()->findbyPk ( $_GET ['id_cheque'] );
		}
		if ($model === null) {
			throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		} else {
			// $model->a_la_orden= $_GET['Cheque[a_la_orden]'];
			$model->attributes = $_GET ['Cheque'];
			// echo $idPago;
			if ($model->save ()) {
				$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $idPago );
				$montoTotalCheque = 0.00;
				if ($resultadosEntrev != null) {
					$this->widget ( 'zii.widgets.CListView', array (
							'dataProvider' => $resultadosEntrev,
							'summaryText' => '<div class="header"> Cantidad de Cheques: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
							'itemView' => '_viewCheque',
							'ajaxUpdate' => false,
							'pager' => array (
									'header' => 'Ir a', // text before it
									'maxButtonCount' => 28 
							) 
					) );
					$resultados = PagoCheque::model ()->searchWithPagoOO ( $idPago );
					foreach ( $resultados as $value ) {
						$montoTotalCheque = $montoTotalCheque + LGHelper::functions ()->unformatNumber ( $value->cheque->Importe );
					}
				}
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalCheque ) . '</b></div></div>';
			} else
				echo 'Error al registrar el cheque: ' . $model->errors ();
		}
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$modeo = $this->loadModel ();
			//COMENTO EL SIGUIENTE IF 5/7/18 porque se borra todo
			//if ($modeo->isPagada ())
				//throw new CHttpException ( 400, Yii::t ( 'app', 'No se puede borrar un Comprobante Pagado' ) );
				if ($modeo->contrato!=null){
					$modeo->contrato->delete();
				}
				if ($modeo->quincena!=null){
					$modeo->quincena->delete();
				}
				$modeo->borrarGastoConOPyPagos();		
			//$modeo->delete ();
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Gasto' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAgregarDetalleItem() {
		$model = new GastoItem ();
		if (isset ( $_GET ['GastoItem'] )) {
			$model->attributes = $_GET ['GastoItem'];
			$model->id_gasto = $_GET ['id_gasto'];
			$model->id_obra = $_GET ['id_obra'];
			$model->id_proveedor = $_GET ['id_proveedor'];
			if ($model->save ())
				echo "Detalle Registrado con Exito";
			else
				echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
		} 
	}
	
		public function actionAgregarRetencionGasto() {
		$model = new GastoRetencionPercepcion ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$montoTotalRetenciones = Gasto::model ()->getTotalMontoRetenciones ( $_GET ['id_gasto'] );
			echo '<div class="contenedor-fila">			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - RETENCIONES/PERCEPCIONE</label></b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalRetenciones ) . '</b>
			</div>		</div>';
		} else {
			if (isset ( $_GET ['GastoRetencionPercepcion'] )) {
				$model->attributes = $_GET ['GastoRetencionPercepcion'];
				if (isset ( $_GET ['id_gasto'] )) {
					$model->id_gasto = $_GET ['id_gasto'];
					$gasto = Gasto::model ()->findByPK ( $model->id_gasto );
					$retencion = RetencionPercepcion::model ()->findByPK ( $model->id_retencion_percepcion );
					if (isset ( $_GET ['GastoRetencionPercepcion'] ['otroValor'] ) && $_GET ['GastoRetencionPercepcion'] ['otroValor'] > 0) {
						$model->valor = $_GET ['GastoRetencionPercepcion'] ['otroValor'];
						RetencionPercepcionValores::model ()->crearNuevaRetPercepValor ( $model->id_retencion_percepcion, $model->valor );
					}
					if ($retencion->es_porcentaje) {
						$porcentaje = 0;
						if ($gasto->Monto > 0 && $model->valor > 0)
							$porcentaje = $gasto->Monto / 100 * $model->valor;
						$model->alicuota = $porcentaje;
					} else
						$model->alicuota = $model->valor;
				}
				if ($model->save ())
					echo "Retención/Percepción Registrada";
				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}
	public function generateRetencionIVA($id_gasto, $monto) {
		$modelRPGasto = new GastoRetencionPercepcion ();
		$modelRPGasto->id_gasto = $id_gasto;
		// HARDCODE DE IVA
		$modelRPGasto->id_retencion_percepcion = 1;
		$porcentaje = 0;
		if ($monto > 0)
			$porcentaje = $monto / 100 * 21;
		$modelRPGasto->alicuota = $porcentaje;
		$modelRPGasto->valor = 21;
		$modelRPGasto->save ();
	}
	public function actionCalcularTotalGasto() {
		if (isset ( $_GET ['id_gasto'] )) {
			$gasto = Gasto::model ()->findByPK ( $_GET ['id_gasto'] );
			if (isset ( $_GET ['neto_tmp'] )) {
				$gasto->Monto = $_GET ['neto_tmp'];
				$gasto->save ();
			}
			echo '<div 	style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 750px; text-align: center; padding: 5px;"
							class="contenedor-columna"><b><label>TOTAL</label></b> <b>$ ' . LGHelper::functions ()->formatNumber ( $gasto->getMontoTotal () ) . '</b></div>';
		}
	}
	public function actionCalcularTotalGastoPagado() {
		if (isset ( $_GET ['id_gasto'] )) {
			$gasto = Gasto::model ()->findByPK ( $_GET ['id_gasto'] );
			if (isset ( $_GET ['neto_tmp'] )) {
				$gasto->Monto = $_GET ['neto_tmp'];
				$gasto->save ();
			}
			//
			$idPago = $gasto->getPago ()->id_pago;
			$this->actualizarTotalesGrales ( $idPago );
		}
	}
	public function actionAgregarNuevaRetencion() {
		$model = new RetencionPercepcion ();
		$modelRPGasto = new GastoRetencionPercepcion ();
		$modelRPGasto->valor = 0;
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$montoTotalRetenciones = Gasto::model ()->getTotalMontoRetenciones ( $_GET ['id_gasto'] );
			echo '<div class="contenedor-fila">			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - RETENCIONES/PERCEPCIONES</label></b> <b>$ ' . LGHelper::functions ()->formatNumber ( $montoTotalRetenciones ) . '</b>
			</div>		</div>';
		} else {
			if (isset ( $_GET ['RetencionPercepcion'] )) {
				$model->attributes = $_GET ['RetencionPercepcion'];
				if (isset ( $_GET ['id_gasto'] )) {
					$modelRPGasto->id_gasto = $_GET ['id_gasto'];
					// $modelRPGasto->valor = $model->valor_fijo;
					$gasto = Gasto::model ()->findByPK ( $modelRPGasto->id_gasto );
					// if (! isset ( $model->valor_fijo ) && $model->impuesto_fijo)
					// $modelRPGasto->valor = $model->valor_fijo;
					if ($model->es_porcentaje) {
						$porcentaje = 0;
						if ($gasto->Monto > 0)
							$porcentaje = $gasto->Monto / 100 * $model->valor_fijo;
						$modelRPGasto->alicuota = $porcentaje;
					} else
						$modelRPGasto->alicuota = $modelRPGasto->valor;
				}
				if ($model->save ()) {
					$modelRPGasto->id_retencion_percepcion = $model->id_retencion_percepcion;
					if ($modelRPGasto->save ())
						echo "Retención/Percepción Registrada";
					else
						print_r ( $modelRPGasto->getErrors () );
				} else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}
	public function actionAdmin() {
		$model = new Gasto ( 'search' );
		$model->NumComprobante=null;
		if (isset ( $_GET ['Gasto'] ))
			$model->attributes = $_GET ['Gasto'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionAdminFacturas() {
		// a Pagar
		$model = new Gasto ( 'search' );
		$model->pagada = 0;
		$model->NumComprobante=null;
		if (isset ( $_GET ['Gasto'] ))
			$model->attributes = $_GET ['Gasto'];
		
		$this->render ( 'adminIVA', array (
				'model' => $model,
				'conIVA' => true 
		) );
	}
	public function actionAdminComprobantes() {
		$model = new Gasto ( 'search' );
		//$model->pagada = 0;
		$model->NumComprobante=null;
		if (isset ( $_GET ['Gasto'] ))
			$model->attributes = $_GET ['Gasto'];
		$this->render ( 'adminIVA', array (
				'model' => $model,
				'conIVA' => false 
		) );
	}
	public function actionAdminFiltros() {
		$model = new Gasto ( 'search' );
		$model->NumComprobante=null;
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
			$model->validate ();
		}
		$this->render ( 'adminFiltros', array (
				'model' => $model 
		) );
	}
	public function actionGastosPorObra() {
		$this->layout = "//layouts/column1";
		//$model = new Gasto ( 'search' );
		$model = new Gasto ();
		$model->NumComprobante=null;
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
		$this->render ( 'adminGastosPorObra', array (
				'model' => $model,
				'busqueda' => $busqeuda 
		) );
	}
	public function actionGastosPorObraAjax() {
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
			// $model->validate ();
		}
		$html = $this->renderPartial ( '_resultadoGastosPorObra', array (
				'model' => $model 
		), true );
		return $html;
	}
	public function actionGastosMAAjax() {
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
			// $model->validate ();
		}
		$html = $this->renderPartial ( '_resultadoGastosPorObra', array (
				'model' => $model 
		), true );
		return $html;
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Gasto::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'gasto-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionValoresByRetPercep() {
		$list = RetencionPercepcionValores::model ()->findAll ( "id_retencion_percepcion=?", array (
				$_POST ["GastoRetencionPercepcion"] ["id_retencion_percepcion"] 
		) );
		foreach ( $list as $data )
			echo "<option value=\"{$data->id_retencion_percepcion_valores}\">{$data->valor}</option>";
	}
	public function actionExportar($nombreArchivo) {
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
		}
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $gasto ) {
			$gasto->en_blanco = $gasto->en_blanco == 0 ? 'No' : 'Si';
			$gasto->pagada = $gasto->pagada == 0 ? 'No' : 'Si';
			$gasto->en_orden_pago = $gasto->getMontoTotal ();
		}
		Yii::import ( 'ext.ECSVExport' );
		$csv = new ECSVExport ( $dataprovider );
		$this->preparateAndExecuteCSV ( $csv, $nombreArchivo );
	}
	public function actionExportarSinPaginas($nombreArchivo) {
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
		}
		$dataprovider = $model->searchFiltrosConMedioPagoSinPaginar ();
		foreach ( $dataprovider->getData () as $gasto ) {
			$gasto->en_blanco = $gasto->en_blanco == 0 ? 'No' : 'Si';
			$gasto->pagada = $gasto->pagada == 0 ? 'No' : 'Si';
			$gasto->en_orden_pago = $gasto->getMontoTotal ();
		}
		Yii::import ( 'ext.ECSVExport' );
		$csv = new ECSVExport ( $dataprovider );
		$this->preparateAndExecuteCSV ( $csv, $nombreArchivo );
	}
	public function preparateAndExecuteCSV($csv, $nombreArchivo) {
		$headers = array (
				'Monto' => 'Importe',
				'en_orden_pago' => 'Total' 
		);
		$csv->setHeaders ( $headers );
		$csv->setExclude ( array (
				'id_gasto',
				'id_obra',
				'id_proveedor',
				'id_tipo_comprobante',
				'id_contrato_cabecera',
				// 'en_orden_pago',
				'usuario_log',
				'fecha_log' 
		) );
		$csv->convertActiveDataProvider = false;
		$csv->setModelRelations ( array (
				
				'tipoComprobante' => array (
						'descripcion' 
				),
				'proveedor' => array (
						'Nombre',
						'Telefono',
						'Celular' 
				),
				'obra' => array (
						'descripcion' 
				),
				
				'contratoCabecera' => array (
						'descripcion' 
				) 
		) );
		$content = $csv->toCSV ();
		Yii::app ()->getRequest ()->sendFile ( $nombreArchivo . '.csv', $content, "text/csv", false );
		exit ();
		Yii::app ()->end ();
	}
	public function actionBalanceMensuales() {
		$model = new BalanceMensualesForm ();
		
		if (isset ( $_GET ['BalanceMensualesForm'] )) {
			$model->attributes = $_GET ['BalanceMensualesForm'];
			// BalanceMensualesForm arma todo la data
			// filtrando de la Fecha para obtener el anio, osea 1/1/xxx a 31/12/xxxx
			$data = $model->generateDataXLS ();
			// luego se hace el Excel
			// por corte control con Whiles y sumarizando
			$headers = array (
					// A,
					'FechaFacturaDisplay',
					array ( // B
							'header' => 'Obra',
							'field' => 'obra::descripcion' 
					),
					array ( // C
							'header' => 'Proveedor',
							'field' => 'proveedor::descripcion' 
					),
					array ( // D
							'header' => 'Nro. Factura',
							'field' => 'NumComprobante' 
					),
					
					array ( // E
							'header' => 'Importe',
							'field' => 'Monto' 
					),
					array ( // F
							'header' => 'Tipo Factura',
							'field' => 'tipoComprobante::Nombre' 
					),
					array ( // G
							'header' => 'IVA',
							'field' => 'iVACalculado' 
					) 
			);
			
			$autor = 'Usuario creador:' . UsersLogin::getAdministradorUserNameByUsersLoginID ( Yii::app ()->user->id );
			$title = 'Balance VARI';
			$titleSheet = 'COMPRAS';
			$fromDataRow = 8;
			$titles = array (
					'Detalle de Compras VARI S.R.L.',
					'COMPRAS CON IVA, AÑO:' . $model->anio 
			);
			
			Yii::log ( Yii::getPathOfAlias ( 'application.extensions.phpexcel' ), CLogger::LEVEL_WARNING, 'EXCEL' );
			$phpexcel_root = Yii::getPathOfAlias ( 'application.extensions.phpexcel' );
			/*
			 * spl_autoload_unregister(array('YiiBase','autoload'));
			 * require_once $phpexcel_root.'/LGoicoExcel.php';
			 */
			
			Yii::import ( 'ext.phpexcel.LGoicoExcel' );
			$excelGenerator = new LGoicoExcel ();
			$excelGenerator->createExcelTemplateWithoutData ( "TemplateComprasRAAllSheets.xlsx", $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
			// spl_autoload_register(array('YiiBase','autoload'));
			
			// agregar data
			$indexRow = 4;
			$indexSubtitlePrev = $indexRow + 1;
			$primerH = true;
			foreach ( $data as $balMensual ) {
				$subtitle = LGHelper::functions ()->getMonthLabel ( $balMensual->mes ) . '-' . $balMensual->anio;
				$excelGenerator->addSubtitleBlock ( $subtitle, $indexRow, true, count ( $headers ) );
				$indexRow ++;
				if (! $primerH) {
					// copiar los headers
					$excelGenerator->copyRows ( $indexSubtitlePrev, $indexRow );
					$indexRow ++;
					$excelGenerator->copyRows ( $indexSubtitlePrev + 1, $indexRow );
					$indexRow ++;
				} else {
					$primerH = false;
					// 2 filas
					$indexRow ++;
					$indexRow ++;
				}
				$indexRow = $excelGenerator->addDataExcel ( $balMensual->gastos, $headers, $indexRow ) + 4;
				$excelGenerator->writeSummary ( "TOTAL COMPRAS", $balMensual->totalGastos, $indexRow - 4, 3, true );
				$excelGenerator->writeSummary ( "IVA COMPRAS", $balMensual->totalIVAGastos, $indexRow - 4, 5, true );
				$excelGenerator->writeSummary ( "TOTAL VENTAS", $balMensual->totalVentas, $indexRow - 3, 3, true );
				$excelGenerator->writeSummary ( "IVA VENTAS", $balMensual->totalIVAVentas, $indexRow - 3, 5, true );
			}
			// genera los filtros, no me anduvo
			// $excelGenerator->setAutoFilter();
			
			// empiezo tercera hoja
			$excelGenerator->setActiveSheet ( 1 );
			$data = $model->generateDataXLSSinIVA ();
			
			$titleSheet = 'COMPRAS SIN IVA';
			$fromDataRow = 8;
			$titles = array (
					'Detalle de Compras VARI S.R.L. - Comprobantes sin IVA',
					'AÑO:' . $model->anio 
			);
			
			$excelGenerator->writeSheetActiveData ( $title, $titleSheet, $fromDataRow, $titles );
			Yii::log ( 'BALANCE-COMPRAS', CLogger::LEVEL_WARNING, 'EXCEL' );
			// agregar data
			$indexRow = 4;
			$indexSubtitlePrev = $indexRow + 1;
			$primerH = true;
			foreach ( $data as $balMensual ) {
				$subtitle = LGHelper::functions ()->getMonthLabel ( $balMensual->mes ) . '-' . $balMensual->anio;
				Yii::log ( 'RECORRE-COMPRAS-MES:' . $balMensual->mes, CLogger::LEVEL_WARNING, 'EXCEL' );
				$excelGenerator->addSubtitleBlock ( $subtitle, $indexRow, true, count ( $headers ) );
				$indexRow ++;
				if (! $primerH) {
					// copiar los headers
					$excelGenerator->copyRows ( $indexSubtitlePrev, $indexRow );
					$indexRow ++;
					$excelGenerator->copyRows ( $indexSubtitlePrev + 1, $indexRow );
					$indexRow ++;
				} else {
					$primerH = false;
					// 2 filas
					$indexRow ++;
					$indexRow ++;
				}
				$indexRow = $excelGenerator->addDataExcel ( $balMensual->gastos, $headers, $indexRow ) + 4;
				$excelGenerator->writeSummary ( "TOTAL COMPRAS", $balMensual->totalGastos, $indexRow - 4, 3, true );
				$excelGenerator->writeSummary ( "IVA COMPRAS", $balMensual->totalIVAGastos, $indexRow - 4, 5, true );
				$excelGenerator->writeSummary ( "TOTAL VENTAS", $balMensual->totalVentas, $indexRow - 3, 3, true );
				$excelGenerator->writeSummary ( "IVA VENTAS", $balMensual->totalIVAVentas, $indexRow - 3, 5, true );
			}
			
			// empiezo segunda hoja
			$excelGenerator->setActiveSheet ( 2 );
			$titleSheet = 'RESUMEN ' . $model->anio;
			$fromDataRow = 8;
			$titles = array (
					'Compras/Ventas - ' . $model->anio 
			);
			$excelGenerator->writeSheetActiveData ( $title, $titleSheet, $fromDataRow, $titles );
			if ($model->mes == null) {
				$rrow = 1;
				foreach ( $data as $balMensual ) {
					$excelGenerator->writeCell ( $balMensual->totalGastos, 8, $rrow );
					$excelGenerator->writeCell ( $balMensual->totalVentas, 10, $rrow );
					$rrow ++;
				}
			} else
				foreach ( $data as $balMensual ) {
					$excelGenerator->writeCell ( $balMensual->totalGastos, 8, $model->mes );
					$excelGenerator->writeCell ( $balMensual->totalVentas, 10, $model->mes );
				}
			
			$excelGenerator->setActiveSheet ( 0 );
			$excelGenerator->downloadXLS ();
		} else {
			$this->render ( 'adminFiltrosInforme', array (
					'model' => $model 
			) );
		}
	}
	public function actionBalanceMensualesOLD() {
		$model = new BalanceMensualesForm ();
		
		if (isset ( $_GET ['BalanceMensualesForm'] )) {
			$model->attributes = $_GET ['BalanceMensualesForm'];
			// BalanceMensualesForm arma todo la data
			// filtrando de la Fecha para obtener el anio, osea 1/1/xxx a 31/12/xxxx
			$data = $model->generateDataXLS ();
			// luego se hace el Excel
			// por corte control con Whiles y sumarizando
			$headers = array (
					// A,
					'FechaFacturaDisplay',
					array ( // B
							'header' => 'Obra',
							'field' => 'obra::descripcion' 
					),
					array ( // C
							'header' => 'Proveedor',
							'field' => 'proveedor::descripcion' 
					),
					array ( // D
							'header' => 'Nro. Factura',
							'field' => 'NumComprobante' 
					),
					
					array ( // E
							'header' => 'Importe',
							'field' => 'Monto' 
					),
					array ( // F
							'header' => 'Tipo Factura',
							'field' => 'tipoComprobante::Nombre' 
					),
					array ( // G
							'header' => 'IVA',
							'field' => 'iVACalculado' 
					) 
			);
			
			$autor = 'Usuario creador:' . UsersLogin::getAdministradorUserNameByUsersLoginID ( Yii::app ()->user->id );
			$title = 'Balance VARI';
			$titleSheet = 'COMPRAS';
			$fromDataRow = 8;
			$titles = array (
					'Detalle de Compras VARI S.R.L.',
					'COMPRAS CON IVA, AÑO:' . $model->anio 
			);
			
			Yii::log ( Yii::getPathOfAlias ( 'application.extensions.phpexcel' ), CLogger::LEVEL_WARNING, 'EXCEL' );
			$phpexcel_root = Yii::getPathOfAlias ( 'application.extensions.phpexcel' );
			/*
			 * spl_autoload_unregister(array('YiiBase','autoload'));
			 * require_once $phpexcel_root.'/LGoicoExcel.php';
			 */
			
			Yii::import ( 'ext.phpexcel.LGoicoExcel' );
			$excelGenerator = new LGoicoExcel ();
			$excelGenerator->createExcelTemplateWithoutData ( "TemplateComprasRA.xlsx", $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
			
			// spl_autoload_register(array('YiiBase','autoload'));
			
			// agregar data
			$indexRow = 4;
			$indexSubtitlePrev = $indexRow + 1;
			$primerH = true;
			foreach ( $data as $balMensual ) {
				$subtitle = LGHelper::functions ()->getMonthLabel ( $balMensual->mes ) . '-' . $balMensual->anio;
				$excelGenerator->addSubtitleBlock ( $subtitle, $indexRow, true, count ( $headers ) );
				$indexRow ++;
				if (! $primerH) {
					// copiar los headers
					$excelGenerator->copyRows ( $indexSubtitlePrev, $indexRow );
					$indexRow ++;
					$excelGenerator->copyRows ( $indexSubtitlePrev + 1, $indexRow );
					$indexRow ++;
				} else {
					$primerH = false;
					// 2 filas
					$indexRow ++;
					$indexRow ++;
				}
				$indexRow = $excelGenerator->addDataExcel ( $balMensual->gastos, $headers, $indexRow ) + 4;
				$excelGenerator->writeSummary ( "TOTAL COMPRAS", $balMensual->totalGastos, $indexRow - 4, 3, true );
				$excelGenerator->writeSummary ( "IVA COMPRAS", $balMensual->totalIVAGastos, $indexRow - 4, 5, true );
				$excelGenerator->writeSummary ( "TOTAL VENTAS", $balMensual->totalVentas, $indexRow - 3, 3, true );
				$excelGenerator->writeSummary ( "IVA VENTAS", $balMensual->totalIVAVentas, $indexRow - 3, 5, true );
			}
			// genera los filtros, no me anduvo
			// $excelGenerator->setAutoFilter();
			
			$titleSheet = 'RESUMEN ' . $model->anio;
			$fromDataRow = 8;
			$titles = array (
					'Compras/Ventas - ' . $model->anio 
			);
			Yii::log ( 'LGOICOEXCEL4', CLogger::LEVEL_WARNING, 'EXCEL' );
			$excelGenerator->createSheetExcelTemplateWithoutData ( "TemplateComprasRAResumen.xlsx", $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
			$excelGenerator->setActiveSheet ( 1 );
			
			if ($model->mes == null) {
				$rrow = 1;
				foreach ( $data as $balMensual ) {
					$excelGenerator->writeCell ( $balMensual->totalGastos, 8, $rrow );
					$excelGenerator->writeCell ( $balMensual->totalVentas, 10, $rrow );
					$rrow ++;
				}
			} else
				foreach ( $data as $balMensual ) {
					$excelGenerator->writeCell ( $balMensual->totalGastos, 8, $model->mes );
					$excelGenerator->writeCell ( $balMensual->totalVentas, 10, $model->mes );
				}
			
			$data = $model->generateDataXLSSinIVA ();
			$titleSheet = 'COMPRAS SIN IVA';
			$fromDataRow = 8;
			$titles = array (
					'Detalle de Compras VARI S.R.L. - Comprobantes sin IVA',
					'AÑO:' . $model->anio 
			);
			
			// LGoicoExcel::createExcel ( $data, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
			$excelGenerator->createSheetExcelTemplateWithoutData ( "TemplateComprasRA.xlsx", $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
			$excelGenerator->setActiveSheet ( 2 );
			// agregar data
			$indexRow = 4;
			$indexSubtitlePrev = $indexRow + 1;
			$primerH = true;
			foreach ( $data as $balMensual ) {
				$subtitle = LGHelper::functions ()->getMonthLabel ( $balMensual->mes ) . '-' . $balMensual->anio;
				$excelGenerator->addSubtitleBlock ( $subtitle, $indexRow, true, count ( $headers ) );
				$indexRow ++;
				if (! $primerH) {
					// copiar los headers
					$excelGenerator->copyRows ( $indexSubtitlePrev, $indexRow );
					$indexRow ++;
					$excelGenerator->copyRows ( $indexSubtitlePrev + 1, $indexRow );
					$indexRow ++;
				} else {
					$primerH = false;
					// 2 filas
					$indexRow ++;
					$indexRow ++;
				}
				$indexRow = $excelGenerator->addDataExcel ( $balMensual->gastos, $headers, $indexRow ) + 4;
				$excelGenerator->writeSummary ( "TOTAL COMPRAS", $balMensual->totalGastos, $indexRow - 4, 3, true );
				$excelGenerator->writeSummary ( "IVA COMPRAS", $balMensual->totalIVAGastos, $indexRow - 4, 5, true );
				$excelGenerator->writeSummary ( "TOTAL VENTAS", $balMensual->totalVentas, $indexRow - 3, 3, true );
				$excelGenerator->writeSummary ( "IVA VENTAS", $balMensual->totalIVAVentas, $indexRow - 3, 5, true );
			}
			$excelGenerator->setActiveSheet ( 0 );
			$excelGenerator->downloadXLS ();
		} else {
			$this->render ( 'adminFiltrosInforme', array (
					'model' => $model 
			) );
		}
	}
	public function actionListarSubcontratos($id) {
		$contratos = ContratoCabecera::model ()->findAll ( array (
				'condition' => 'id_proveedor='.$id
				//,'order' => 'id_contrato_cabecera desc' 
		) );
		if ($contratos!=null) {
			$model = new Gasto();
			$lista = CHtml::listData ( $contratos, 'id_contrato_cabecera', 'descripcionCodigo' );
			echo "<b>DESEA IMPUTAR ESTE GASTO A UN SUBCONTRATO DEL PROVEEDOR?</B>";
			echo CHtml::activeDropDownList ( $model, 'id_contrato_cabecera', $lista , array (
					'empty' => 'Seleccionar..'
			));
		}
	}
	
	public function actionImprimirGastosPorObra(){
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
		}
		$dataprovider = $model->searchFiltrosConMedioPagoSinPaginar ();
		foreach ( $dataprovider->getData () as $gasto ) {
			$gasto->en_blanco = $gasto->en_blanco == 0 ? 'No' : 'Si';
			$gasto->pagada = $gasto->pagada == 0 ? 'No' : 'Si';
			$gasto->en_orden_pago = $gasto->getMontoTotal ();
		}
		$titulo = 'GASTOS POR OBRA';
		$html = $this->renderPartial ( 'gastoPorObraImpresion', array (
				'titulo' => $titulo,
				'gastos' => $dataprovider,
				'model' => $model
		), true );
		//echo $html;
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();		
	}
	public function actionImprimirGastosPorObraPages(){
		$model = new Gasto ();
		if (isset ( $_GET ['Gasto'] )) {
			$model->attributes = $_GET ['Gasto'];
		}
		$dataprovider = $model->searchFiltrosConMedioPagoSinPaginar ();
		$cantidad = 0;
		$primera = true;
		$htmls = array();
		$gastos = array();
		foreach ( $dataprovider->getData () as $gasto ) {
			$gasto->en_blanco = $gasto->en_blanco == 0 ? 'No' : 'Si';
			$gasto->pagada = $gasto->pagada == 0 ? 'No' : 'Si';
			$gasto->en_orden_pago = $gasto->getMontoTotal ();
			//$gastos[] = $gasto;
array_push($gastos, $gasto);
			$cantidad++;
			if ($cantidad == 11) {
				if ($primera) {
					$htmls[] = $this->renderPartial ( 'gastoPorObraImpresion', array (
							'titulo' => $titulo,
							'gastos' => new CArrayDataProvider($gastos, array('pagination'=> false)),
							'model' => $model
					), true );
					$primera =false;
				}
				else {
					$htmls[]= $this->renderPartial ( 'gastoPorObraImpresion', array (
							'titulo' => '',
							'gastos' => new CArrayDataProvider($gastos, array('pagination'=> false)),
							'model' => $model
					), true );
				}
				$cantidad=0;
                                unset($gastos);
				$gastos = array();
			}
			
		}
		$titulo = 'GASTOS POR OBRA';
		if ($cantidad!=0){
			$html = $this->renderPartial ( 'gastoPorObraImpresion', array (
					'titulo' => $titulo,
					'gastos' => new CArrayDataProvider($gastos, array('pagination'=> false)),
					'model' => $model
			), true );
			$htmls[] = $html;
		}
		print_r($htmls);
		exit;
		$style = file_get_contents(Yii::app()->request->hostInfo.'/'.Yii::app()->theme->baseUrl.'/css/estilos-min.css');
		LGHelper::functions ()->generarPDFPages ( $htmls, $titulo ,$style);
		exit ();
	}
}
