<?php
class CobroController extends Controller {
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
								'createCobrados',
								'update',
								'admin',
								'adminCobrados',
								'adminFiltros',
								'informeIVA',
								'exportar',
								'exportarXLS',
								'cambiarFactura',
								'anularFactura',
								'imprimirOrden',
								'imprimirCobroItem',
								'adminACobrar',
								'agregarCobroItem',
								'anularCobroItem'
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
	public function behaviors() {
		return array (
				'eexcelview' => array (
						'class' => 'ext.eexcelview.EExcelBehavior' 
				) 
		);
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function onRenderHeaderCell(PHPExcel_Cell $cell, $value) {
		$worksheet = $cell->getParent ();
		$worksheet->getStyle ( $cell->getCoordinate () )->getFont ()->setBold ( true );
		if ($value == 'email')
			$worksheet->getStyle ( $cell->getCoordinate () )->getFont ()->setItalic ( true );
	}
	public function actionCreate() {
		$model = new Cobro ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_cobro`) as `max` FROM `cobros` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->id_imputacion = 3;//Pago de Factura
		$model->Indice = $id_lead_new;
		$model->Importe = null;
		$model->id_tipo_factura = 1; //HARDCODE en Fac Elec A
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cobro'] )) {
			$model->attributes = $_POST ['Cobro'];
			if ($model->id_cliente == 0) {
				$model->id_cliente = null;
			}
			if ($model->id_obra == 0) {
				$model->id_obra = null;
			}
			$model->id_cuenta = Cuenta::model ()->getCuentaCajaBanco ();
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
			$model->mes_iva= date("m", strtotime($model->Fecha));
			$model->FechaCobro = LGHelper::functions ()->undisplayFecha ( $model->FechaCobro );
			if ($model->validarExistaTipoNroFactura() && $model->save ()){
				Yii::app ()->db->createCommand ( "UPDATE `tipo_factura` SET secuencia=".$model->NumFactura." WHERE id_tipo_factura=".$model->id_tipo_factura )->execute ();
				$this->redirect ( array (
						'view',
						'id' => $model->id_cobro,
						'cobrado' => false 
				) );
			}
		}
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT secuencia FROM `tipo_factura` WHERE id_tipo_factura=".$model->id_tipo_factura )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->NumFactura = $id_lead_new;
		$this->render ( 'create', array (
				'model' => $model,
				'cobrado' => false 
		) );
	}
	public function actionCreateCobrados() {
		$model = new Cobro ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_cobro`) as `max` FROM `cobros` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->id_imputacion = 3;//Pago de Factura
		$model->Indice = $id_lead_new;
		$model->FechaCobro = CTimestamp::formatDate ( 'Y-m-d' );
		$model->cobrado = true;
		$model->Importe = null;
		$model->id_tipo_factura = 1; //HARDCODE en Fac Elec A
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cobro'] )) {
			$model->attributes = $_POST ['Cobro'];
			if ($model->id_cliente == 0) {
				$model->id_cliente = null;
			}
			if ($model->id_obra == 0) {
				$model->id_obra = null;
			}
			$model->id_cuenta = Cuenta::model ()->getCuentaCajaBanco ();
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
			$model->FechaCobro = LGHelper::functions ()->undisplayFecha ( $model->FechaCobro );
			$model->mes_iva= date("m", strtotime($model->Fecha));
			//validarClienteObra($model);
			if ($model->validarExistaTipoNroFactura() && $model->save ()){
				Yii::app ()->db->createCommand ( "UPDATE `tipo_factura` SET secuencia=".$model->NumFactura." WHERE id_tipo_factura=".$model->id_tipo_factura )->execute ();
				if ($this->crearCobroItemDesdeCobro($model)){
					$this->redirect ( array (
						'view',
						'id' => $model->id_cobro 
				) );
				}
			}
		}
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT secuencia FROM `tipo_factura` WHERE id_tipo_factura=".$model->id_tipo_factura )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->NumFactura = $id_lead_new;
		$this->render ( 'create', array (
				'model' => $model,
				'cobrado' => true 
		) );
	}

	public function crearCobroItemDesdeCobro($cobro){
		$cobroItem = new CobroItem();
		$cobroItem->id_cobro  = $cobro->id_cobro;
		$cobroItem->id_cuenta  = $cobro->id_cuenta;
		$cobroItem->Indice = $cobro->Indice;
		$cobroItem->id_imputacion  = $cobro->id_imputacion;
		$cobroItem->Importe  = $cobro->Importe;
		$cobroItem->id_forma = $cobro->id_forma;
		$cobroItem->Fecha  = $cobro->Fecha;
		$cobroItem->FechaCobro = $cobro->FechaCobro;
		$cobroItem->Detalles  = $cobro->Detalles;
		$cobroItem->asentado  = $cobro->asentado;
		$cobroItem->nro_cheque_certificado = $cobro->nro_cheque_certificado;
		return $cobroItem->save();
	}

	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Cobro'] )) {
		//	$importeViejo =$this->Importe;
			$model->attributes = $_POST ['Cobro'];
			/*if ($importeViejo <> $this->Importe){
				//TODO-LTG
				//HACER UN ANULAR FACTURA QUE 
				//PONGA DE BAJA LA ANTERIOR Y 
				//GENERE UNA COPIA CON LOS DATOS DE AHORA.
			}*/
			$model->id_cuenta = Cuenta::model ()->getCuentaCajaBanco ();
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
			$model->FechaCobro = LGHelper::functions ()->undisplayFecha ( $model->FechaCobro );
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_cobro 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model,
				'cobrado'=>true 
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
		$dataProvider = new CActiveDataProvider ( 'Cobro' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$modelForm = new Cobro ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_cobro`) as `max` FROM `cobros` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$modelForm->Indice = $id_lead_new;
		$modelForm->FechaCobro = CTimestamp::formatDate ( 'Y-m-d' );
		$model = new Cobro ();
		$model->Importe = null;
		$model->Indice = null;
		$model->asentado = null;
		// $model->cobrado = 0;
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		}
		$this->performAjaxValidation ( $model );
		if (isset ( $_POST ['Cobro'] )) {
			$modelForm->attributes = $_POST ['Cobro'];
			if ($modelForm->save ()) {
				$this->render ( 'admin', array (
						'model' => $model,
						'modelForm' => $modelForm,
						'creadoExito' => true 
				) );
			}
		}
		
		$this->render ( 'admin', array (
				'model' => $model,
				'modelForm' => $modelForm 
		) )
		// 'creadoExito' => true
		;;

		;
	}
	public function actionAdminCobrados() {
		$model = new Cobro ();
		$model->Importe = null;
		$model->Indice = null;
		$model->cobrado = true;
		$model->cobrado = 1;
		$model->asentado = null;
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		}
		$this->performAjaxValidation ( $model );
		$this->render ( 'adminCobrados', array (
				'model' => $model 
		) );
	}
	public function actionAdminACobrar() {
		$model = new Cobro ();
		$model->Importe = null;
		$model->Indice = null;
		$model->cobrado = false;
		$model->cobrado = 0;
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		}
		$this->performAjaxValidation ( $model );
		$this->render ( 'adminACobrar', array (
				'model' => $model
		) );
	}
	public function actionAdminFiltros() {
		$model = new Cobro ();
		$model->Importe = null;
		$model->Indice = null;
		// $model->cobrado = true;
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		}
		$this->performAjaxValidation ( $model );
		$this->render ( 'adminFiltros', array (
				'model' => $model 
		) );
	}
	public function actionInformeIVA() {
		$model = new Cobro ();
		$model->Importe = null;
		$model->Indice = null;
		// $model->cobrado = true;
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
			$model->Fecha = LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		}
		$this->performAjaxValidation ( $model );
		$this->render ( 'adminFiltrosInforme', array (
				'model' => $model 
		) );
	}
	public function actionExportarXLSconEExcelView($nombreArchivo) {
		$model = new Cobro ();
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
		}
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $cobro ) {
			$cobro->en_blanco = $cobro->en_blanco == 0 ? 'No' : 'Si';
			$cobro->cobrado = $cobro->cobrado == 0 ? 'No' : 'Si';
			$cobro->Fecha = LGHelper::functions ()->displayFecha ( $cobro->Fecha );
		}
		// $this->toExcel($dataprovider->getData ());
		/*
		 * $this->toExcel ( $dataprovider->getData (), array ( 'id_cobro' //solo muestra esa columna ), 'VentasVari  - Informe', array ( 'creator' => 'Ralba Servicios' ), 'Excel5' );
		 */
		$this->toExcel ( $dataprovider->getData (), array (
				'id_cobro',
				'Detalles',
				'cliente.descripcion::Cliente', // Note the custom header
				array (
						'header' => 'Nro. Factura',
						'name' => 'NumFactura',
						'htmlOptions' => array (
								'color' => 'blue' 
						) 
				
				// 'value' => '$data->NumFactura',
								) 
		), 'Ventas-VARI', array (
				'creator' => 'VARI',
				'template' => "{summary}\n{items}\n{exportbuttons}\n{pager}" 
		// 'grid_mode'=>'export',
				), 'Excel2007' );
	}
	public function actionExportarXLSconJPhpExcel($nombreArchivo) { // con JPhpExcel
		$model = new Cobro ();

		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
		}
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $cobro ) {
			$cobro->en_blanco = $cobro->en_blanco == 0 ? 'No' : 'Si';
			$cobro->cobrado = $cobro->cobrado == 0 ? 'No' : 'Si';
			$cobro->Fecha = LGHelper::functions ()->displayFecha ( $cobro->Fecha );
		}
		$data = $dataprovider->getData ();
		Yii::import ( 'application.extensions.phpexcel.JPhpExcel' );
		$xls = new JPhpExcel ( 'UTF-8', false, 'Facturas' );
		$xls->addArray ( $data );
		/*
		 * $xls->getProperties()->setCreator("VARI S.R.L."); $xls->getProperties()->setLastModifiedBy("VARI S.R.L."); $xls->getProperties()->setTitle("Office 2007 XLSX Test Document"); $xls->getProperties()->setSubject("Office 2007 XLSX Test Document"); $xls->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		 */
		$xls->generateXML ( 'Ventas VARI' );
	}
	public function actionExportarXLS($nombreArchivo) { // con XPHPExcel
		$model = new Cobro ();
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
		}
		//Facturas A
		$model->id_tipo_factura = TipoFactura::getTipoA();
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $cobro ) {
			$cobro->en_blanco = $cobro->en_blanco == 0 ? 'No' : 'Si';
			$cobro->cobrado = $cobro->cobrado == 0 ? 'No' : 'Si';
			$cobro->Fecha = LGHelper::functions ()->displayFecha ( $cobro->Fecha );
			$cobro->FechaCobro = LGHelper::functions ()->displayFecha ( $cobro->FechaCobro );
		}
		$dataFacA = $dataprovider->getData ();
		//Facturas B
		$model->id_tipo_factura = TipoFactura::getTipoB();
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $cobro ) {
			$cobro->en_blanco = $cobro->en_blanco == 0 ? 'No' : 'Si';
			$cobro->cobrado = $cobro->cobrado == 0 ? 'No' : 'Si';
			$cobro->Fecha = LGHelper::functions ()->displayFecha ( $cobro->Fecha );
			$cobro->FechaCobro = LGHelper::functions ()->displayFecha ( $cobro->FechaCobro );
		}
		$dataFacB = $dataprovider->getData ();
		
		$headers = array (
				//'Indice',
				'NumFactura',
				'Fecha',
				array (
						'header' => 'Cliente',
						'field' => 'cliente::descripcion' 
				),
				'Detalles',
				array (
						'header' => 'Total',
						'field' => 'Importe' 
				),
				array (
						'header' => 'Pago',
						'field' => array (
								array (
										'header' => 'Forma',
										'field' => 'cobrado' 
								),
								array (
										'header' => 'Nro. Compr.',
										'field' => 'formaPago::Nombre' 
								),
								'nro_cheque_certificado',
								'FechaCobro'
						) 
				),
				array (
						'header' => 'Mes IVA',
						'field' => 'mes_iva'
				),
				array (
						'header' => 'Nro. OP',
						'field' => 'numero_op'
				),
				array (
						'header' => 'Pedido Fondo',
						'field' => 'numero_pedido_fondo'
				),
				array (
						'header' => 'Expediente',
						'field' => 'expediente'
				),
		);
		// $headers = $dataprovider->model->attributeNames();
		$autor = 'Usuario creador:' . UsersLogin::getAdministradorUserNameByUsersLoginID ( Yii::app ()->user->id );
		$title = 'Ventas VARI';
		$titleSheet = 'FAC ELECTRONICA "A"';
		$fromDataRow = 8;
		$titles = array (
				'Detalle de Factura VARI s.r.l.',
				'FACTURAS ELECTRONICAS A' 
		);
		//LGoicoExcel::createExcel ( $data, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		Yii::import ( 'ext.phpexcel.LGoicoExcel' );
		$excelGenerator = new LGoicoExcel();
		$excelGenerator->createExcelTemplate ("TemplateVentasRA.xlsx", $dataFacA, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		
		$titleSheet = 'FAC ELECTRONICA "B"';
		$fromDataRow = 8;
		$titles = array (
				'Detalle de Factura VARI s.r.l.',
				'FACTURAS ELECTRONICAS B'
		);
		$nroSheet=1;
		$excelGenerator->writeData($nroSheet,$dataFacB,$titles, $titleSheet, $headers,$fromDataRow);
		//$excelGenerator->createSheetExcelTemplate("TemplateVentasRA.xlsx", $dataFacB, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		
		$excelGenerator->downloadXLS();
	}
	public function actionExportar($nombreArchivo) {
		$model = new Cobro ();
		if (isset ( $_GET ['Cobro'] )) {
			$model->attributes = $_GET ['Cobro'];
		}
		$dataprovider = $model->searchFiltros ();
		foreach ( $dataprovider->getData () as $cobro ) {
			$cobro->en_blanco = $cobro->en_blanco == 0 ? 'No' : 'Si';
			$cobro->cobrado = $cobro->cobrado == 0 ? 'No' : 'Si';
			$cobro->Fecha = LGHelper::functions ()->displayFecha ( $cobro->Fecha );
		}
		Yii::import ( 'ext.ECSVExport' );
		$csv = new ECSVExport ( $dataprovider );
		$this->preparateAndExecuteCSV ( $csv, $nombreArchivo );
	}
	public function preparateAndExecuteCSV($csv, $nombreArchivo) {
		$headers = array (
				'id_cuenta' => 'Total',
				'Monto' => 'Importe' 
		)
		// 'en_orden_pago' => 'Total'
		;;

		;
		
		$csv->setHeaders ( $headers );
		$csv->setExclude ( array (
				'Indice',
				'NumFactura',
				'Fecha',
				
				'id_cobro',
				'id_obra',
				'id_proveedor',
				'id_tipo_comprobante',
				'id_cuenta',
				'id_contrato',
				'Importe' 
		)
		// 'en_orden_pago',
		 ) ;
		$csv->convertActiveDataProvider = false;
		$csv->setModelRelations ( array (
				
				'imputacion' => array (
						'descripcion' 
				),
				'formaPago' => array (
						'descripcion' 
				),
				'cuentaBanco' => array (
						'descripcion' 
				),
				'cuenta' => array (
						'descripcion' 
				),
				
				'obra' => array (
						'descripcion' 
				),
				
				'cuenta' => array (
						'descripcion' 
				),
				'cliente' => array (
						'descripcion' 
				) 
		) );
		$content = $csv->toCSV ();
		Yii::app ()->getRequest ()->sendFile ( $nombreArchivo . '.csv', $content, "text/csv", false );
		exit ();
		Yii::app ()->end ();
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Cobro::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'cobro-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionCambiarFactura() {
		$model= new Cobro();	
		if (isset ( $_POST ['Cobro'] )) {
     			$model->attributes = $_POST ['Cobro'];                		
				$id_lead_last = Yii::app ()->db->createCommand ( "SELECT secuencia FROM `tipo_factura` WHERE id_tipo_factura=".$model->id_tipo_factura )->queryScalar ();
				$id_lead_new = $id_lead_last + 1;
				$model->NumFactura = $id_lead_new;
		}
		echo CHtml::activeTextField($model,'NumFactura',array('size'=>20,'maxlength'=>20,'readonly'=>false));  
	}

	public function validarClienteObra($model) {
		if ($model->id_obra==0 || $model->id_obra==null)
		    //Agrega eeror
		    null;
		 elseif ($model->id_cliente==null)
		 //Agrega eeror
		 null;
		 elseif ($model->id_cliente==0)
		 //agrego cliente
		 null;
		 else
		 	null;
	}
	public function actionAnularFactura() {
		$facturaOriginal = new Cobro ();
		// cheque original
		if (isset ( $_GET ['id'] ))
			$facturaOriginal = Cobro::model ()->findByPk ( $_GET ['id'] );
		else {
			echo $_GET ['id'];
			Yii::app ()->end ();
		}
		//print_r($_GET ['id']);
		$notaCredito = $facturaOriginal->anularFactura ();
		echo "Factura ANULADA - Nota de Crédito nro.: ".$notaCredito->NumFactura;
	}

	public function actionImprimirOrden() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION MINUTA DE VENTA';
		$html = $this->renderPartial ( 'facturaImpresion', array (
				'titulo' => $titulo,
				'model' => $model
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function actionImprimirCobroItem() {
		$model =  CobroItem::model ()->findbyPk ( $_GET ['id'] );;
		$titulo = 'IMPRESION MINUTA DE VENTA';
		$html = $this->renderPartial ( 'facturaImpresion', array (
				'titulo' => $titulo,
				'model' => $model
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}

	public function actualizarCobrado($idcobro){
		$model = Cobro::model ()->findbyPk ( $idcobro );
		$model->cobrado = (0.00 == $model->getPendienteCobro());
		$model->save();
	}

	public function actionAgregarCobroItem() {
		$model = new CobroItem ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$cobro = Cobro::model ()->findbyPk ( $_GET ['id_cobro'] );
			echo '<div class="contenedor-fila"  id="saldos_cobro">	
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
					class="contenedor-columna">
					<b><label>TOTAL A COBRAR</label></b> <b>$ '. $cobro->Importe.'</b>
			</div>	
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
						class="contenedor-columna">
				<b><label>TOTAL COBRADO</label></b> <b>$'.LGHelper::functions ()->formatNumber($cobro->getTotalCobrado()).'</b>
			</div>
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(12, 12, 12); width: 200px; text-align: center; padding: 5px;"
						class="contenedor-columna">
				<b><label>PENDIENTE COBRO</label></b> <b>$ '.  LGHelper::functions ()->formatNumber($cobro->getPendienteCobro()).'</b>
				- <b style="color: black;" >'.($cobro->cobrado?'COBRADO':'PENDIENTE').'</B>
			</div>
			</div>
		</div>';
		} else {
			if (isset ( $_GET ['CobroItem'] )) {
				$model->attributes = $_GET ['CobroItem'];
				if (isset ( $_GET ['id_cobro'] ))
					$model->id_cobro = $_GET ['id_cobro'];
				if ($model->save ()) {
					$this->actualizarCobrado($model->id_cobro);
					echo "Cobro/Retencion  Registrado";
				}	
				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}

	public function actionAnularCobroItem() {
		$model = CobroItem::model()->findbyPk($_GET ['id'] );
		$id_cobro = $model->id_cobro;
		$cobro = Cobro::model ()->findbyPk ( $id_cobro );
		$model->id_cobro = -1 * $model->id_cobro ;
		$model->Importe = -1 * LGHelper::functions ()->unformatNumber ($model->Importe );
		$model->Importe = LGHelper::functions ()->formatNumber ($model->Importe );
		$model->Fecha =  date ( "Y-m-d", date () );
		$model->save();
		$this->actualizarCobrado($id_cobro);
		echo '<div class="contenedor-fila"  id="saldos_cobro">	
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
					class="contenedor-columna">
					<b><label>TOTAL A COBRAR</label></b> <b>$ '. $cobro->Importe.'</b>
			</div>	
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
						class="contenedor-columna">
				<b><label>TOTAL COBRADO</label></b> <b>$'.LGHelper::functions ()->formatNumber($cobro->getTotalCobrado()).'</b>
			</div>
			<div style="background: white; border-radius: 25px; border: 2px solid rgb(12, 12, 12); width: 200px; text-align: center; padding: 5px;"
						class="contenedor-columna">
				<b><label>PENDIENTE COBRO</label></b> <b>$ '.  LGHelper::functions ()->formatNumber($cobro->getPendienteCobro()).'</b>
				- <b style="color: black;" >'.($cobro->cobrado?'COBRADO':'PENDIENTE').'</B>
			</div>
			</div>
		</div>';
		
	}
}
