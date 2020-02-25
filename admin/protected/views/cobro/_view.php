<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cobro')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_cobro), array('view', 'id'=>$data->id_cobro)); ?>
	<br />

		</div>
	</div>
	
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::encode($data->id_obra); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_imputacion')); ?>:</b>
	<?php echo CHtml::encode($data->id_imputacion); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_forma')); ?>:</b>
	<?php echo CHtml::encode($data->id_forma); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Importe')); ?>:</b>
	<?php echo CHtml::encode($data->Importe); ?>
	<br />

		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cheque')); ?>:</b>
	<?php echo CHtml::encode($data->id_cheque); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaCobro')); ?>:</b>
	<?php echo CHtml::encode($data->FechaCobro); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('NumFactura')); ?>:</b>
	<?php echo CHtml::encode($data->NumFactura); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Detalles')); ?>:</b>
	<?php echo CHtml::encode($data->Detalles); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('asentado')); ?>:</b>
	<?php echo CHtml::encode($data->asentado); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta); ?>
	<br />

</div></div>	*/ ?>

</div>