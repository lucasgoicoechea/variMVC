<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('clave')); ?>:</b>
	<?php echo CHtml::encode($data->clave); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('apellido')); ?>:</b>
	<?php echo CHtml::encode($data->apellido); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('idTipo')); ?>:</b>
	<?php echo CHtml::encode($data->idTipo); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('verEntrevista')); ?>:</b>
	<?php echo CHtml::encode($data->verEntrevista); ?>
	<br />

	<?php 
/*
	       * <b><?php echo CHtml::encode($data->getAttributeLabel('id_userslogin')); ?>:</b> <?php echo CHtml::encode($data->id_userslogin); ?> <br />
	       */
	?>

</div>
