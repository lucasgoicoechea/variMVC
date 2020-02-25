<?php
$model = new BajaMedioPago ();
// $model->pagada = $pagados?1:0;
$model->caja_id = $caja->id_caja;

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('contra-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<?php
// $model->Indice = null;
//$model->monto = null;

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'contra-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				// 'id_retirocapital',
				array (
						'header' => 'Fecha',
						//'value' => 'LGHelper::functions()->displayFecha ( $data->fecha_log )'
						'value' =>  '$data->fecha_log' 
				),
				array (
						'name' => 'id_cuenta',
						'header' => 'Cuenta',
						'value' => '$data->cuenta->descripcion',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
						) ), 'id_cuenta', 'descripcion' ) 
				),
				'monto',
				'tipo_medio_pago',
				'observacion',
				// 'id_gasto',
				/*
				 *
				 */
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>