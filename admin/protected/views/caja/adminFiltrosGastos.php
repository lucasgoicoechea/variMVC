<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('gasto-grid',{ 
        success: function() {
            $('#gasto-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('gasto/exportar',array('nombreArchivo'=>'gastos-filtrados')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}
</script>
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

<div class="titulo">Facturas/Comprobantes</div>


<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>
<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $model->searchFiltros (),
		'filter' => $model,
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
						'template' => '{view}{update}{imprimirOferta}{verPago}{verPagar}',
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
'verPagar' => array (
										'label' => 'Pagar Comprobante',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/pagar.png",
										'url' => '$data->getUrlPagar()',
										'visible' => '!$data->tienePago()',
										'options' => array (
												'target' => '_blank' 
													)
												),
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
		) 
) );
?>
