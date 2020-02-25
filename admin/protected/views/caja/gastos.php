<?php
$model = new Gasto ();
$model->pagada = $pagados ? 1 : 0;
$model->FechaAsiento = $caja->fecha;
$model->NumComprobante = null;

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
<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '/gasto/_search', array (
		'model' => $model 
) );
?>
</div>

<?php
if (isset ( $enOP )) {
	$model->en_orden_pago = $enOP;
	$dataPP = $model->searchConOP ();
} else
	$dataPP = $model->search ();
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $dataPP,
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
								"condition" => 'visible=1',
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
						'template' => '{editarComprobante}{verComprobante}{imprimirOferta}{verPago}',
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
								'editarComprobante' => array (
										'label' => 'Editar Factura/Comprobante',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/update.png",
										'url' => '$data->getEditarGasto()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
										) 
								),
								'verComprobante' => array (
										'label' => 'Ver Factura/Comprobante',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/view.png",
										'url' => '$data->getVerGasto()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
										) 
								),
								'verPago' => array (
										'label' => 'Ver Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
										'url' => '$data->getUrlPago()',
										'visible' => '$data->tienePago()',
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						)
						 
				) 
		) 
) );
?>
