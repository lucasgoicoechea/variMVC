<div class="view">
	<div class="form">
<?php     

$this->menu=array(
		array('label'=>Yii::t('app',
				'List TarjetaPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
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
			");
		?>
<div class="titulo"> Pagos con Tarjeta</div>

<?php $tarjeta = new TarjetaPago();
$fecha = $caja->fecha;
//$dataProv = $tarjeta->searchByFecha($fecha);
$dataProv = $tarjeta->searchByCajaID($caja->id_caja);
if ($dataProv!=null){
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tarjeta-pago-grid',
	'dataProvider'=>$dataProv,
	'filter'=>$tarjeta,
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
		array (
		'htmlOptions' => array (
				'width' => '20px'
		),
		'header' => ' ',
		'template' => '{view}{update}',
		'class' => 'CButtonColumn',
	)
))); }
else echo "NO TIENE MOVIMIENTOS DE TARJETAS";
?>
</div>
</div>
