<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_transferencia')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_transferencia), array('view', 'id'=>$data->id_transferencia)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_origen')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta_origen); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_destino')); ?>:</b>
	<?php echo CHtml::encode($data->id_cuenta_destino); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

</div></div>
</div>
