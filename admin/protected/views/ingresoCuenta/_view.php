<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_ingreso_cuenta')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_ingreso_cuenta), array('view', 'id'=>$data->id_ingreso_cuenta)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_forma_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_forma_pago); ?>
	<br />

</div></div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

</div></div>
</div>
