<style>
.resaltarCuentas {
background: #FFDDDD;
}
.textoSaldos {
	font-size: 9px;
	border-left: solid 1px;
	padding-left: 2px;
	float: left;
}

.contenedor-columna-7 {
	display: block;
	float: left;
	width: 7%;
}
</style>
<div class="contenedor-fila"
	style="border: solid 1px; margin-left: 0px; width: 99%; font-size: 7px">
	<div class="contenedor-columna-7">
		<span class="textoSaldos resaltarCuentas">
	<?php echo CHtml::encode($data->cuenta->getDescripcion()); ?>
	</span>
	</div>
	<div class="contenedor-columna-7">
		<span class="textoSaldos">
	<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_inicio)); ?>
	</span>
	</div>

	<div class="contenedor-columna-7">
		<span class="textoSaldos">
	<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_gastos)); ?>
	</span>
	</div>

	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_gastos_pendientes)); ?>
	</span>
	</div>

	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_transferencias_pago)); ?>
	</span>
	</div>

	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_cheques)); ?>
	</span>
	</div>

	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_pago_efectivo)); ?>
	</span>
	</div>
	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_tarjetas)); ?>
	</span>
	</div>

	<div class="contenedor-columna-7">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_retiro_capital)); ?>
	</span>
	</div>
	<div class="contenedor-columna-7">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_cobros)); ?>
	</span>
	</div>


	<div class="contenedor-columna-7">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_transferencias)); ?>
	</span>
	</div>

	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_ingresos_cuenta)); ?>
	</span>
	</div>
	<div class="contenedor-columna-5">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_contra_asientos)); ?>
	</span>
	</div>

	<div class="contenedor-columna-7">
		<span class="textoSaldos">
		<?php echo LGHelper::functions()->formatNumber(CHtml::encode($data->saldo_diario)); ?>
	</span>
	</div>
</div>
