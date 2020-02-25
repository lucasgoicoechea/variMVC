<?php
$this->breadcrumbs=array(
	'Ingresos'=>array('index'),
	$model->id_ingreso,
);


?>

<h1>Detalle de Ingreso #<?php echo $model->id_ingreso; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_ingreso',
		'Codigo',
		'Nombre',
	),
)); ?>


