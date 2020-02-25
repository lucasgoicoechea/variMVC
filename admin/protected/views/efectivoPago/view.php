<?php
$this->breadcrumbs=array(
	'Efectivo Pagos'=>array('index'),
	$model->id_efectivo_pago,
);


?>

<div class="titulo">Detalle de EfectivoPago Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_efectivo_pago',
		'id_pago',
		'monto',
		'detalle',
	),
)); ?>
<div class="row-center">
<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?></div>

