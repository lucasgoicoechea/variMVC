<?php

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('transferencia-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<?php $transferencia = new TransferenciaPago();
$desde = $caja->fechaDesde!=null?LGHelper::functions()->undisplayFecha($caja->fechaDesde):null;
$hasta = $caja->fechaHasta!=null?LGHelper::functions()->undisplayFecha($caja->fechaHasta):null;
$dataProv = $transferencia->searchByEntreFechaSinPaginar ( $desde, $hasta );
if ($dataProv!=null){
 $this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'transferencia-pago-grid',
		'dataProvider' => $dataProv,
		//'filter' => $transferencia,
 		'enableSorting'=>false,
		'columns' => array (
				array (
						'name' => 'Cuenta Banco	',
						'value' => '$data->cuentaBanco->descripcion',
				),
				'referencia',
				'cbu_destino',
				'monto',array (
						//'name' => 'Fecha',
						'value' => '$data->fecha_cobro',
				), 
		)
)); }
 else  echo "NO TIENE TRANSFERENCIAS";
		?>