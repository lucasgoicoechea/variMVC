<div class="titulo">Facturas/Comprobantes</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $model->searchFiltrosSinPaginar (),
		'enableSorting'=>false,
		//'filter' => $model,
		'columns' => array (
				array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				array (
						'name' => 'FechaAsiento',
						'value' => 'LGHelper::functions()->displayFecha($data->FechaAsiento)' 
				),
				'NumComprobante',
				array (
						'name' => 'FechaFactura',
						'value' => 'LGHelper::functions()->displayFecha($data->FechaFactura)' 
				),
				'Monto',
				array (
						'header' => 'Proveedor(Telefono)',
						'name' => 'id_proveedor',
						'value' => '$data->getProveedorDescripcion()',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_proveedor', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra!=null?$data->obra->getDescripcion():""',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				array (
						'name' => 'id_tipo_comprobante',
						'value' => '$data->tipoComprobante->Nombre',
						'filter' => CHtml::listData ( TipoComprobante::model ()->findAll ( array (
								"condition"=>'visible=1',
								'order' => 'orden' 
						) ), 'id_tipo_comprobante', 'Nombre' ) 
				),
				'Detalle',
				)
) );
?>
