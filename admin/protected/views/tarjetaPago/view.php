<?php
$this->breadcrumbs=array(
	'Tarjeta Pagos'=>array('index'),
	$model->id_tarjeta_pago,
);


?>

<div class="titulo">Detalle de TarjetaPago Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_tarjeta_pago',
		'id_pago',
		'monto',
		'fecha_pago',
		'id_tarjeta',
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

