<?php
$this->breadcrumbs=array(
	'Recibos'=>array('index'),
	$model->id_recibo,
);


?>

<h1>Detalle de Recibo #<?php echo $model->id_recibo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'contrato.Fecha',
		'fecha',
		'Importe',
		'Detalle',
		'proveedor.Nombre',
		'obra.Codigo',
		'id_recibo',
				'impreso',
	),
)); ?>


