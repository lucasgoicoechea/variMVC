<?php
$visible_log=UsersLogin::isMiguelAlba ( Yii::app ()->user->id ); 

$dataprovider = $gastoitem->searchGastoItemsSinPaginar ($model);
$sort = new CSort();
/*$sort->attributes = array(
		'FechaFactura'=>array(
				'desc'=>'FechaFactura ASC',
		),
);*/
$dataProvider->sort = $sort;
$dataProvider->sort->defaultOrder='id_material';
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $dataprovider,
		//'filter' => $model,
		'columns' => array (
				array (
						'name' => 'id_gasto_item',
						'htmlOptions' => array (
								'width' => '20px'
						)
				),array (
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
			),array (
				'name' => 'material',
				'value' => '$data->material!=null?$data->material->getDescripcionShort():""',
				'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
						'order' => 'Nombre'
				) ), 'id_material', 'descripcion' )
		),
				'cantidad',
				'valor_unidad',
				'valor_final',
				'consumido',
				
				array (
					'name' => 'FechaAsiento',
					'value' => 'LGHelper::functions()->displayFecha($data->gasto->FechaAsiento)'
			),
			array (
				'name' => 'Comprobante',
				'value' => '$data->gasto->NumComprobante'
		),
			array (
					'name' => 'FechaFactura',
					'value' => 'LGHelper::functions()->displayFecha($data->gasto->FechaFactura)'
			),
				array (
						'name' => 'id_tipo_comprobante',
						'value' => '$data->gasto->tipoComprobante->Nombre',
						'filter' => CHtml::listData ( TipoComprobante::model ()->findAll ( array (
								"condition"=>'visible=1',
								'order' => 'orden'
						) ), 'id_tipo_comprobante', 'Nombre' )
				),
				array (
						'header' => 'Cuenta',
						'value' => '$data->gasto->getPago()->cuenta!=null?$data->gasto->getPago()->cuenta->descripcion:""',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo'
						) ), 'id_cuenta', 'descripcion' ),
						'htmlOptions' => array (
								'width' => '100px',
								'style' => "text-align:center;"
						)
				),
				array (
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
						),
						'name' => 'Usuario',
						'type' => 'raw',
						'visible' => $visible_log,
						'value' => '$data->usuario_log'
				),
				array (
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
						),
						'name' => 'Reg',
						'type' => 'raw',
						'visible' => $visible_log,
						'value' => '$data->fecha_log'
				),
				array (
						'htmlOptions' => array (
								'width' => '20px'
						),
						'header' => ' ',
						'template' => '{view}{update}{imprimirOferta}{verPago}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'imprimirOferta' => array (
										'label' => 'Imprimir Factura/Comprobante',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
										'url' => '$data->gasto->getUrlImprimir()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank'
										)
								),
								/*'verOrdenPago' => array (
								 'label' => 'Ver Orden de Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/file.gif",
										'url' => '$data->getUrlOP()',
										'visible' => '$data->isPagada()||$data->en_orden_pago',
										'options' => array (
												'target' => '_blank'
										)
								),*/
								'verPago' => array (
										'label' => 'Ver Orden de Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
										'url' => '$data->gasto->getUrlPagoEditar()',
										// 'visible' => '$data->tienePago()',
										'visible' => '$data->gasto->isPagada()||$data->gasto->en_orden_pago',
										'options' => array (
												'target' => '_blank'
										)
								)
						)
							
				)
		),

		'htmlOptions'=>array(
				'style'=>'overflow-y:scroll;height:400px;'),
) );
?>
<div class="titulo">SALDOS</div>
<?php 
/*$datObj = $dataprovider->getData(true);
$model->calcularTotales($datObj);
$this->renderPartial ( '_footerSaldos', array (
		'model' => $model 
) );*/

?>