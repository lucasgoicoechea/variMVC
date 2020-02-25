
<div class="subtitulo">
REGISTRAR NUEVO ITEM DE SUBCONTRATO </div>

<div class="form" id="subcontrato_ajax">

<?php 
echo $this->renderPartial('_formItem', array(
	'model'=>$model,
	)); ?>

<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Item', array (
			'onclick' => 'sendSubcontrato();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>

<script type="text/javascript">
 
function sendSubcontrato()
 {
	
   var data=$("#Contrato").serialize();
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#subcontrato_ajax").find( "[name*='Contrato']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
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
   	  data: {refresh:'true',id_contrato_cabecera:'<?php echo $model->id_contrato_cabecera; ?>'},
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#items_sub').html(dataInnerHtml);
  	   refreshTotalesGenerales();
   	  }
   	});
}
 
</script>