<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_gasto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_gasto), array('view', 'id'=>$data->id_gasto)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php echo CHtml::encode($data->Codigo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaAsiento')); ?>:</b>
	<?php echo CHtml::encode($data->FechaAsiento); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::encode($data->id_obra); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->id_proveedor); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_comprobante')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_comprobante); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('NumComprobante')); ?>:</b>
	<?php echo CHtml::encode($data->NumComprobante); ?>
	<br />

</div></div>

</div>
