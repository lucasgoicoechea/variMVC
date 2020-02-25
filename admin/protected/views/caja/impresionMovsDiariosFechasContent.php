<?php  if ($model!== null){?>

<div class="form">
	<div class="contenedor-tabla">
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Gastos Diarios Pagados</th>
			</tr>
		</thead>
	</table>
	
<?php
$gasto = new Gasto();
$gasto->fechaDesde = $model->fechaDesde;
$gasto->fechaHasta = $model->fechaHasta;
$gasto->id_obra = $model->id_obra;
echo $this->renderPartial ( 'adminFiltrosGastosFechas', array (
		'model' => $gasto, 
), true );

?>
</div>
<?php

echo $this->renderPartial ( 'saldosGastosPorCuentaFechas', array (
		'model' => $model
), true );

?>
	
<?php
echo $this->renderPartial ( 'transferenciasCuentasFechas', array (
		'model' => $model
), true )?>


<div class="contenedor-tabla">

<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Cheques Emitidos</th>
			</tr>
		</thead>
	</table>
<?php

echo $this->renderPartial ( 'chequesEmitidosFechasImpresion', array (
		'caja' => $model 
), true )?>
	</div>
	<div class="contenedor-tabla">
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Transferencias Banco</th>
			</tr>
		</thead>
	</table>
<?php

echo $this->renderPartial ( 'transferenciaBancoFechasImpresion', array (
		'caja' => $model
), true );
 ?>
</div>	
<div class="contenedor-tabla">
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Pagos con Tarjeta</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'tarjetasFechasImpresion', array (
			'caja' => $model 
	), true )?>

</div>

				<div class="contenedor-tabla">
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Cobros</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'cobrosFechasImpresion', array (
			'caja' => $model 
	), true )?>

</div>
<div class="contenedor-tabla">
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Ingresos a Cuenta</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'ingresosACuentaFechasImpresion', array (
			'caja' => $model 
	), true )?>
	

</div>



</div>
<?php } ?>
</div>
<?php ?>