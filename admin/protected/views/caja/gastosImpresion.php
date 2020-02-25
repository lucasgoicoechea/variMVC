<?php
$model = new Gasto();
$model->pagada = $pagados?1:0;
$model->FechaAsiento = $caja->fecha;
$model->NumComprobante = null;
?>


<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $model->searchSinPaginar (),
		'enableSorting'=>false,
		//'filter' => $model,
		'columns' => array (
array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '20px' 
								)
								),
				'FechaAsiento',
				'NumComprobante',
				'FechaFactura',
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
				array (
							'htmlOptions' => array (
								'width' => '15px',
								'style' => "text-align:center;"
								),
						'header' => 'En OP',
						'type' => 'raw',
						'value' => '$data->en_orden_pago?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
						),
						array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' )
						),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
								),
						'name' => 'pagada',
						'type' => 'raw',
						'value' => '$data->isPagada()?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
						),))
						
												 );
												?>
