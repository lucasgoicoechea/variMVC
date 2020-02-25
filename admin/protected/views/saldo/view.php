<?php
$this->breadcrumbs=array(
	'Saldos'=>array('index'),
	$model->id_cuenta,
);


?>

<h1>Detalle de Saldo #<?php echo $model->id_cuenta; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cuenta.Codigo',
		'SaldoBanco',
		'SaldoEfectivo',
		'Fecha',
		'Hora',
		'id_saldos',
	),
)); ?>


