<?php
$model = new IngresoCuenta ();
// $model->pagada = $pagados?1:0;
$model->fecha = $caja->fecha;

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cheque-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<?php
// $model->Indice = null;
$model->importe = null;

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'ingreso-cuenta-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				// 'id_retirocapital',
				array (
						'header' => 'Fecha',
						'value' => 'LGHelper::functions()->displayFecha ( $data->fecha )' 
				),
				array (
						'name' => 'id_cuenta',
						'value' => '$data->cuenta->descripcion',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
						) ), 'id_cuenta', 'descripcion' ) 
				),
				'importe',
				'descripcion',
				// 'id_forma_pago',
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