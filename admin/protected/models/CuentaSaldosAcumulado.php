<?php
class CuentaSaldosAcumulado extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cuenta_saldos_acumulado';
	}
	public function rules() {
		return array (
				array (
						'id_cuenta_saldos_acumulado, id_caja, id_cuenta',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'saldo_inicio, saldo_gastos, saldo_contra_asientos,saldo_gastos_pendientes, saldo_transferencias, saldo_cheques, saldo_pago_efectivo, saldo_tarjetas, saldo_cobros, saldo_ingresos_cuenta,saldo_transferencias_pago,saldo_retiro_capital,saldo_diario',
						'length',
						'max' => 40 
				),
				array (
						'usuario_log',
						'length',
						'max' => 60 
				),
				array (
						'id_cuenta_saldos_acumulado, saldo_contra_asientos,id_caja, saldo_inicio, saldo_gastos, saldo_gastos_pendientes, saldo_transferencias, saldo_cheques, saldo_pago_efectivo, saldo_tarjetas, saldo_cobros, saldo_ingresos_cuenta, id_cuenta,saldo_diario, usuario_log, fecha_log,saldo_transferencias_pago,saldo_retiro_capital',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
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
				'id_cuenta_saldos_acumulado' => Yii::t ( 'app', 'Id Cuenta Saldos Acumulado' ),
				'id_caja' => Yii::t ( 'app', 'Id Caja' ),
				'saldo_inicio' => Yii::t ( 'app', 'Saldo Inicio' ),
				'saldo_gastos' => Yii::t ( 'app', 'Saldo Gastos' ),
				'saldo_gastos_pendientes' => Yii::t ( 'app', 'Saldo Gastos Pendientes' ),
				'saldo_transferencias' => Yii::t ( 'app', 'Saldo Transferencias' ),
				'saldo_cheques' => Yii::t ( 'app', 'Saldo Cheques' ),
				'saldo_pago_efectivo' => Yii::t ( 'app', 'Saldo Pago Efectivo' ),
				'saldo_tarjetas' => Yii::t ( 'app', 'Saldo Tarjetas' ),
				'saldo_cobros' => Yii::t ( 'app', 'Saldo Cobros' ),
				'saldo_ingresos_cuenta' => Yii::t ( 'app', 'Saldo Ingresos Cuenta' ),
				'id_cuenta' => Yii::t ( 'app', 'Id Cuenta' ),
				'usuario_log' => Yii::t ( 'app', 'Usuario Log' ),
				'fecha_log' => Yii::t ( 'app', 'Fecha Log' ) 
		);
	}
	public function getAcumCajaID($id_caja) {
		// Yii::log("busque CuentasaldosID".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
		$caja = Caja::model ()->getByID ( $id_caja );
		//Yii::log("busque CuentasaldosID".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
		$criteria = new CDbCriteria ();
		$criteria->order = ' id_cuenta ';
		if ($caja->cerrada) {
			$criteria->condition = ' t.id_caja=' . $id_caja;
			$results = CuentaSaldosAcumulado::model ()->findAll ( $criteria );
			return $results;
		} else { // si la caja esta abierta, tomo los saldos de ultimo cierre
		         // mas los saldos calculados de movimientos*/
		   // Yii::log("Caja ID:".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
			$cajaAnt = Caja::model ()->getCajaAnterior ( $caja );
			// Yii::log("Caja Anterior:".$cajaAnt->fecha, CLogger::LEVEL_WARNING, 'CierreDiario');
			$resultTmp = CuentaSaldosAcumulado::model ()->calcularSaldosAcumulados ( $cajaAnt, $id_caja, $caja );
			return $resultTmp;
		}
		return $results;
	}
	public function getAcumCajaIDCuentasActivas($id_caja) {
		// Yii::log("busque CuentasaldosID".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
		$caja = Caja::model ()->getByID ( $id_caja );
		//Yii::log("busque CuentasaldosID".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
		$criteria = new CDbCriteria ();
		$criteria->order = ' id_cuenta ';
		if ($caja->cerrada) {
			$criteria->condition = ' t.id_caja=' . $id_caja;
			$results = CuentaSaldosAcumulado::model ()->findAll ( $criteria );
			$results = CuentaSaldosAcumulado::model()->filtrarCuentasActivas($results);
			return $results;
		} else { // si la caja esta abierta, tomo los saldos de ultimo cierre
			// mas los saldos calculados de movimientos*/
			// Yii::log("Caja ID:".$id_caja, CLogger::LEVEL_WARNING, 'CierreDiario');
			$cajaAnt = Caja::model ()->getCajaAnterior ( $caja );
			// Yii::log("Caja Anterior:".$cajaAnt->fecha, CLogger::LEVEL_WARNING, 'CierreDiario');
			$resultTmp = CuentaSaldosAcumulado::model ()->calcularSaldosAcumulados ( $cajaAnt, $id_caja, $caja );
			$resultTmp = CuentaSaldosAcumulado::model()->filtrarCuentasActivas($resultTmp);
			return $resultTmp;
		}
		return $results;
	}
	public function filtrarCuentasActivas($listarCuentasSaldosAcum){
		foreach ($listarCuentasSaldosAcum  as $key => $cuentaSaldoAcum) {
			if($cuentaSaldoAcum->isCuentaCerrada()){
				unset($listarCuentasSaldosAcum[$key]);
			}
		}
		return $listarCuentasSaldosAcum;		
	}
	public function isCuentaCerrada(){
	     return $this->cuenta->cerrada;	
	}
	
	public function calcularSaldosAcumulados($cajaAnterior, $idCaja, $caja) {
		$cuentas = Cuenta::model ()->findAll ();
		foreach ( $cuentas as $cuenta ) {
			$ctaSaldoAcum = CuentaSaldosAcumulado::model ()->getCuentaCaja ( $idCaja, $cuenta->id_cuenta );
			if ($ctaSaldoAcum == null) {
				$ctaSaldoAcum = new CuentaSaldosAcumulado ();
				$ctaSaldoAcum->id_caja = $idCaja;
				$ctaSaldoAcum->id_cuenta = $cuenta->id_cuenta;
			}
			$ctaSaldoAcum->saldo_inicio = CuentaSaldosAcumulado::model ()->getSaldoFinal ( $cajaAnterior, $cuenta->id_cuenta );
                        //$cajaAnterior->getSaldoFinalTemporal();
			$ctaSaldoAcum->saldo_gastos = CuentaSaldosAcumulado::model ()->getGastosPagados ( $caja->id_caja, $cuenta->id_cuenta );
			// Pago::model ()->getGastoFechaCuentaID ( $caja->fecha, $cuenta->id_cuenta, 1 );
			$ctaSaldoAcum->saldo_gastos_pendientes = CuentaSaldosAcumulado::model ()->getGastosPendientes (  $caja->id_caja, $cuenta->id_cuenta );
			// Pago::model ()->getGastoFechaCuentaID ( $caja->fecha, $cuenta->id_cuenta, 0 );
			// Antes pense q era transfernecias usadas para el pago
			$ctaSaldoAcum->saldo_transferencias_pago = TransferenciaPago::model ()->getTransferenciaCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			// pero son las transferencias entre cuentas 11-4-17
			$ctaSaldoAcum->saldo_transferencias = Transferencia::model ()->getBySaldoCuentaPorCajaID( $caja->id_caja, $cuenta->id_cuenta );
			
			$ctaSaldoAcum->saldo_retiro_capital = RetiroCapital::model ()->getRetiroCapitalCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_cheques = PagoCheque::model ()->getChequesCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_pago_efectivo = EfectivoPago::model ()->getEfectivoPagoCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_tarjetas = TarjetaPago::model ()->getTarjetasPagoCajaIDCuentaID ($caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_cobros = Cobro::model ()->getCobroCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_ingresos_cuenta = IngresoCuenta::model ()->getIngresoCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_contra_asientos = BajaMedioPago::model()->getBajaMedioPagoCajaIDCuentaID ( $caja->id_caja, $cuenta->id_cuenta );
			$ctaSaldoAcum->saldo_diario = $ctaSaldoAcum->getSaldoFinalTemporal ();
			$ctaSaldoAcum->save ();
			//Yii::log ( 'VALOR'.var_dump($ctaSaldoAcum->errors), CLogger::LEVEL_WARNING, 'MONTO-FORMAT' );
		}
		$criteria = new CDbCriteria ();
		$criteria->order = ' id_cuenta ';
		$criteria->condition = ' id_caja=' . $idCaja;
		$results = CuentaSaldosAcumulado::model ()->findAll ( $criteria );
		return $results;
	}
	public function existeCuentaCaja($idCaja, $idCuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_caja=' . $idCaja . ' and id_cuenta=' . $idCuenta;
		$results = CuentaSaldosAcumulado::model ()->find ( $criteria );
		if ($results == null) {
			return false;
		}
		return true;
	}
	public function getCuentaCaja($idCaja, $idCuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_caja=' . $idCaja . ' and id_cuenta=' . $idCuenta;
		$results = CuentaSaldosAcumulado::model ()->find ( $criteria );
		return $results;
	}
	public function getSaldoFinal($cajaAnt, $idCuenta) {
		$criteria = new CDbCriteria ();
		if ($cajaAnt->id_caja == null) {
			return 0.00;
		}
		$criteria->condition = ' id_caja=' . $cajaAnt->id_caja . ' and id_cuenta=' . $idCuenta;
		$result = CuentaSaldosAcumulado::model ()->find ( $criteria );
                return $result->saldo_diario;
		if ($result != null) {
			$ingresos = $result->saldo_inicio +$result->saldo_ingresos_cuenta+$result->saldo_transferencias+$this->saldo_contra_asientos; // $result->saldo_cobros + 
			// solo tomo como egreso los medios de pagos
			$egresos = $this->saldo_transferencias_pago +$result->saldo_cheques + $result->saldo_pago_efectivo + $result->saldo_tarjetas + $this->saldo_retiro_capital;
			return $ingresos - $egresos;
		}
		return 0.00;
	}
	public function getSaldoFinalTemporal() {
		$ingresos = $this->saldo_inicio + $this->saldo_cobros + $this->saldo_ingresos_cuenta + $this->saldo_transferencias+$this->saldo_contra_asientos;
		$egresos = $this->saldo_transferencias_pago + $this->saldo_cheques + $this->saldo_pago_efectivo + $this->saldo_tarjetas + $this->saldo_retiro_capital;
		return $ingresos - $egresos;
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cuenta_saldos_acumulado', $this->id_cuenta_saldos_acumulado );
		
		$criteria->compare ( 'id_caja', $this->id_caja );
		
		$criteria->compare ( 'saldo_inicio', $this->saldo_inicio, true );
		
		$criteria->compare ( 'saldo_gastos', $this->saldo_gastos, true );
		
		$criteria->compare ( 'saldo_gastos_pendientes', $this->saldo_gastos_pendientes, true );
		
		$criteria->compare ( 'saldo_transferencias', $this->saldo_transferencias, true );
		
		$criteria->compare ( 'saldo_cheques', $this->saldo_cheques, true );
		
		$criteria->compare ( 'saldo_pago_efectivo', $this->saldo_pago_efectivo, true );
		
		$criteria->compare ( 'saldo_tarjetas', $this->saldo_tarjetas, true );
		
		$criteria->compare ( 'saldo_cobros', $this->saldo_cobros, true );
		
		$criteria->compare ( 'saldo_ingresos_cuenta', $this->saldo_ingresos_cuenta, true );
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'usuario_log', $this->usuario_log, true );
		
		$criteria->compare ( 'fecha_log', $this->fecha_log, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getGastosPagados($id_caja, $idCuenta) {
		return CuentaSaldosAcumulado::model ()->getGastosRegistradosEnFechaACuenta ($id_caja, $idCuenta, true);
	}

	public function getGastosPendientes($id_caja, $idCuenta) {
		$gastin = Gasto::model()->getPendientesPorCajaIDCuentaID($id_caja,$idCuenta);
		$tot = 0.00;
		foreach ($gastin as $gasto){
			$tot = $tot + $gasto->Monto;
		}
		return $tot;
	}
	
	public function borrarCuentaSaldosAcumulados($id_caja) {
	    $reuslts = CuentaSaldosAcumulado::getAcumCajaID($id_caja);
		foreach ($reuslts as $cueTmp){
			$cueTmp->delete();
		}
	}
	public function getByCajaEntreFechas($fechaDesde, $fechaHasta) {
		// $results[];
		// Yii::log($fechaHasta);
		if ($fechaHasta == NULL) {
			$caja = Caja::model ()->getUltimaCaja ();
			$results = $this->getAcumCajaID ( $caja->id_caja );
			return $results;
		}
		$caja = Caja::model ()->getPorFecha ( $fechaHasta );
		if ($caja != null) {
			$results = $this->getAcumCajaID ( $caja->id_caja );
		}
		return $results;
	}
	public function getGastosRegistradosEnFechaACuenta($id_caja, $idCuenta, $pagado) {
		Yii::app ()->db->createCommand ("SET SQL_BIG_SELECTS = 1")->execute();
		$results = Yii::app ()->db->createCommand (
               'select `gas`.`id_gasto` AS `id_gasto`,`gas`.`Monto` AS `Monto`,`gas`.`id_obra` AS `id_obra`,`gas`.`id_proveedor` AS `id_proveedor`,`gas`.`FechaAsiento` AS `FechaAsiento`,`pag`.`pagado` AS `pagada`,`pag`.`id_cuenta` AS `id_cuenta`,`pag`.`id_pago` AS `id_pago`,`gas`.`caja_id` AS `caja_id` from ((((`orden_pago` `op` join `orden_pago_gasto` `op_gas` on((`op`.`id_orden_pago` = `op_gas`.`id_orden_pago`))) join `gastos` `gas` on((`gas`.`id_gasto` = `op_gas`.`id_gasto`))) join `pago_orden_pago` `pag_op` on((`pag_op`.`id_orden_pago` = `op`.`id_orden_pago`))) join `pagos` `pag` on((`pag_op`.`id_pago` = `pag`.`id_pago`)))'
                        . 'where  `pag`.`id_cuenta`=' . $idCuenta . ' and `gas`.`caja_id`="' . $id_caja.'" ')->queryAll () ;
		$sma = 0.00;
		foreach ( $results as $result ) {
			if ($pagado && $result['pagada'])
			  $sma = $sma + $result['Monto'];
			if (!$pagado && !$result['pagada'])
				$sma = $sma + $result['Monto'];
		}
		//return sizeof($results);
		return $sma;
	}
}
