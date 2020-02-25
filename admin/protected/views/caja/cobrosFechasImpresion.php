<?php
$model = new Cobro();
//$model->pagada = $pagados?1:0;
$model->fechaDesde = $caja->fechaDesde;
$model->fechaHasta = $caja->fechaHasta;
$model->id_obra = $caja->id_obra;


?>

<?php 
$model->Indice = null;
$model->Importe = null;
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'cobro-grid',
		'dataProvider' => $model->searchFiltros(),
		//'filter' => $model,
		'enableSorting'=>false,
		'columns' => array (
				// 'id_cobro',
				array (
						'name' => 'Indice',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				array (
						'name' => 'Fecha',
						),
				'NumFactura',
				'Importe',
				array (
						'name' => 'id_cliente',
						'value' => '$data->cliente->nombre',
						
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra->Nombre',
						
				),
				array (
						'name' => 'id_imputacion',
						'value' => '$data->imputacion->Nombre',
						
				),
				array (
						'name' => 'id_forma',
						'value' => '$data->formaPago->Nombre',
						
				),
				array (
						'header' => 'Fecha Cobro',
						'value' => 'LGHelper::functions()->displayFecha ( $data->FechaCobro )' 
				),
		
		) 
) ); ?>