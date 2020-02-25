<?php
$this->breadcrumbs=array(
	'Cuenta Bancos'=>array('index'),
	$model->id_cuenta_banco,
);


?>


<div class="titulo">Detalle datos de Cuenta Banco</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_cuenta_banco',
		'codigo',
		'nombre',
		'numero_cuenta',
		//'empresa.nombre',
	),
)); ?>

<div class="row-center">
	<?php
	echo CHtml::link ( 'Volver', $this->createUrl ( 'cuentabanco/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	
	?>
</div>