<?php
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	$model->id_caja,
);

$this->menu=array(
	array('label'=>'List Caja', 'url'=>array('index')),
	array('label'=>'Create Caja', 'url'=>array('create')),
	array('label'=>'Update Caja', 'url'=>array('update', 'id'=>$model->id_caja)),
	array('label'=>'Delete Caja', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_caja),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Caja', 'url'=>array('admin')),
);
?>

<h1>View Caja #<?php echo $model->id_caja; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_caja',
		'codigo',
		'fecha',
		'numero',
		'importe',
		'id_cuenta',
		'cerrada',
	),
)); ?>


