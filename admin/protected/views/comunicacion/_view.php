<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_comunicacion')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_comunicacion), array('view', 'id'=>$data->id_comunicacion)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mensaje')); ?>:</b>
	<?php echo CHtml::encode($data->mensaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_userslogin_origen')); ?>:</b>
	<?php echo CHtml::encode($data->id_userslogin_origen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_userslogin_destino')); ?>:</b>
	<?php echo CHtml::encode($data->id_userslogin_destino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leido')); ?>:</b>
	<?php echo CHtml::encode($data->leido); ?>
	<br />


</div>
