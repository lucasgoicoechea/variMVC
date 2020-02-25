<div class="view">
	<div class="form">
<?php $tarjeta = new TarjetaPago();
$fecha = $caja->fecha;
$dataProv = $tarjeta->searchByFecha($fecha);
if ($dataProv!=null){
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tarjeta-pago-grid',
	'dataProvider'=>$dataProv,
	//'filter'=>$tarjeta,
	'columns'=>array(
				array (
						'name' => 'id_tarjeta',
						'value' => '$data->tarjeta->descripcion',
						'filter' => CHtml::listData ( Tarjeta::model ()->findAll ( array (
								'order' => 'numero' 
						) ), 'id_tarjeta', 'descripcion' ) 
				),
		'monto',
		'fecha_pago',
		'detalle',
))); }
else echo "NO TIENE MOVIMIENTOS DE TARJETAS";
?>
</div>
</div>
