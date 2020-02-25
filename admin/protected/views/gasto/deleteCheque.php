<?php
Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );

?>
<div class="contenedor-tabla">
<div class="contenedor-fila">
		<div class='contenedor-columna-90 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 600px; text-align: center; padding: 5px;">
<?php echo $mensaje;?>
		</div>
</div>
<div class="contenedor-fila">
	
		<div class='contenedor-columna-90 center'>
			<?php
			echo CHtml::button ( 'Actualizar', array (
					'onclick' => 'send();',
					// 'onclick' => "window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');",
					'class' => 'btn btn-primary' 
			) );
			?></div>
	
</div>
</div>


<script type="text/javascript">
 
function send()
 {
 
  // var data=$("#gastos-form").serialize();
  var dataInnerHtml;
 
  $.ajax({
	async: false,  
   type: 'POST',
   //  data:data,
 	  url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true&id_pago='.$id_pago; ?>',
 success: function(dataHtml) {
 		   	    // Do something after AJAX is completed.
 		   		  dataInnerHtml = dataHtml;
 		   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
 		   	   /*window.parent.$('#cru-frame').attr('src','');
 		   	   window.parent.$('#cru-dialog').dialog('close');*/
 		   	refreshTotalesGenerales();
 		   	  },
    
   error: function(data) { // if error occured
         alert("Ocurrió un error, reportelo.");
         alert(data);
    },
 
  dataType:'html'
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
		   	   window.parent.$('#cru-frame-cheque').attr('src','');
		   	   window.parent.$('#cru-dialog-cheque').dialog('close');
		   	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 });

}
 
</script>