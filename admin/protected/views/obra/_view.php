<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_obra), array('view', 'id'=>$data->id_obra)); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php echo CHtml::encode($data->Codigo); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Direccion')); ?>:</b>
	<?php echo CHtml::encode($data->Direccion); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Localidad')); ?>:</b>
	<?php echo CHtml::encode($data->Localidad); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_obra')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_obra); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Monto')); ?>:</b>
	<?php echo CHtml::encode($data->Monto); ?>
	<br />

		</div>
	</div>

</div>
