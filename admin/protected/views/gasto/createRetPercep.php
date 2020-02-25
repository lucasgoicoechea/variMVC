

<div class="form" id="percepret_pago_ajax">

<?php 
echo $this->renderPartial('_formRetencionPercepcion', array(
	'model'=>$model,
	)); ?>
	
<div id="nueva-ret-form"
		style="display: none">
<?php

/*$this->renderPartial ( '_addRetencionPercepcion', array (
		'model' => new RetencionPercepcion(),
		'id_gasto' => $id_gasto,
		'grillaPosgrados'=>$grillaPosgrados
) );*/
?>
</div>	
<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Retención', array (
			'onclick' => 'sendRetencion();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>

<script type="text/javascript">
 
function sendRetencion()
 {
	
   var data=$("#TransferenciaPago").serialize();
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#percepret_pago_ajax").find( "[name*='GastoRetencionPercepcion']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
				$.fn.yiiGridView.update('gasto-retencion-percepcion-grid', {
					data: $(this).serialize()
					}				 );
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });
  var subtotal = $("#Gasto_Monto").val();
  $.ajax({
   	  dataType : "html",
   	  url: '<?php echo Gasto::model ()->getUrlTotalGasto ( $id_gasto );?>',
   	  data: {refresh:'true',id_gasto:'<?php echo $id_gasto; ?>',neto_tmp: subtotal},
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#totalGastoID').html(dataInnerHtml);
   	  }
   	});
 	
}



</script>