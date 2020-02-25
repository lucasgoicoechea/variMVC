<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_gasto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_tipo_gasto), array('view', 'id'=>$data->id_tipo_gasto)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_log')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_log); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_log')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_log); ?>
	<br />


</div>
