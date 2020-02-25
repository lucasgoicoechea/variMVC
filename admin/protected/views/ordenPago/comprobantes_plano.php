<div id="admin_comprobantes_carga">
  <?php
	echo $this->renderPartial ( 'adminComprobantesCarga', array (
		'model' => $model,
) );
	/*$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
		foreach ( $resultados as $value ) {
			$montoTotalOP = $montoTotalOP + $value->gasto->Monto;
		}*/
  ?>
</div>

	</div>
<script>

function refreshTotalesGenerales()
{

 // var data=$("#gastos-form").serialize();
 var dataInnerHtml;

 $.ajax({
	async: false,  
  type: 'POST',
  //  data:data,
	  url: '<?php echo Yii::app()->createAbsoluteUrl('ordenPago/actualizarTotalesGrales').'?refresh=true&id_orden_pago='.$model->id_orden_pago; ?>',
success: function(dataHtml) {
		   	    // Do something after AJAX is completed.
		   		  dataInnerHtml = dataHtml;
		   	   window.parent.$('#totalesGrales').html(dataInnerHtml);
		  	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 }); }

</script>