<?php
$chequePago = $data;
$data = $chequePago->cheque;
$idPago = $chequePago->id_pago;
?>
<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('serie')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->serie), array('cheque/update', 'id'=>$data->id_cheque)); ?>
	
</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Numero')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Numero), array('cheque/update', 'id'=>$data->id_cheque)); ?>
	
</div>

		<div class='contenedor-columna-40'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_banco')); ?>:</b>
	<?php echo CHtml::encode($data->cuentaBanco->descripcion); ?>
	</div>


	</div>

	<div class="contenedor-fila">

		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaEmision')); ?>:</b>
	<?php echo CHtml::encode($data->FechaEmision); ?>
	</div>
		<div class="contenedor-columna-40">
			<b>A la orden:</b><?php echo CHtml::encode($data->a_la_orden); ?>
		</div>
		<div class="contenedor-columna-20">
			<b>Imp. Cheque:</b><?php echo CHtml::encode($data->porc_impuesto_cheque); ?>%
		</div>
		<div class="contenedor-columna-20">
			<b>Imp. Deposito:</b><?php echo CHtml::encode($data->porc_impuesto_debito); ?>%
		</div>
		<div class='contenedor-columna-30 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); text-align: center;">
			<b>
			<?php  if ($data->anulado){?>
				<span style="color: red">ANULADO</SPAN> <label
				style="text-decoration: line-through; color: red"> IMPORTE</label>
			<?php } else {?>
			<label> IMPORTE </label>
			<?php }?>	
			</b> <b>$ <?php echo " ".$data->Importe; ?></b>
		</div>

	</div>

	<div class="contenedor-fila">

		<div class='contenedor-columna-20'>
			<b>Diferido:</b>
			<?php echo $data->id_cheque_dias!=0?$data->chequeDias->descripcion:''; ?>
	</div>
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaPago')); ?>:</b>
	<?php echo CHtml::encode($data->FechaPago); ?>
	</div>
	<?php if (isset($data->id_cheque_reemplaza) && $data->id_cheque_reemplaza!=null  && $data->id_cheque_reemplaza!=0) { ?>
		<div class='contenedor-columna-30'>
			<b>REEMPLAZA AL CHEQUE: </b>
			<?php echo $data->chequeReemplazo->getDescripcion(); ?>
			</div>
	<?php }?>
	</div>

</div>
