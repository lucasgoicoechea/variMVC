<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_quincenal')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_quincenal), array('view', 'id'=>$data->id_quincenal)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anio')); ?>:</b>
	<?php echo CHtml::encode($data->anio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mes')); ?>:</b>
	<?php echo CHtml::encode($data->mes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quincena')); ?>:</b>
	<?php echo CHtml::encode($data->quincena); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />


</div>
