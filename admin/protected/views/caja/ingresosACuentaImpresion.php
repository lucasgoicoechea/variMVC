<?php
$model = new IngresoCuenta ();
// $model->pagada = $pagados?1:0;
$model->fecha = $caja->fecha;
// $model->Indice = null;
$model->importe = null;

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'ingreso-cuenta-grid',
		'dataProvider' => $model->search (),
		//'filter' => $model,
		'enableSorting'=>false,
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
		) 
) );
?>