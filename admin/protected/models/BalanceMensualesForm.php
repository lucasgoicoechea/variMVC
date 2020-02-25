<?php
class BalanceMensualesForm extends CFormModel {
	public $anio = 2016;
	public $mes = null; // enero = 1 , todos = null
	public $gastos = null; // array de Gasto
	public $totalVentasA = 0.00;
	public $totalVentasB = 0.00;
	public $totalVentas = 0.00;
	public $totalGastos = 0.00;
	public $totalIVAVentas = 0.00;
	public $totalIVAGastos = 0.00;
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
}