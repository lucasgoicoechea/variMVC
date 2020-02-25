<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_banco')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_cuenta_banco), array('view', 'id'=>$data->id_cuenta_banco)); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('numero_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->numero_cuenta); ?>
	<br />

		</div>
	</div>
</div>
