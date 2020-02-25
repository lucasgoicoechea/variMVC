<?php
$this->breadcrumbs=array(
	'Pagos'=>array('index'),
	$model->id_pago,
);


?>

<div class="titulo">Detalle de Pago Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			array (
					'name' => 'Nro. Pago',
					'value' => $model->numero
			),
			array (
					'name' => 'Proveedor',
					'value' => $model->proveedor->getDescripcion ()
			),
			array (
					'name' => 'Cuenta',
					'value' => $model->cuenta->getDescripcion ()
			),
			array (
					'name' => 'Pagado',
					'value' => $model->pagado?'Si':'No'
			),
		'fecha_cobro',
		'fecha_emision',
	),
)); ?>
<div class="row-center">

    <span>
    <?php 
	echo CHtml::link ( 'Editar Pago', $this->createUrl ( 'pago/update' ,array('id'=>$model->id_pago )), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
    <span>
<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?></span></div>

