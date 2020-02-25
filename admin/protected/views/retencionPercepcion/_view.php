<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_retencion_percepcion')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_retencion_percepcion), array('view', 'id'=>$data->id_retencion_percepcion)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('es_porcentaje')); ?>:</b>
	<?php echo CHtml::encode($data->es_porcentaje); ?>
	<br />

</div></div>
</div>
