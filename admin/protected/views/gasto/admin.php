<?php
Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('gasto-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Facturas/Comprobantes</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
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
						),
						array (
						'htmlOptions' => array (
								'width' => '20px' 
								),
						'header' => ' ',
						'template' => '{view}{update}{delete}{imprimirOferta}{verPago}',
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
										'visible' => '$data->tienePago()',
										//'visible' => '$data->isPagada()||$data->en_orden_pago',
										'options' => array (
												'target' => '_blank' 
												)
												)
																
												)
												)
												)
												) );
												?>
