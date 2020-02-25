<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('porcentage_rectorado')); ?>:</b>
	<?php echo CHtml::encode($data->porcentage_rectorado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('porcentage_facultad')); ?>:</b>
	<?php echo CHtml::encode($data->porcentage_facultad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_pago')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_pago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_conv_individual')); ?>:</b>
	<?php echo CHtml::encode($data->id_conv_individual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pagado')); ?>:</b>
	<?php echo CHtml::encode($data->pagado); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_forma_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_forma_pago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asignacion')); ?>:</b>
	<?php echo CHtml::encode($data->asignacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mes_periodo')); ?>:</b>
	<?php echo CHtml::encode($data->mes_periodo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ano_periodo')); ?>:</b>
	<?php echo CHtml::encode($data->ano_periodo); ?>
	<br />

	*/ ?>

</div>
