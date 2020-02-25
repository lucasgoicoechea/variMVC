<script type="text/javascript">

function sendAddRetencion()
 {
	
   var data='';
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#retencion_update").find( "[name*='RetencionPerce']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '/ralbaMVC/admin/gasto/agregarNuevaRetencion.html?id_gasto=<?php echo $id_gasto;?>',
   data:data,
success:function(data){
				alert(data);
				$('#list_cheques').html(data);
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
  $.ajax({
  	  dataType : "html",
  	  url: '/ralbaMVC/admin/gasto/agregarNuevaRetencion.html?id_gasto=<?php echo $id_gasto;?>',
  	  data: {refresh:'true',id_gasto:'<?php echo $id_gasto; ?>'},
  	  success: function(dataHtml) {
  	    // Do something after AJAX is completed.
  		  dataInnerHtml = dataHtml;
  	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
 	   
  	  }
  	});
}
 
</script>
<div id="retencion_update">
<div class="contenedor-fila" style="background-color: rgb(221, 221, 221);">
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'descripcion'); ?>
<?php echo CHtml::activeTextField($model,'descripcion',array('size'=>20,'maxlength'=>120)); ?>
<?php echo CHtml::error($model,'descripcion'); ?>
	</div>
		<div class="contenedor-columna-20">
		<?php echo CHtml::activeLabelEx($model,'es_porcentaje'); ?>
<?php echo CHtml::activeCheckBox($model,'es_porcentaje'); ?>
<?php echo CHtml::error($model,'es_porcentaje'); ?>
	</div>
	<div class="contenedor-columna-30">
	<label>Importe fijo</label>
<?php //echo CHtml::activeTextField($model,'valor_fijo',array('size'=>20,'maxlength'=>120)); ?>
	</div>
		<div class="contenedor-columna-20">
		<label>Es valor fijo:</label>
<?php //echo CHtml::activeCheckBox($model,'impuesto_fijo'); ?>
	</div>
<div class="row-center">
	<?php

	echo CHtml::Button ( 'Guardar Nueva Retención', array (
			'onclick' => 'sendAddRetencion();',
			'class' => 'btn-primary' 
	) );
	?>
	</div>
	</div>
	

</div>
