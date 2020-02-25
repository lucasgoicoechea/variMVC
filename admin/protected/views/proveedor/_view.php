<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_proveedor), array('view', 'id'=>$data->id_proveedor)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Telefono')); ?>:</b>
	<?php echo CHtml::encode($data->Telefono); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Celular')); ?>:</b>
	<?php echo CHtml::encode($data->Celular); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Fax')); ?>:</b>
	<?php echo CHtml::encode($data->Fax); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Direccion')); ?>:</b>
	<?php echo CHtml::encode($data->Direccion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Contacto')); ?>:</b>
	<?php echo CHtml::encode($data->Contacto); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Cuit')); ?>:</b>
	<?php echo CHtml::encode($data->Cuit); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('E_Mail')); ?>:</b>
	<?php echo CHtml::encode($data->E_Mail); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('SubTipo')); ?>:</b>
	<?php echo CHtml::encode($data->SubTipo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_gasto')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_gasto); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_categoria_iva')); ?>:</b>
	<?php echo CHtml::encode($data->id_categoria_iva); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_moneda')); ?>:</b>
	<?php echo CHtml::encode($data->id_moneda); ?>
	<br />

</div></div>	*/ ?>

</div>
