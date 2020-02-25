<div class="view">
	<div class="form">
<?php

?>

<?php

$tarjeta = new TarjetaPago ();
$desde = $caja->fechaDesde != null ? LGHelper::functions ()->undisplayFecha ( $caja->fechaDesde ) : null;
$hasta = $caja->fechaHasta != null ? LGHelper::functions ()->undisplayFecha ( $caja->fechaHasta ) : null;
$dataProv = $tarjeta->searchByFechas ( $desde, $hasta );
if ($dataProv != null) {
	$this->widget ( 'zii.widgets.grid.CGridView', array (
			'id' => 'tarjeta-pago-grid',
			'dataProvider' => $dataProv,
			// 'filter'=>$tarjeta,
			'columns' => array (
					array (
							'header' => 'Tarjeta',
							'value' => '$data->tarjeta->descripcion' 
					),
					'monto',
					'fecha_pago',
					'detalle',
					
			) 
	) );
} else
	echo "NO TIENE MOVIMIENTOS DE TARJETAS";
?>
</div>
</div>
