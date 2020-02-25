
<div class="titulo subtitulo">
REGISTRAR NUEVA COBRO </div>

<div class="form" id="cobro_item_ajax">

<?php 
$mItem =new CobroItem();
/*echo $this->renderPartial('_formCobroItem', array(
	'model'=> $mItem,
	'id_cobro' => $model->id_cobro
	));*/
	$html = $this->renderPartial ( '_formCobroItem', array (
		'id_cobro' => $model->id_cobro,
		'modelItem' => $mItem,
), true );
 echo $html;
	 ?>

<div class="row-center">
	<?php	echo CHtml::Button (  'Agregar Cobro', array (
			'onclick' => 'sendCobroItem();',
			'class' => 'btn btn-primary' 
	) );
?>
</div>


</div>
<? 
	$urlOperationAction = 'agregarCobroItem/'.$model->id_cobro;
?>
<script type="text/javascript">
 
function sendCobroItem()
 {
	
 var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  var data=$("#cobro_item_ajax").find( "[name*='CobroItem']" ).serialize();
  data = 	data + '&id_cobro=<?php echo $model->id_cobro; ?>';
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo $urlOperationAction; ?>',
   data:data,
success:function(data){
				alert(data);
				$.fn.yiiGridView.update('cobro-item_grid', {
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
   	  data: {refresh:'true',id_cobro:'<?php echo $model->id_cobro; ?>'},
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#saldos_cobro').html(dataInnerHtml);
  	   //refreshTotalesGenerales();
   	  }
   	});
}
 
</script>