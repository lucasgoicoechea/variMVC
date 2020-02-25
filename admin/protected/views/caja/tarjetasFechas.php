<div class="view">
	<div class="form">
<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List TarjetaPago' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
				'url' => array (
						'create' 
				) 
		) 
);

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('tarjeta-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<?php

$tarjeta = new TarjetaPago ();
$desde = $caja->fechaDesde !== null ? LGHelper::functions ()->undisplayFecha ( $caja->fechaDesde ) : null;
$hasta = $caja->fechaHasta !== null ? LGHelper::functions ()->undisplayFecha ( $caja->fechaHasta ) : null;
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
					array (
							'htmlOptions' => array (
									'width' => '20px' 
							),
							'header' => ' ',
							'template' => '{view}{update}',
							'class' => 'CButtonColumn' 
					) 
			) 
	) );
} else
	echo "NO TIENE MOVIMIENTOS DE TARJETAS";
?>
</div>
</div>
