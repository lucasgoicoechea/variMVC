<?php

/*echo CHtml::button ( 'Volver', array (
	'name' => 'btnBack',
	'onclick' => 'js:history.go(-1);returnFalse;',
	'class' => 'btn btn-primary' 
) );
=array(
	array('label'=>'Cargar Liquidación', 'url'=>array('create')),
	array('label'=>'Modificar Quincena', 'url'=>array('update', 'id'=>$model->id_quincena)),
	array('label'=>'Ver Quincenas anteriores', 'url'=>array('admin')),
);*/
?>
<div class="titulo">Liquidación Quincena </div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array (
			'name' => 'Indice',
			'value' => $model->id_quincena
	),
	'nro_secuencia_quincena',
	array (
		'name' => 'Personal',
		'value' => $model->personal->getDescripcion()
	),
array (
	'name' => 'Obra',
	'value' => $model->obra->getDescripcion()
),
'Quincena',
		'horas',
		'horas_extras',
		'dias_trabajados',
		'efectivo',
		'adelantos',
		'extras',
		'viaticos',
		'movilidad',
		'subtotal',
		'descuentos_adelantos',
		'Final',
		'Fecha'
	),
)); ?>



<div class="row-center">
	<?php
	echo CHtml::link('Volver', $this->createUrl('personal/admin'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	
	?>
</div>

