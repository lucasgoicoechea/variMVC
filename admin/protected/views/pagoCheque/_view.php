<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pago_cheque')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_pago_cheque), array('view', 'id'=>$data->id_pago_cheque)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_pago); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cheque')); ?>:</b>
	<?php echo CHtml::encode($data->id_cheque); ?>
	<br />

</div></div>
</div>
