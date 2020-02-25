
<div class="subtitulo">
REGISTRAR NUEVA PAGO EN EFECTIVO </div>

<div class="form" id="efectivo_pago_ajax">

<?php 
echo $this->renderPartial('_formEfectivo', array(
	'model'=>$model,
	)); ?>

<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Pago en Efectivo', array (
			'onclick' => 'sendEfectivo();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>

<script type="text/javascript">
 
function sendEfectivo()
 {
	
   var data=$("#EfectivoPago").serialize();
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#efectivo_pago_ajax").find( "[name*='EfectivoPago']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
				$.fn.yiiGridView.update('efectivo-pago-grid', {
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