<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tarjeta')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_tarjeta), array('view', 'id'=>$data->id_tarjeta)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('titular')); ?>:</b>
	<?php echo CHtml::encode($data->titular); ?>
	<br />

</div></div>
</div>
