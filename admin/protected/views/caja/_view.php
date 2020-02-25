<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_caja')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_caja), array('view', 'id'=>$data->id_caja)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cerrada')); ?>:</b>
	<?php echo CHtml::encode($data->cerrada); ?>
	<br />


</div>
