<?php

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cobro-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>
<?php

?>
<div class="titulo">Informe - Ventas</div>
<div class="search-form" >
<?php

$this->renderPartial ( '_searchFiltrosInforme', array (
		'model' => $model 
) );
?>
</div>

<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('cobro-grid',{ 
        success: function() {
            $('#cobro-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('cobro/exportar',array('nombreArchivo'=>'ventas-Vari')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}
function exportarXLS(){
	$('#descargar-xls').attr("disabled",true).html("Generando XLS...");
	 $.fn.yiiGridView.update('cobro-grid',{ 
       success: function() {
           $('#cobro-grid').removeClass('grid-view-loading');
           window.location = '<?php echo CController::createUrl('cobro/exportarXLS',array('nombreArchivo'=>'ventas-Vari')); ?>'+$('.filters [name^="Cobro["]' ).serialize() + '&export=true';
      	 $('#descargar-xls').attr("disabled",false).html("Descargar en Excel"); 	
       },
       data: $('.filters [name^="Cobro["]' ).serialize() + '&export=true'
   });
}
</script>

<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>
<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'cobro-grid',
		'dataProvider' => $model->searchFiltros (),
		'filter' => $model,
		'columns' => array (
				// 'id_cobro',
				array (
						'name' => 'id_tipo_factura',
						'value' => '$data->tipoFactura->nombre',
						'filter' => CHtml::listData ( TipoFactura::model ()->findAll ( array (
								'order' => 'nombre'
						) ), 'id_tipo_factura', 'nombre' )
				),
				'NumFactura',
				array (
						'name' => 'Fecha',
						'value' => '$data->Fecha!="0000-00-00"?LGHelper::functions()->displayFecha($data->Fecha):""',
						/*'filter' => $this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
						 'model' => $model,
								'attribute' => 'Fecha',
								'language' => 'es',
								'htmlOptions' => array (
										'id' => 'datepicker_for_Fecha',
										'size' => '10'
								),
								'defaultOptions' => array ( // (#3)
										'showOn' => 'focus',
										'showOtherMonths' => true,
										'selectOtherMonths' => true,
										'changeMonth' => true,
										'changeYear' => true,
										'showButtonPanel' => true,
											
								)
						), true )  // (#4)*/
				),
				'Importe',
				array (
						'name' => 'id_cliente',
						'value' => '$data->cliente->nombre',
						'filter' => CHtml::listData ( Cliente::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cliente', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra->Nombre',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				array (
						'name' => 'id_imputacion',
						'value' => '$data->imputacion->Nombre',
						'filter' => CHtml::listData ( Imputacion::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_imputacion', 'Nombre' ) 
				),
				array (
						'name' => 'id_forma',
						'value' => '$data->formaPago->Nombre',
						'filter' => CHtml::listData ( FormaPago::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_forma', 'Nombre' ) 
				),
				array(
					'name' => 'FechaCobro',
						'value' => '$data->FechaCobro!="0000-00-00"?LGHelper::functions()->displayFecha($data->FechaCobro):""',						
),
		array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );

// (#5)
Yii::app ()->clientScript->registerScript ( 're-install-date-picker', "
function reinstallDatePicker(id, data) {
          $('#datepicker_for_Fecha').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['es'],{'dateFormat' : 'yy-mm-dd'}));
}
" );
?>
<br>
<div class="row-center">
<a target='_blank' id="descargar-xls" class="btn btn-primary" onclick="exportarXLS();">Descargar en EXCEL</a>
</div>
