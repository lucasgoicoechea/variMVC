<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_retencion_percepcion_valores')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_retencion_percepcion_valores), array('view', 'id'=>$data->id_retencion_percepcion_valores)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_retencion_percepcion')); ?>:</b>
	<?php echo CHtml::encode($data->id_retencion_percepcion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($data->valor); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_log')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_log); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_log')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_log); ?>
	<br />

</div></div>
</div>
