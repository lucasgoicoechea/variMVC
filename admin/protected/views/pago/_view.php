<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
</div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor->descripcion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->cuenta->descripcion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('pagado')); ?>:</b>
	<?php echo $data->pagado?'Si':'No'; ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_cobro')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_cobro); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_emision')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_emision); ?>
	<br />

</div></div>
</div>
