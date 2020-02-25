<?php
class MigracionController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public $logs = " ";
	public $gastos = array(); 
	public $totalMigrados = 0;
	public $id_proveedor = null;

	public function actions() {
		return array (
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array (
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF 
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array (
						'class' => 'CViewAction' 
				) 
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('migrarGastos','migrarQuincenas'),
				'users'=>array('*'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}


	public function actionMigrarGastos()
	{
		$this->logs = "-";
		$this->gastos = array ();
		$this->migrarGastos();
		$this->render('detalle',array(
			'logs'=>$this->logs,
			'gastos' => $this->gastos
		));
	}
	
	public function actionMigrarQuincenas()
	{
		$this->logs = '';
		$this->gastos = array ();
		$this->migrarQuincenas();
		$this->migrarGastos();
		$this->render('detalle',array(
			'logs'=>$this->logs,
			'gastos' => $this->gastos
		));
	}

	public function migrarGastos(){
		//mGastos = MigracionGastos::
		$this->logs = "LOGS: ";
		$migraciones = MigracionGasto::model ()->findAll(array(
			'condition' => 'migrado=0 ',
			'limit' => 3000,
			//'params' => array(':c' => 0),
		  ));
		foreach ($migraciones as $migracion){
			$this->createPagadoConMedio($migracion);
		}
		echo "SE MIGRARON".$this->totalMigrados;
	}

	
	
	public function migrarQuincenas(){
		$migraciones = MigracionQuincena::model ()->findAll("MIGRADO=0");
		foreach ($migraciones as $migracion){
			$this->crearQuincenaYMigracionGasto($migracion);
		}
	}

	public function crearQuincenaYMigracionGasto($migracionQuincena){
		$migracion = new MigracionGasto();
		$quincena = new Quincena();
		//COPIA MIGRADOGASTO
		$migracion->ID_OBRA = $migracionQuincena->id_obra;
		$migracion->FECHA= $migracionQuincena->FECHA;
		$migracion->ENCARGADO=' ';
		$migracion->CODIGO_SUBCONTRATO = 0;
		$migracion->MIGRADO = 0;
		$migracion->ID_PROVEEDOR = $migracionQuincena->id_personal;
		$migracion->PROVEEDOR = $migracionQuincena->NOMBRE;
		$migracion->TIPO = "COMPROBANTE";
		$migracion->CANTIDAD = 0;
		$migracion->NRO_FACTURA= "PAGO QUINCENA DE: ". $migracionQuincena->NOMBRE;
		$quicenal = Quincenal::model()->findByPk($migracionQuincena->ID_QUINCENAL);
		$migracion->DETALLE= "PAGO QUINCENA  (CODIGO PROVEEDOR)NOMBRE -> (".$migracionQuincena->id_personal.")". $migracionQuincena->NOMBRE." - QUINCENA: ".$quicenal->getDescripcion();
		$migracion->SUBTOTAL = $migracionQuincena->FINAL;
		$migracion->TOTAL = $migracionQuincena->FINAL;
		$migracion->FECHA_COBRO = $migracionQuincena->FECHA;
		$migracion->MONTO_PAGADO= $migracionQuincena->MONTO_PAGADO;
		$migracion->M_PAGADO= $migracionQuincena->M_PAGADO;
		$migracion->ID_CUENTA= $migracionQuincena->ID_CUENTA;
		$migracion->FORMA_PAGO= $migracionQuincena->FORMA_PAGO;
		$migracion->ID_CUENTA_BANCO= $migracionQuincena->ID_CUENTA_BANCO;
		$migracion->NRO_CHEQUE= $migracionQuincena->NRO_CHEQUE;
		 //ARMA QUINCENA
		 //, ,id_gasto, , , , Final, 
		 //subtotal, viaticos, movilidad, 
		 //descuentos_adelantos, nro_secuencia_quincena, Quincena, id_quincenal, Indice, , 
		 $quincena->id_obra = $migracionQuincena->id_obra;
		 $quincena->id_empresa = 1;
		 $quincena->Fecha = $migracionQuincena->FECHA;
		 $quincena->id_quincenal = $migracionQuincena->ID_QUINCENAL;
		 $quincena->id_proveedor  =$migracionQuincena->id_personal;
		 $quincena->id_proveedor  =$migracionQuincena->id_personal;
		 $quincena->horas = $migracionQuincena->DIAS_TRABAJADOS * 8;
		 $quincena->dias_trabajados = $migracionQuincena->DIAS_TRABAJADOS;
		 $quincena->efectivo= $migracionQuincena->MONTO_PAGADO;
		 $quincena->adelantos= $migracionQuincena->ADELANTOS;
		 $quincena->nro_secuencia_quincena = $migracionQuincena->ID_QUINCENAL;
		 $quincena->id_quincenal = $migracionQuincena->ID_QUINCENAL;
		 if ($quincena->save()){
			$migracion->id_quincena = $quincena->id_quincena;
			if($migracion->save()) {
				$migracionQuincena->MIGRADO=1;
				$migracionQuincena->save();
			}
			
		 }
		 else echo "fallo quincena".$migracionQuincena->id_migracion_quincena;
	     
		//,id_obra, FECHA, ID_QUINCENAL, QUINCENAL, id_personal, 
		//NOMBRE, VALOR_CATEGORIA, DIAS_TRABAJADOS, FINAL, DESCUENTOS,ADELANTOS,FECHA_COBRO,MONTO_PAGADO,
		//FORMA_PAGO,NRO_CHEQUE,ID_CUENTA_BANCO,ID_CUENTA,M_PAGADO,MIGRADO

				
	
	}

	public function getComprobante($migracion){
		//SUELDO,IMPUESTOS, COMPROBANTE, A , NC, B,C
		$tipo = TipoComprobante::model()->findByPk(1);
		if ($migracion->CODIGO_SUBCONTRATO != 0)
			{
				$contrato = ContratoCabecera::model()->find ( ' codigo='.$migracion->CODIGO_SUBCONTRATO );
			    if ($contrato == null){
					$contrato = new ContratoCabecera();
					$contrato->id_proveedor = $migracion->ID_PROVEEDOR;
					$contrato->id_obra = $migracion->ID_OBRA;
					$contrato->Fecha = $migracion->FECHA;
					$contrato->id_empresa = 1;
					$contrato->id_usuario_autorizo = 1;
					$contrato->id_usuario_solicito = 1;
					$contrato->codigo = $migracion->CODIGO_SUBCONTRATO;
					$contrato->Plazo = 60;	
					$contrato->Descripcion = "Encargado: ".$migracion->ENCARGADO.",Proveedor : ".$migracion->PROVEEDOR.", Obra nro: ".$contrato->id_obra.", Fecha: ".$contrato->Fecha.", Importe:".$contrato->Detalle;
					$contrato->Precio = LGHelper::functions()->formatNumber($migracion->TOTAL); 
					if ($contrato->save()) {
						$errors = $contrato->getErrors();
						throw new Exception("<p class='error'>Error al registrar ContratoCabecera nuevo</p>CODIGO:".$migracion->CODIGO_SUBCONTRATO );
					}
														
				}
			}
      if (strcasecmp(trim($migracion->TIPO), "A") == 0 ){
			//factura a
            //echo "entre por A";
			$tipo= TipoComprobante::model()->findByPk(2);
		}
		if (strcasecmp(trim($migracion->TIPO), "B") == 0 ){
			//factura b
			$tipo= TipoComprobante::model()->findByPk(3);
		}
		if (strcasecmp(trim($migracion->TIPO), "C") == 0 ){
			//factura c
			$tipo= TipoComprobante::model()->findByPk(4);
		}
		if (strcasecmp(trim($migracion->TIPO), "NC") == 0 ){
		   //nota de credito
		   $tipo= TipoComprobante::model()->findByPk(10);
		}
		
		if (strcasecmp(trim($migracion->TIPO), "IMPUESTOS") == 0 ){
			//nota de credito
			$tipo= TipoComprobante::model()->findByPk(8);
		 }
		 if (strcasecmp(trim($migracion->TIPO), "SUELDO") == 0 ){
			//nota de credito
			$tipo= TipoComprobante::model()->findByPk(6);
		 }

		if (strcasecmp(trim($migracion->TIPO), "COMPROBANTE") == 0 ){
				//e instanciar el TipoComprobante =
				$tipo= TipoComprobante::model()->findByPk(5);
			}	
		return $tipo;	
	}
	public function copiarDesdeMigracion($gasto,$migracion){
		$gasto->tipoComprobante = $this->getComprobante($migracion);
		$gasto->id_tipo_comprobante = $gasto->tipoComprobante->id_tipo_comprobante;
		if ($migracion->CODIGO_SUBCONTRATO != 0) {
			$concabe = ContratoCabecera::model()->find ( 'codigo='.$migracion->CODIGO_SUBCONTRATO );
			if ($concabe!=null){
				$gasto->contratoCabecera = $concabe;
				$gasto->id_contrato_cabecera = $concabe->id_contrato_cabecera;
			}
			else {
				$gasto->id_contrato_cabecera = $migracion->CODIGO_SUBCONTRATO;
			}

		}
		// $model->FechaFac = LGHelper::functions()->undisplayFecha($model->FechaFac);
		$gasto->FechaFactura = $migracion->FECHA;
		$gasto->FechaAsiento = $migracion->FECHA;
		//, FECHA, ENCARGADO,  TIPO, CANTIDAD, 
		//SUBTOTAL, IVA, ALICUOTA, RETENCIONES, FECHA_COBRO, MONTO_PAGADO, 
		//NRO_CHEQUE, ID_CUENTA_BANCO, ID_CUENTA, M_PAGADO, MIGRADO
		$gasto->id_obra = $migracion->ID_OBRA;
		$gasto->FechaAsiento = $migracion->FECHA;
		$gasto->NumComprobante = $migracion->NRO_FACTURA;
		$gasto->id_proveedor = $migracion->ID_PROVEEDOR;
		$gasto->Detalle = $migracion->DETALLE;
		$gasto->Monto = LGHelper::functions ()->formatNumber ( $migracion->TOTAL);
		$gasto->en_orden_pago = 1;
		$gasto->FechaFactura = $migracion->FECHA;
		$gasto->en_blanco=1;
		$gasto->pagada =1;
		$gasto->id_quincena = $migracion->id_quincena;   
		//pagada, 
		//  id_tipo_comprobante,   
		//fechaDesde, fechaHasta,fechaAsientoDesde,fechaAsientoHasta,
		//id_medio_pago',
				
	}

	public function createPagadoConMedio($migracion) {
		$model = new Gasto ();
		$transaction = Yii::app()->db->beginTransaction();
		try
		{
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->Codigo = $id_lead_new;
				$this->copiarDesdeMigracion($model,$migracion);
				if (isset ($model) && $model->id_tipo_comprobante!="") {							
					$id_exito = null;
					$idCuenta = $migracion->M_PAGADO?$migracion->ID_CUENTA:null;
					if ($idCuenta == null || $idCuenta == 0) {
							$idCuenta = 1; // SETEA facturas a Pagar
							$gasto->pagada =0;
					}
					if ($model->validate()) { //&& !$model->existeComprobante ()) {	
						$fecha_cobro = $migracion->FECHA_COBRO;
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
								$fechaCobro = $fecha_cobro;
								$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
								$pago->pagado = $idCuenta==1?0:1;
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
											if ($pago->pagado){
												$medioPagoForm = new MedioPagoForm();
												$medioPagoForm->detalle =(strcasecmp(trim($migracion->FORMA_PAGO), "CHEQUE") == 0)?$migracion->NRO_CHEQUE:$migracion->DETALLE;
												$medioPagoForm->nro_cheque =(strcasecmp(trim($migracion->FORMA_PAGO), "CHEQUE") == 0)?$migracion->NRO_CHEQUE:null;
												$medioPagoForm->id_cuenta_banco = $migracion->ID_CUENTA_BANCO;
												$medioPagoForm->id_proveedor =  $pago->id_proveedor;
												//NRO_CHEQUE, ID_CUENTA_BANCO
												$medioPagoForm->id_medio_pago = $this->getMedioPagoId($migracion->FORMA_PAGO);
												$medioPagoForm->monto  =LGHelper::functions()->formatNumber($migracion->MONTO_PAGADO);
												$medioPagoForm->fecha = $migracion->FECHA_COBRO;								 	
												if (!$medioPagoForm->saveMedioPago($pago->id_pago)){
													$errors = $medioPagoForm->getErrors();
													throw new Exception("<p class='error'>Fallo la Generacion del medio de pago</p>");	
												}
											} 
										} else {
											$errors = $pagoOP->getErrors();
											throw new Exception("<p class='error'>Fallo al unir el Pago a la OP</p>");	
										}
									} else {
										$errors = $opGasto->getErrors();
										throw new Exception("<p class='error'>Fallo al relacionar el Comprobante a la OP</p>");	
									}
								} else {
									$errors =$pago->getErrors();
									throw new Exception("<p class='error'>Fallo al relacionar el Comprobante a la OP</p>");
								}
							} else {
								$errors =$newOP->getErrors();
								throw new Exception("<p class='error'>Fallo la creacion de la Orden de Pago." . " " . print_r ( $newOP->getErrors () ) . "</p>");
							} 
						}
						} else {
							$errors =$model->getErrors();
							//$errors = "<p class='error'>Ya existe un Comprobante con ese Número para ese Proveedor</p>";
							throw new Exception('No puedo generar ese numero de Comprobante para ese Proveedor');
						}
					}
					$migracion->MIGRADO = 1;
					if($migracion->save()){
						$this->totalMigrados++;
					} else {
						$errors = "<p class='error'>Fallo al guardar el migrado=1".$migracion->id_migracion_gasto."</p>";
						throw new Exception('Falla al poner migrado en 1');
					}
					$transaction->commit();
					$this->logs .= "- AGREGA GASTO CODIGO:".$gasto->Codigo;
					$this->gastos[] = $model;
			
			}catch(Exception $e){
				//Do some logging here
				$transaction->rollback();
				$errores= json_encode($errors);
				$this->logs .= "id_migr:".$migracion->id_migracion_gastos."- HUBO ERRORES:". $errores."-EXCEPCION: ".$e->getMessage();
				//."-".$e->getTraceAsString();
				if($errors != null){
					Yii::app()->user->setFlash('error', implode("|",$errors));
				}
			}
		}
		
		public function getMedioPagoId($formapago){
			//VALORES: CHEQUE, EFECTIVO , TRANFERENCIA, TARJETA, DEPOSITO
			if (strcasecmp(trim($formapago), "CHEQUE") == 0 ){
				return 1;
			}
			if (strcasecmp(trim($formapago), "TRANSFERENCIA") == 0 ){
				return 2;
			}
			if (strcasecmp(trim($formapago), "EFECTIVO") == 0 ){
				return 3;
			}
			if (strcasecmp(trim($formapago), "TARJETA") == 0 ){
				return 4;
			}
			if (strcasecmp(trim($formapago), "DEPOSITO") == 0 ){
				return 2;
			}
			return 3;
		}

		public function generateRetencionIVA($id_gasto, $monto) {
			$monto =LGHelper::functions()->unformatNumber($monto);
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
} 
