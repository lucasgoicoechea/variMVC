<div class="titulo">Movimientos Diarios</div>
<div id="time">
<?php 
                 
echo $this->renderPartial ( '_movsDiarios', array (
		'model' => $model,
		'errorFechaCaja' => $errorFechaCaja,
		'facturasPendientes' => $facturasPendientes
) );
?>
</div>