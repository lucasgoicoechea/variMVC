<?php
$this->breadcrumbs=array(
	'Cobros'=>array('index'),
	$model->id_cobro,
);


?>

<div class="titulo">Comprobante de Venta </div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			array (
						'name' => 'Tipo Factura',
						'value' => $model->tipoFactura->nombre 
				),
			'NumFactura',
		'Fecha',
		),
)); ?>
<div class="titulo">Detalle de Venta</div>
<?php
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			array (
					'name' => 'Cliente',
					'value' => $model->cliente->getDescripcion ()
			),
			array (
						'name' => 'Obra',
						'value' => $model->obra->getDescripcion () 
				),
		'Importe',
		'Detalles',
	),
))?>

<div class="contenedor-fila"  id="saldos_cobro">	
	<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
			class="contenedor-columna">
			<b><label>TOTAL A COBRAR</label></b> <b>$ <? echo $model->Importe ?></b>
	</div>	
	<div style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
				class="contenedor-columna">
		<b><label>TOTAL COBRADO</label></b> <b>$ <? echo LGHelper::functions ()->formatNumber($model->getTotalCobrado()) ?></b>
	</div>
	<div style="background: white; border-radius: 25px; border: 2px solid rgb(12, 12, 12); width: 200px; text-align: center; padding: 5px;"
				class="contenedor-columna">
		<b><label>SALDO COBRO</label></b> <b>$ <? echo LGHelper::functions ()->formatNumber($model->getPendienteCobro()) ?></b>
		- <?php echo '<b style="color: black;" >'.($model->cobrado?'COBRADO':'PENDIENTE').'</B>';  ?>
	</div>
	</div>
</div>
<div class="titulo">Detalle de Cobros Ingresados</div>
<?php
$modelItem = new CobroItem();
$modelItem->id_cobro= $model->id_cobro;
$modelItem->Importe = null;
$modelItem->asentado = null;
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'cobro-item_grid',
		'dataProvider' => $modelItem->search (),
		'filter' => $modelItem,
		'columns' => array (
			'Indice',

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
				mes_iva, 
				Detalles,
				numero_orden_pago,
				'Importe',
				array (
						'htmlOptions' => array (
								'width' => '20px'
						),
						'header' => ' ',
						'template' => '{borrarComprobante}{imprimirOrden}',
						'class' => 'CButtonColumn',
						'buttons' => array (
							'imprimirOrden' => array (
							'label' => 'Imprimir Orden Pago',
							'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
							'url' => '$data->getUrlImprimir()',
							'visible' => 'true',
							'options' => array (
									'target' => '_blank' 
								)
								)
								,
								'borrarComprobante' => array (
										'label' =>'Borra el movimiento de cobro',
										'imageUrl' => Yii::app ()->theme->baseUrl . '/img/cruzRed.png'	,
										'url' => '$data->getUrlBorrarMovimiento()',
										'visible' => '!$data->isAnulado()',
										'click' => "function(){
													    $.fn.yiiGridView.update('cobro-item_grid', {
													        type:'GET',
													        url:$(this).attr('href'),
													        success:function(data) {
																	alert('Movimiento ANULADO');
																	window.parent.$('#saldos_cobro').html(data);
													              $.fn.yiiGridView.update('cobro-item_grid');
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
<?php
$this->renderPartial ( 'createCobroItem', array (	
	'model' => $model,
	'grillaPosgrados' => 'cobro-item_grid',
	) 
);
?>
<div class="row-center">
  <span >
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank' 
	) );
    ?>
    </span>
    <span>
    <?php 
	echo CHtml::link ( 'Volver', $this->createUrl ( 'cobro/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
</div>
