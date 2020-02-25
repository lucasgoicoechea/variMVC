<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Cobro' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
				'url' => array (
						'create' 
				) 
		) 
);

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

if (isset ( $creadoExito ) && $creadoExito == true) {
	echo "<div style='color: green'><b>Cobro creado con Exito</b></div>";
}
?>
<div class="titulo">Administrar&nbsp;Cobros</div>
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
		'id' => 'cobro-grid',
		'dataProvider' => $model->search (),
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
						'filter' => $this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
								'model' => $model,
								'attribute' => 'Fecha',
								'language' => 'es',
								// 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
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
						), true )  // (#4)
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
				array (
						'name' => 'FechaCobro',
						'value' => '$data->FechaCobro!="0000-00-00"?LGHelper::functions()->displayFecha($data->FechaCobro):""',
				),
				
				array (
						'htmlOptions' => array (
								'width' => '20px'
						),
						'header' => ' ',
						'template' => '{view}{update}{anularFactura}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'anularFactura' => array (
										'label' => 'Anular Factura - genera Nota de Crédito',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/delete_x.gif",
										'url' => '$data->getUrlAnulaFactura()',
										'visible' => '!$data->isAnulado()',
										'click' => "function(){
													    $.fn.yiiGridView.update('cobro-grid', {
													        type:'GET',
													        url:$(this).attr('href'),
													        success:function(data) {
																	alert('Factura ANULADA, se generó Nota de Crédito');
													              $.fn.yiiGridView.update('cobro-grid');
													        }
													    })
													    return false;
													  }",
										'options' => array (
												'target' => '_blank'
										)
								)
						)),
	)));

// (#5)
Yii::app ()->clientScript->registerScript ( 're-install-date-picker', "
function reinstallDatePicker(id, data) {
          $('#datepicker_for_Fecha').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['es'],{'dateFormat' : 'yy-mm-dd'}));
}
" );
?>
<br>
<!-- <div class="contenedor-tabla"> -->
<?php
/*
 * $this->beginWidget ( 'LGVerticalTab', array (
 * 'tagIdContent' => 18,
 * 'tagTitle' => 'Agregar nuevo Cobro',
 * 'expandedTab' => false
 * ) );
 * $this->renderPartial ( 'createSinTitulo', array (
 * 'model' => $modelForm,
 * 'cobrado' => true
 * ) );
 * $this->endWidget ();
 */
?>
<!-- </div> -->
