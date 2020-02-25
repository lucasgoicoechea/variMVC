<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php echo CHtml::encode($data->Codigo); ?>
	<br />
	</div><div class='contenedor-columna'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
		</div>
		<div class='contenedor-columna-10'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('cerrada')); ?>:</b>
	<?php echo CHtml::encode($data->cerrada?'SI':'NO'); ?>
	<br />
	</div>
	</div>
</div>
