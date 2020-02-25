<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_ingreso')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_ingreso), array('view', 'id'=>$data->id_ingreso)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php echo CHtml::encode($data->Codigo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

</div></div>
</div>
