
<div class="subtitulo">
REGISTRAR NUEVA TRANSFERENCIA DE PAGO </div>

<div class="form" id="transferencia_pago_ajax">

<?php 
echo $this->renderPartial('_formTransferencia', array(
	'model'=>$model,
	)); ?>

<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Transferencia', array (
			'onclick' => 'sendTransferencia();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>

<script type="text/javascript">
 
function sendTransferencia()
 {
	
   var data=$("#TransferenciaPago").serialize();
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#transferencia_pago_ajax").find( "[name*='TransferenciaPago']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
				$.fn.yiiGridView.update('transferencia-pago-grid', {
					data: $(this).serialize()
					}				 );
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });
  $.ajax({
   	  dataType : "html",
   	  url: '<?php echo $urlOperationAction?>',
   	  data: {refresh:'true',id_pago:'<?php echo $id_pago; ?>'},
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
  	   refreshTotalesGenerales();
   	  }
   	});
}
 
</script>