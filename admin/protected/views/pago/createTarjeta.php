
<div class="subtitulo">
REGISTRAR NUEVA PAGO CON TARJETA </div>

<div class="form" id="tarjeta_pago_ajax">

<?php 
echo $this->renderPartial('_formTarjeta', array(
	'model'=>$model,
	)); ?>

<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Tarjeta', array (
			'onclick' => 'sendTarjeta();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>

<script type="text/javascript">
 
function sendTarjeta()
 {
	
   var data=$("#TarjetaPago").serialize();
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#tarjeta_pago_ajax").find( "[name*='TarjetaPago']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
				$.fn.yiiGridView.update('tarjeta-pago-grid', {
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