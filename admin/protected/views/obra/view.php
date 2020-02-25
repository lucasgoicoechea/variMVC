<?php
$this->breadcrumbs=array(
	'Obras'=>array('index'),
	$model->id_obra,
);


?>

<div class="titulo">Detalle de Obra Registrada</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_obra',
		'Codigo',
		'Nombre',
		'Direccion',
		'Localidad',
		//'tipoObra.codigo',
		'Monto',
		'FechaInicio',
		'FechaFin',
		'Justiprecio',
		//'Avance',
		'Detalles',
			array (
					'label' => 'Cliente',
					'type' => 'raw',
					'value' => $model->cliente->nombre
			),
		
	),
)); ?>
<div class="row-center">
	<?php
	echo CHtml::link('Volver', $this->createUrl('obra/admin'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	
	?>
</div>
