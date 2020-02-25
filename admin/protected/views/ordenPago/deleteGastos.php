<?php
Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );

?>
<div class="contenedor-tabla">
<div class="contenedor-fila">
		<div class='contenedor-columna-90 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 600px; text-align: center; padding: 5px;">
Comprobante quitado con Exito de la Orden de Pago
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
 	  url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true&id_orden_pago='.$id_orden_pago; ?>',
 success: function(dataHtml) {
 		   	    // Do something after AJAX is completed.
 		   		  dataInnerHtml = dataHtml;
 		   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
 		   	   window.parent.$('#cru-frame').attr('src','');
 		   	   window.parent.$('#cru-dialog').dialog('close');
 		   	  },
    
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });

}
 
</script>