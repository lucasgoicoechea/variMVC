<?php
if (isset ( $conFormulario ) && $conFormulario) {
	Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );
	$form = $this->beginWidget ( 'CActiveForm', array (
			'id' => 'gastos-form',
			'enableAjaxValidation' => false,
			'htmlOptions' => array (
					'onsubmit' => "return false;",
					'onkeypress' => " if(event.keyCode == 13){ send(); } " 
			) 
	) );
}
?>
<?php
/*Yii::app ()->clientScript->registerScript ( 'search', "
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
			" );*/
?>

<div class="titulo">Seleccionar Facturas/Comprobantes</div>

<?php //echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php
echo CHtml::hiddenField('OrdenPagoGasto[id_orden_pago]',$model->id_orden_pago);
/*
$this->renderPartial ( '_search', array (
		'model' => $model 
) );*/
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $gasto->searchGastos(),
		'filter' => $gasto,
		'columns' => array (
				array(
						'header'=>'',
						'value'=>'$data->id_gasto',
						'class'=>'CCheckBoxColumn',
						'selectableRows' => '10',
				),
				array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				'FechaAsiento',
				array (
						'name' => 'id_tipo_comprobante',
						'value' => '$data->tipoComprobante->Nombre',
						'filter' => CHtml::listData ( TipoComprobante::model ()->findAll ( array (
								"condition"=>'visible=1',
								'order' => 'Nombre'
						) ), 'id_tipo_comprobante', 'Nombre' )
				),
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
						'value' => '$data->obra!=null?$data->obra->Nombre:""',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				'Detalle',
				/*
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
				),*/
		/*array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{imprimirOferta}',
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
								) 
						) 
				)*/ 
		) 
) );
?>
	<div class="buttons row-center"></div>
	<div class="row-center">

		<!-- form -->

			
<?php
if (isset ( $conFormulario ) && $conFormulario) {
	echo CHtml::Button ( $model->isNewRecord ? 'Agregar Comprobantes' : 'Agregar Comprobantes', array (
			'onclick' => 'send();',
			'class' => 'btn btn-primary' 
	) );
	echo CHtml::button ( 'Cancel', array (
			'onclick' => "window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');",
			'class' => 'btn btn-primary' 
	) );
	?>     
    </div>
  
<?php
	
	$this->endWidget ();
}
?>
 </div>


<script type="text/javascript">
 
function send()
 {
 
   var data=$("#gastos-form").serialize();
  var dataInnerHtml;
 
  $.ajax({
	async: false,  
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction); ?>',
   data:data,
success:function(data){
				alert(data); 
			    //window.parent.$("#<?php echo $grillaPosgrados ?>").update("<?php echo $grillaPosgrados ?>");
                //$.get('<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true'; ?>')
                //.done(function(data){
                    //window.parent.$("#<?php echo $grillaPosgrados ?>").html(data);
                //})
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });
  $.ajax({
   	  dataType : "html",
   	  url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true&id_orden_pago='.$id_orden_pago; ?>',
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
   	   window.parent.$('#cru-frame').attr('src','');
   	   window.parent.$('#cru-dialog').dialog('close');
   	refreshTotalesGenerales();
   	  }
   	});
}


function refreshTotalesGenerales()
{

 // var data=$("#gastos-form").serialize();
 var dataInnerHtml;

 $.ajax({
	async: false,  
  type: 'POST',
  //  data:data,
	  url: '<?php echo Yii::app()->createAbsoluteUrl('pago/actualizarTotalesGrales').'?refresh=true&id_pago='.$id_pago; ?>',
success: function(dataHtml) {
		   	    // Do something after AJAX is completed.
		   		  dataInnerHtml = dataHtml;
		   	   window.parent.$('#totalesGrales').html(dataInnerHtml);
		   	   window.parent.$('#cru-frame').attr('src','');
		   	   window.parent.$('#cru-dialog').dialog('close');
		   	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 }); }
</script>