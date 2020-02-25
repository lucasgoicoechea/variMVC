<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_orden')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_orden), array('view', 'id'=>$data->id_orden)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('numero_orden')); ?>:</b>
	<?php echo CHtml::encode($data->numero_orden); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::encode($data->id_obra); ?>
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
	<b><?php echo CHtml::encode($data->getAttributeLabel('Atencion')); ?>:</b>
	<?php echo CHtml::encode($data->Atencion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Autorizo')); ?>:</b>
	<?php echo CHtml::encode($data->Autorizo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Solicitado')); ?>:</b>
	<?php echo CHtml::encode($data->Solicitado); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Impresa')); ?>:</b>
	<?php echo CHtml::encode($data->Impresa); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Entrega')); ?>:</b>
	<?php echo CHtml::encode($data->Entrega); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Recibe')); ?>:</b>
	<?php echo CHtml::encode($data->Recibe); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Pagada')); ?>:</b>
	<?php echo CHtml::encode($data->Pagada); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_material')); ?>:</b>
	<?php echo CHtml::encode($data->id_material); ?>
	<br />

</div></div>	*/ ?>

</div>
