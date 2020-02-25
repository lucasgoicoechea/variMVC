<?php
$this->breadcrumbs=array(
	'Mes Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MesPago', 'url'=>array('index')),
	array('label'=>'Create MesPago', 'url'=>array('create')),
	array('label'=>'Update MesPago', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MesPago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MesPago', 'url'=>array('admin')),
);
?>

<h1>View MesPago #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'porcentage_rectorado',
		'porcentage_facultad',
		'fecha_pago',
		'numero',
		'id_conv_individual',
		'pagado',
		'id_forma_pago',
		'asignacion',
		'mes_periodo',
		'ano_periodo',
	),
)); ?>


