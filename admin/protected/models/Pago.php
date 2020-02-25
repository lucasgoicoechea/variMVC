<?php
class Pago extends CActiveRecord {
	public $obra = null;
	public function getObra() {
		return $this->obra;
	}
	public function setObra($dobra) {
		return $this->obra = $dobra;
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'pagos';
	}
	public function rules() {
		return array (
				array (
						' id_proveedor, id_cuenta, pagado,  fecha_emision',
						'required' 
				),
				array (
						'numero, pagado',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'id_proveedor, id_cuenta',
						'numerical',
						'min' => 1,
						'integerOnly' => true,
						'tooSmall' => 'Debe ingresar una Cuenta y Proveedor' 
				),
				array (
						'id_pago,  id_proveedor, numero,id_cuenta, pagado, fecha_cobro, fecha_emision',
						'safe' 
				) 
		);
		// 'on' => 'search'
		
		
	}
	public function relations() {
		return array (
				/*'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),*/
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta' 
				) 
		);
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function attributeLabels() {
		return array (
				'id_pago' => Yii::t ( 'app', 'Pago' ),
				// 'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'id_cuenta' => Yii::t ( 'app', 'Cuenta' ),
				'pagado' => Yii::t ( 'app', 'Pagado' ),
				'fecha_cobro' => Yii::t ( 'app', 'Fecha Cobro' ),
				'fecha_emision' => Yii::t ( 'app', 'Fecha Emision' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'numero', $this->numero );
		$criteria->compare ( 'id_pago', $this->id_pago );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'pagado', $this->pagado );
		
		$criteria->compare ( 'fecha_cobro', $this->fecha_cobro, true );
		$criteria->compare ( 'fecha_emision', $this->fecha_emision, true );


		//$criteria->addCondition(' id_pago < 2298');
		 $criteria->order = ' t.fecha_emision DESC';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 50 
				),
				'sort' => array (
						'defaultOrder' => ' fecha_emision DESC' 
				) 
		) );
	}
	
	public function cambiarCuentaMediosPago($id_cuenta){
		$this->cambiarCuentaPagosEfectivosBorrar($id_cuenta);
		$this->cambiarCuentaPagosCheques($id_cuenta);
		$this->cambiarCuentaPagosTarjetas($id_cuenta);
		$this->cambiarCuentaPagosTransferencias($id_cuenta);
	}
	public function cambiarCuentaPagosTransferencias($id_cuenta){
		$resultados = TransferenciaPago::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			$caja = Caja::model ()->getUltimaCaja ();
			foreach ( $resultados as $value ) {
				if ($caja->id_caja!=$value->caja_id) {  //si la caja no es la caja abierta
					BajaMedioPago::saveBajaTransferenciaPago($value,$this->id_cuenta);
				}
				$mod = new TransferenciaPago();
				$mod->id_cuenta_banco= $value->id_cuenta_banco;
				$mod->monto=$value->monto;
				$mod->id_pago=$value->id_pago;
				$mod->cbu_destino=$value->cbu_destino;
				$mod->referencia=$value->referencia;
				$mod->caja_id = $caja->id_caja;
				$mod->save();
				$value->delete();
			}
		}
	}
	public function cambiarCuentaPagosTarjetas($id_cuenta){
		$resultados = TarjetaPago::model ()->searchWithPagoOO ($this->id_pago);
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$mod = new TarjetaPago();
				$mod->id_pago = $value->id_pago; 
				$mod->monto=$value->monto;
				$mod->id_tarjeta=$value->id_tarjeta;
				$mod->fecha_pago=$value->fecha_pago;
				$mod->detalle=$value->detalle;
				$mod->save();
				$value->delete();
			}
		}
	}
	public function cambiarCuentaPagosCheques($id_cuenta){
		$resultados = PagoCheque::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$mod = new PagoCheque();
				$mod->cheque= $value->cheque;
				$mod->id_pago  = $value->id_pago;
				$mod->id_cheque  = $value->id_cheque;
				$mod->save();
				$value->delete();
			}
		}
	}
	
	public function cambiarCuentaPagosEfectivosBorrar($id_cuenta){
	    $resultados = EfectivoPago::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			$caja = Caja::model ()->getUltimaCaja ();
			foreach ( $resultados as $value ) {
				if ($caja->id_caja!=$value->caja_id) {  //si la caja no es la caja abierta
						BajaMedioPago::saveBajaEfectivoPago($value,$this->id_cuenta);
				}
				$mod = new EfectivoPago();
				$mod->id_pago= $value->id_pago;
				$mod->monto = $value->monto;
				$mod->detalle=$value->detalle;
				$mod->save();
				$value->delete();
			}
		}
		 
	}
	
	public function crearNuevoPagoPagado($idObra, $idProveedor, $idCuenta, $fechaCobro) {
		$pago = new Pago ();
		$pago->pagado = 1;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_pago`) as `max` FROM `pagos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$pago->numero = $id_lead_new;
		$pago->fecha_emision = CTimestamp::formatDate ( 'Y-m-d' );
		$pago->fecha_cobro = $fechaCobro;
		// $pago->id_obra = $idObra;
		$pago->id_proveedor = $idProveedor;
		$pago->id_cuenta = $idCuenta;
		return $pago;
	}
	public function crearNuevoPagoPendiente($idObra, $idProveedor, $idCuenta, $fechaCobro) {
		$pago = new Pago ();
		$pago->pagado = 0;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_pago`) as `max` FROM `pagos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$pago->numero = $id_lead_new;
		$pago->fecha_emision = CTimestamp::formatDate ( 'Y-m-d' );
		$pago->fecha_cobro = $fechaCobro;
		// $pago->id_obra = $idObra;
		$pago->id_proveedor = $idProveedor;
		$pago->id_cuenta = $idCuenta;
		return $pago;
	}
	public function getMonto() {
		// debe recorrer todas ordenes de pago y genera el monto
		$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $this->id_pago );
		$montoTotalPAGAR = 0;
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalPAGAR = $montoTotalPAGAR + $value->ordenPago->getMonto ();
			}
		}
		return $montoTotalPAGAR;
	}
	public function getMontoPagado() {
		// debe recorrer todas los medios de pago y genera el monto
		$total = $this->getMontoPagadoCheque ();
		$total = $total + Pago::model ()->getTotalMontoTransfenrencia ( $this->id_pago );
		$total = $total + Pago::model ()->getTotalMontoEfectivo ( $this->id_pago );
		$total = $total + Pago::model ()->getTotalMontoTarjeta ( $this->id_pago );
		return $total;
	}
	public function getMontoPagadoCheque() {
		// debe recorrer todas los medios de pago y genera el monto
		$montoTotalCheque = 0.00;
		$resultados = PagoCheque::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				if (! $value->cheque->anulado) {
					$montoTotalCheque = $montoTotalCheque + LGHelper::functions ()->unformatNumber ( $value->cheque->Importe );
				}
			}
		}
		return $montoTotalCheque;
	}
	public function getMontoPagadoID($idPago) {
		// debe recorrer todas los medios de pago y genera el monto
		$pago = Pago::findByPk ( $idPago );
		return $pago->getMontoPagado ();
	}
	public function isPagado() {
		return $this->pagado;
	}
	public function getTotalMontoTransfenrencia($idPago) {
		// debe recorrer todas los medios de pago y genera el monto
		$montoTotalTrans = 0.00;
		$resultados = TransferenciaPago::model ()->searchWithPagoOO ( $idPago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalTrans = $montoTotalTrans + LGHelper::functions ()->unformatNumber ( $value->monto );
			}
		}
		return $montoTotalTrans;
	}
	public function getTotalMontoTarjeta($idPago) {
		// debe recorrer todas los medios de pago y genera el monto
		$montoTotalTrans = 0.00;
		$resultados = TarjetaPago::model ()->searchWithPagoOO ( $idPago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalTrans = $montoTotalTrans + LGHelper::functions ()->unformatNumber ( $value->monto );
			}
		}
		return $montoTotalTrans;
	}
	public function getTotalMontoEfectivo($idPago) {
		// debe recorrer todas los medios de pago y genera el monto
		$montoTotalTrans = 0;
		$resultados = EfectivoPago::model ()->searchWithPagoOO ( $idPago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalTrans = $montoTotalTrans + LGHelper::functions ()->unformatNumber ( $value->monto );
			}
		}
		return $montoTotalTrans;
	}
	public function getUrlAgregarTransferencia($id_pago) {
		$url = Yii::app ()->createUrl ( 'pago/agregarTransferenciaPago', array (
				'id_pago' => $id_pago 
		) );
		return $url;
	}
	public function getUrlAgregarEfectivo($id_pago) {
		$url = Yii::app ()->createUrl ( 'pago/agregarEfectivoPago', array (
				'id_pago' => $id_pago 
		) );
		return $url;
	}
	public function getUrlAgregarTarjeta($id_pago) {
		$url = Yii::app ()->createUrl ( 'pago/agregarTarjetaPago', array (
				'id_pago' => $id_pago 
		) );
		return $url;
	}
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'pago/imprimirPago', array (
				'id' => $this->id_pago 
		) );
		return $url;
	}
	public function getUrlVerDetalle() {
		$url = Yii::app ()->createUrl ( 'pago/view', array (
				'id' => $this->id_pago 
		) );
		return $url;
	}
	public function getUrlEditar() {
		$url = Yii::app ()->createUrl ( 'pago/update', array (
				'id' => $this->id_pago 
		) );
		return $url;
	}
	public function getProveedorDescripcion() {
		$prov = $this->proveedor != null ? $this->proveedor : new Proveedor ();
		return $prov->getDescripcion ();
	}
	public function getOrdenPago() {
		$dd = new PagoOrdenPago ();
		$dd = PagoOrdenPago::model ()->find ( 'id_pago=' . $this->id_pago ); // PagoOrdenPago::model()->getUltimaOP($this->id_pago);
		                                                                     // return $dd->ordenPago;
		return $dd;
	}
	public function getPagosRegistradosEnFechaACuenta($fecha, $idCuenta, $pagado) {
		$criteria = new CDbCriteria ();
		$pagadosql = $pagado ? ' t.pagado=1 ' : ' t.pagado=0 ';
		$criteria->addCondition ( ' t.id_cuenta=' . $idCuenta );
		$criteria->addCondition ( $pagadosql );
		$criteria->addBetweenCondition ( 'fecha_emision', $fecha, $fecha );
		$result = Pago::model ()->findAll ( $criteria );
		Yii::log ( "conditiosn" . $criteria->condition, CLogger::LEVEL_WARNING, 'CierreDiario' );
		return $result;
	}
	function getGastoFechaCuentaID($fecha, $idCuenta, $pagado) {
		// esto los tienen pagos, con el pago pagado o no
		// NO SON LOS PAGOS DEL DIA, SINO LOSCOMPROBANTES
		$result = 0.00;
		// Yii::log("Buscando Gastos con params:".$fecha."|IDCta:".$idCuenta."|pagado:".$pagado, CLogger::LEVEL_WARNING, 'CierreDiario');
		$pagos = Pago::model ()->getPagosRegistradosEnFechaACuenta ( $fecha, $idCuenta, $pagado );
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$result = $result + $pago->getMonto ();
			}
		}
		return $result;
	}
	function getGastosFechaCuentaID($fecha, $idCuenta, $pagado) {
		// esto los tienen pagos, con el pago pagado o no
		// NO SON LOS PAGOS DEL DIA, SINO LOSCOMPROBANTES
		$comprobantes = array ();
		$pagos = Pago::model ()->getPagosRegistradosEnFechaACuenta ( $fecha, $idCuenta, $pagado );
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$gastos = $pago->getGastos ();
				foreach ( $gastos as $gasto ) {
					$comprobantes [] = $gasto;
				}
			}
		}
		return $comprobantes;
	}
	public function getGastos() {
		// debe recorrer todas ordenes de pago y genera el monto
		$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $this->id_pago );
		$gastos = array ();
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				//var_dump($value);
				$listGastos = $value->ordenPago->getComprobantes ();
				foreach ( $listGastos as $gasti ) {
					$gastos [] = $gasti;
				}
			}
		}
		return $gastos;
	}
	public function getPrimeraObra() {
		$gastos = $this->getGastos ();
		return $gastos != null ? $gastos [0]->getObra () : null;
	}
	public function afterFind() {
		$this->fecha_emision = LGHelper::functions ()->displayFecha ( $this->fecha_emision );
		$this->fecha_cobro = LGHelper::functions ()->displayFecha ( $this->fecha_cobro );
		$this->setObra ( $this->getPrimeraObra () );
		return parent::afterFind ();
	}
	public function save() {
		$this->fecha_emision = LGHelper::functions ()->undisplayFecha ( $this->fecha_emision );
		$this->fecha_cobro = LGHelper::functions ()->undisplayFecha ( $this->fecha_cobro );
		return parent::save ();
	}
	public function borrarPagosImputaciones(){
		$this->borrarPagosCheques();
		$this->borrarPagosEfectivo();
		$this->borrarPagosTransferencias();
		$this->borrarPagosTarjetas();
	}

	public function borrarPagosEfectivo(){
	    $resultados = EfectivoPago::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			$caja = Caja::model ()->getUltimaCaja ();
			foreach ( $resultados as $value ) {
				if ($caja->id_caja!=$value->caja_id) {  //si la caja no es la caja abierta
					echo $caja->id_caja.'--'.$value->caja_id;
					//exit;
					BajaMedioPago::saveBajaEfectivoPago($value,$this->id_cuenta);
				}
				$value->delete();
			}
		}
	}
		
	public function borrarPagosCheques(){
		$resultados = PagoCheque::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$value->cheque->anulado = false;
				$value->cheque->id_pago = null;
				$value->cheque->Importe = null;
				$value->cheque->a_la_orden = '';
				$value->cheque->save();
				$value->delete();
			}
		}
	}
	
	public function borrarPagosTarjetas(){
	    $resultados = TarjetaPago::model ()->searchWithPagoOO ($this->id_pago);
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$value->delete();
			}
		}
	}

	public function borrarPagosTransferencias(){
		$resultados = TransferenciaPago::model ()->searchWithPagoOO ( $this->id_pago );
		if (sizeof ( $resultados ) > 0) {
		    $caja = Caja::model ()->getUltimaCaja ();
			foreach ( $resultados as $value ) {
				if ($caja->id_caja!=$value->caja_id) {  //si la caja no es la caja abierta
					BajaMedioPago::saveBajaTransferenciaPago($value,$this->id_cuenta);
				}
				$value->delete();
			}
		}
	}	
	
}
