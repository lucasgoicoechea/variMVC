<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_transferencia_pago')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_transferencia_pago), array('view', 'id'=>$data->id_transferencia_pago)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_banco')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta_banco); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('referencia')); ?>:</b>
	<?php echo CHtml::encode($data->referencia); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('cbu_destino')); ?>:</b>
	<?php echo CHtml::encode($data->cbu_destino); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_pago); ?>
	<br />

</div></div>
</div>
