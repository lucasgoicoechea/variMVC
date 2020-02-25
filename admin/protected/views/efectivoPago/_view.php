<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_efectivo_pago')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_efectivo_pago), array('view', 'id'=>$data->id_efectivo_pago)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pago')); ?>:</b>
	<?php echo CHtml::encode($data->id_pago); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('detalle')); ?>:</b>
	<?php echo CHtml::encode($data->detalle); ?>
	<br />

</div></div>
</div>
