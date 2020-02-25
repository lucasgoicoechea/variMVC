<?php

$acumulados = [];
$acumulados = CuentaSaldosAcumulado::getAcumCajaIDCuentasActivas($id_caja);
if (sizeof($acumulados)==0){
	echo "<b>NO HAY SALDOS CALCULADOS PARA LA CAJA DEL DÍA</b>";
} 
 else {
	$this->renderPartial ( '_acumuladoHeaders', array (
	) );
	foreach ($acumulados as $cuentaSaldosAcum){
		$this->renderPartial ( '_acumulado', array (
				'data' => $cuentaSaldosAcum 
		) );
	}
	
}
?>