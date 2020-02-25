<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_presupuesto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_presupuesto), array('view', 'id'=>$data->id_presupuesto)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('NumeroOrden')); ?>:</b>
	<?php echo CHtml::encode($data->NumeroOrden); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Obra')); ?>:</b>
	<?php echo CHtml::encode($data->Obra); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->id_proveedor); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Detalle')); ?>:</b>
	<?php echo CHtml::encode($data->Detalle); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_material')); ?>:</b>
	<?php echo CHtml::encode($data->id_material); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_atencion_venta')); ?>:</b>
	<?php echo CHtml::encode($data->id_atencion_venta); ?>
	<br />

</div></div>	*/ ?>

</div>
