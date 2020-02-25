
<?php
$transferencias = Transferencia::model()->getByFechaForCaja($model->fecha);
if (sizeof($transferencias)==0){
	echo "<b>NO HAY TRANSFERENCIAS ENTRE CUENTAS PARA LA CAJA DEL DÍA</b>";
} 
else {
	$this->renderPartial ( '_transferenciaHeaders', array (
	) );
	foreach ($transferencias as $transf){
		$this->renderPartial ( '_transferencia', array (
				'data' => $transf 
		) );
	}
}
?>