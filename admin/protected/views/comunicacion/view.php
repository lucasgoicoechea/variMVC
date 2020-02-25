<?php
$this->breadcrumbs=array(
	'Comunicacions'=>array('index'),
	$model->id_comunicacion,
);

$this->menu=array(
	array('label'=>'List Comunicacion', 'url'=>array('index')),
	array('label'=>'Create Comunicacion', 'url'=>array('create')),
	array('label'=>'Update Comunicacion', 'url'=>array('update', 'id'=>$model->id_comunicacion)),
	array('label'=>'Delete Comunicacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_comunicacion),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Comunicacion', 'url'=>array('admin')),
);
?>

<h1>View Comunicacion #<?php echo $model->id_comunicacion; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_comunicacion',
		'mensaje',
		'id_userslogin_origen',
		'id_userslogin_destino',
		'leido',
	),
)); ?>


