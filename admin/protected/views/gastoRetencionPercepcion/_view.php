<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_gasto_retencion_percepcion')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_gasto_retencion_percepcion), array('view', 'id'=>$data->id_gasto_retencion_percepcion)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_gasto')); ?>:</b>
	<?php echo CHtml::encode($data->id_gasto); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_retencion_percepcion')); ?>:</b>
	<?php echo CHtml::encode($data->id_retencion_percepcion); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($data->valor); ?>
	<br />

</div></div>
</div>
