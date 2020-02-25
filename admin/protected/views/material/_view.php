<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

<div class="contenedor-fila"><div class='contenedor-columna-30'>  	<b><?php echo CHtml::encode($data->getAttributeLabel('id_material')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_material), array('view', 'id'=>$data->id_material)); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php echo CHtml::encode($data->Codigo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Costo')); ?>:</b>
	<?php echo CHtml::encode($data->Costo); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_rubro')); ?>:</b>
	<?php echo CHtml::encode($data->id_rubro); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('id_subrubro')); ?>:</b>
	<?php echo CHtml::encode($data->id_subrubro); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->Observaciones); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Medida')); ?>:</b>
	<?php echo CHtml::encode($data->Medida); ?>
	<br />

</div></div><div class="contenedor-fila"><div class='contenedor-columna-30'>	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

</div></div>	*/ ?>

</div>
