<?php
$this->breadcrumbs=array(
	'Pago Cheques'=>array('index'),
	$model->id_pago_cheque,
);


?>

<div class="titulo">Detalle de PagoCheque Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array (
			'name' => 'ID_PAGO_CHEQUE',
			'value' => $model->id_pago_cheque
			),
			array (
				'name' => 'Pago',
				'type'=>'raw',
				'value' => CHtml::link ( '<b>Ver Detalle PAgo -> <b> # ' . $model->pago->id_pago . ' ', $model->pago->getUrlVerDetalle(), array (
					'title' => 'Ver Pago',
					'target' => '_blank' 
			) )
		),
		array (
			'name' => 'Pago Detalles',
			'type'=>'raw',
			'value' =>'<b>Proveedor -> <b> # ' . $model->pago->getProveedorDescripcion() . ' -  Monto Pago: $'.$model->pago->getMonto()
		),
		array (
			'name' => 'Cheque',
			'type'=>'raw',
			'value' => CHtml::link ( '<b>Ver Detalle Cheque -> <b> # ' . $model->cheque->id_cheque . ' ', $model->cheque->getUrlVerDetalle(), array (
				'title' => 'Ver Cheque',
				'target' => '_blank' 
		) )	),
array (
	'name' => 'Cheque Detalles',
	'type'=>'raw',
	'value' =>  '<b>Cheque -> <b> # ' . $model->cheque->getDescripcion() . ' -  Monto: $'.$model->cheque->Importe ,
	
	),
))); 
?>
<div class="row-center">
<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?></div>

