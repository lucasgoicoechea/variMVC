<?php
class MedioPagoForm extends CFormModel {
	public $monto = 0.00;
	public $detalle = ''; // array de Gasto
	public $id_medio_pago= 3; //defecto efectivo
	public $fecha = null; //date('h-i-s');
	public $nro_cheque = null;
	public $id_cuenta_banco= 1;
	public $id_proveedor = null;
	
	public function rules() {
		return array (
				array (
						"anio",
						"required" 
						
				),
				array (
						"mes",
						"safe" 
				) 
		)
		;
	}
	public function generateDataXLSSinIVA() {
		if ($this->mes == null) {
			return $this->generateDataXLSTodosMeses ( false );
		}
		return $this->generateDataXLSUnMes ( false );
	}
	public function generateDataXLS() {
		if ($this->mes == null) {
			return $this->generateDataXLSTodosMeses ( true );
		}
		return $this->generateDataXLSUnMes ( true );
	}
	public function generateDataXLSTodosMeses($conIVA) {
		$meses = array ();
		for($i = 0; $i < 12; $i ++) {
			$balance = new BalanceMensualesForm ();
			$balance->anio = $this->anio;
			$balance->mes = $i + 1;
			$balance->gastos = Gasto::model ()->findGastosPorMesAnio ( $this->anio, $i + 1, $conIVA );
			$balance->totalGastos = $balance->getTotalGastado ();
			$balance->totalIVAGastos = $balance->getIVACompras ();
			$balance->totalVentas = $balance->getVentasMes ();
			$balance->totalIVAVentas = $balance->getIVAVentas ();
			$meses [$i] = $balance;
		}
		return $meses;
	}
	public function generateDataXLSUnMes($conIVA = true) {
		$meses = array ();
		$this->gastos = Gasto::model ()->findGastosPorMesAnio ( $this->anio, $this->mes, $conIVA );
		$this->totalGastos = $this->getTotalGastado ();
		$this->totalIVAGastos = $this->getIVACompras ();
		$this->totalVentas = $this->getVentasMes ();
		$this->totalIVAVentas = $this->getIVAVentas ();
		$meses [] = $this;
		return $meses;
	}
	public function getMesLabel() {
		return LGHelper::functions ()->getMonthLabel ( $this->mes );
	}
	public function getIVACompras() {
		if ($this->totalGastos > 0.00) {
			$iva = $this->totalGastos / 1.21 * 0.21;
			return round ( $iva, 2 );
		}
		return 0.00;
	}
	public function getTotalGastado() {
		$total = 0.00;
		if (count ( $this->gastos ) > 0) {
			foreach ( $this->gastos as $gasto ) {
				$total = $total + LGHelper::functions ()->unformatNumber ($gasto->Monto);
			}
		}
		return $total;
	}
	public function getIVAVentas() {
		$ivaA = 0.00;
		$ivaB = 0.00;
		if ($this->totalVentasA > 0.00) {
			// discrimina IVA
			$iva = $this->totalVentasA * 0.21;
			$ivaA = round ( $iva, 2 );
		}
		if ($this->totalVentasB > 0.00) {
			// no discrimina IVA
			$iva = $this->totalVentasB / 1.21 * 0.21;
			$ivaB = round ( $iva, 2 );
		}
		return $ivaA + $ivaB;
	}
	public function getVentasMes() {
		$this->totalVentasA = Cobro::model ()->getTotalCobrosMesAnio ( $this->anio, $this->mes, 1 );
		$this->totalVentasB = Cobro::model ()->getTotalCobrosMesAnio ( $this->anio, $this->mes, 2 );
		$this->totalVentas = $this->totalVentasA + $this->totalVentasB;
		return $this->totalVentas;
	}
	
	public function 	getMediosPago(){
		$tiposComprobantes = MedioPago::model ()->findAll ( array (
				//"condition" => 'visible=1',
				'order' => 'nombre'
		) );
		return CHtml::listData ( $tiposComprobantes, "id_medios_pago", "nombre" );
	}
	
	public function saveMedioPago($id_pago) {
		$exito = false;
		echo $this->id_medio_pago."sss"; 
		if ($this->id_medio_pago==3) { //efectivo
			$efec = new EfectivoPago();
			$efec->id_pago=$id_pago;
			$efec->monto=$this->monto;
			$efec->detalle=$this->detalle;
			$exito =  $efec->save();
			if (!$exito) {
				$this->addErrors($efec->getErrors());
			}
		}
		if ($this->id_medio_pago==2) { //transf banco
			$efec = new TransferenciaPago();
			$efec->id_cuenta_banco = 1;
			$efec->referencia=$this->detalle;
			$efec->cbu_destino=$this->detalle;
			$efec->id_pago=$id_pago;
			$efec->monto=$this->monto;
			$exito = $efec->save();
			if (!$exito) {
				$this->addErrors($efec->getErrors());
			}
		}
		if ($this->id_medio_pago==1) { //cheque
			$che = new Cheque();
			$che->id_cuenta_banco = $this->id_cuenta_banco;
			$che->FechaPago = $this->fecha;
			$che->FechaEmision= $this->fecha;
			$che->a_la_orden= $this->detalle;
			$che->Numero=$this->nro_cheque;
			$che->id_proveedor=$this->id_proveedor;
			$che->Importe=$this->monto;
			$exito = $che->save();
			echo var_dump($che->getErrors());
			if ($exito) {
				$efec = new PagoCheque();
				$efec->id_pago=$id_pago;
				$efec->cheque = $che;
				$efec->id_cheque = $che->id_cheque;
				$exito = $efec->save();
				if (!$exito) {
					$this->addErrors($efec->getErrors());
				}
			} else {
					$this->addErrors($che->getErrors());
			}
		}
		return $exito;
	}
	
	public function searchWithPago($idPago)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id_pago',$idPago);
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}
	
}