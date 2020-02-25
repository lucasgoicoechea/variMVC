<?php
$visible_log=UsersLogin::isMiguelAlba ( Yii::app ()->user->id ); 
$dataprovider = $model->searchFiltrosConMedioPagoSinPaginar ();
$sort = new CSort();
/*$sort->attributes = array(
		'FechaFactura'=>array(
				'desc'=>'FechaFactura ASC',
		),
);*/
$dataProvider->sort = $sort;
$dataProvider->sort->defaultOrder='Codigo DESC';
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $dataprovider,
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
				array(
						'name'=>'Monto',
						//'type'=>'text',
						//'footer'=>$model->getTotals($model->search()->getKeys()),
				),
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
				array (
						'header' => 'Cuenta',
						'value' => '$data->getPago()->cuenta!=null?$data->getPago()->cuenta->descripcion:""',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo'
						) ), 'id_cuenta', 'descripcion' ),
						'htmlOptions' => array (
								'width' => '100px',
								'style' => "text-align:center;"
						)
				),
				'Detalle',
				array (
						'header' => 'IVA',
						'type' => 'raw',
						'value' => '$data->getIVACalculado()'
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
										'url' => '$data->getUrlImprimir()',
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
										'url' => '$data->getUrlPagoEditar()',
										// 'visible' => '$data->tienePago()',
										'visible' => '$data->isPagada()||$data->en_orden_pago',
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
$datObj = $dataprovider->getData(true);
$model->calcularTotales($datObj);
$this->renderPartial ( '_footerSaldos', array (
		'model' => $model 
) );

?>