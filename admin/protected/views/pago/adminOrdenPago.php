<?php
if (isset ( $conFormulario ) && $conFormulario) {
	Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );
	$form = $this->beginWidget ( 'CActiveForm', array (
			'id' => 'orden-pago-form',
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

<div class="titulo">Seleccionar Ordenes de Pago</div>

<?php //echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php
echo CHtml::hiddenField('PagoOrdenPago[id_pago]',$model->id_pago);
/*
$this->renderPartial ( '_search', array (
		'model' => $model 
) );*/
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'orden-pago-grid',
		'dataProvider' => $ordenPago->searchOrdenesPagos(),
		'filter' => $ordenPago,
		'columns' => array (
				array(
						'header'=>'',
						'value'=>'$data->id_orden_pago',
						'class'=>'CCheckBoxColumn',
						'selectableRows' => '10',
				),
				
array(
            'type'=>'raw',
            'value'=>'CHtml::ajaxLink(CHtml::image(Yii::app ()->theme->baseUrl . "/img/gridview/up.gif"),Yii::app()->createUrl("/ordenPago/verComprobante"),array(
                            "data"=>array(
                                    "id_orden_pago"=>$data->id_orden_pago,
                                    "refresh" => true,
                                    "direction"=>"up"
                            ),
                 "success"=>"js:function( data )    {
    jQuery(\"#comprobantes".$data->id_orden_pago."\").remove();
                  }",
    
                        ))."".
                    CHtml::ajaxLink(CHtml::image(Yii::app ()->theme->baseUrl . "/img/gridview/down.gif"),Yii::app()->createUrl("/ordenPago/verComprobante"),array(
                            "data"=>array(
                                    "id_orden_pago"=>$data->id_orden_pago,
                                    "refresh" => true,
                                    "direction"=>"down"
                            ),
                           "success"=>"js:function( data )    {
                     
    jQuery(\"#send-link".$data->id_orden_pago."\").closest(\"tr\").after(\"<tr><td colspan=\'8 \' id=\'comprobantes".$data->id_orden_pago."\'></td></tr>\");
    jQuery(\"#comprobantes".$data->id_orden_pago."\").html(data);
    
                  }",
                     "beforeSend"=>"function( request )    {
                           
                     }"
                        ),    array("id" => "send-link$data->id_orden_pago"))',),
								array (
						'name' => 'numero_op',
						'value' => '$data->numero_op',
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'fecha',
						'value' => '$data->fecha!=null?$data->fecha:""',
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'id_cuenta',
						'value' => '$data->cuenta!=null?$data->cuenta->descripcion:""',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
								) ), 'id_cuenta', 'descripcion' ),
						'htmlOptions' => array (
								'width' => '100px',
								'style' => "text-align:center;" 
								)
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
								'width' => '30px',
								'style' => "text-align:center;" 
								),
					'header'=>'Monto',
								//'type' => 'raw',
								//'value' => 'OrdenPago::model()->getMonto($data->id_orden_pago)'
						'value' => '$data->getMonto()'
						),
				'observacion',
				
						
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
 
   var data=$("#orden-pago-form").serialize();
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
   	  url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true&id_pago='.$id_pago; ?>',
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
   	  // window.parent.$('#cru-frame').attr('src','');
   	  // window.parent.$('#cru-dialog').dialog('close');
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