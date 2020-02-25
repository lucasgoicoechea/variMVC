<?php
$this->breadcrumbs=array(
	'Transferencia Pagos'=>array('index'),
	$model->id_transferencia_pago,
);


?>

<div class="titulo">Detalle de TransferenciaPago Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_transferencia_pago',
		'id_cuenta_banco',
		'referencia',
		'monto',
		'cbu_destino',
		'id_pago',
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

