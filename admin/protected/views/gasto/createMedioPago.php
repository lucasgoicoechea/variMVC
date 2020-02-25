<div class="form" id="efectivo_pago_ajax">


<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label for="TipoComprobante" style="font-size: 20px">Tipo Pago</label>
				<?php echo CHtml::activeDropDownList($model,'id_medio_pago',$model->getMediosPago()); ?>
				<?php //echo $form->error($model,'id_medio_pago'); ?>
			</div>
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'monto'); ?>
	<?php

		//$model->monto = LGHelper::functions()->formatNumber($model->monto);
	    $this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#MedioPagoForm_Monto',
                    'currency'=>'PHP',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>'.',
                        'decimal'=>',',
                        'precision'=>2,
                    )
                ));
		?>
<?php echo CHtml::activeTextField($model,'monto',array('size'=>20,'maxlength'=>12,'id'=>'MedioPagoForm_Monto')); ?>
<?php echo CHtml::error($model,'monto'); ?>
	</div>
	
	<div class="contenedor-columna-40">
		<?php echo CHtml::activeLabel($model,'fecha'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				// 'model'=>'$model',
				'name' => 'MedioPagoForm[fecha]',
				'language' => 'es',
				'value' => $model->fecha != null ? LGHelper::functions ()->displayFecha ( $model->fecha ) : LGHelper::functions ()->displayFecha ( CTimestamp::formatDate ( 'Y-m-d' ) ),
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:145px !important' ,
						 //'readonly'=>true 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true ,
						 //'readonly'=>true 
				) 
		) );
		;
		?>
<?php echo CHtml::error($model,'fecha'); ?>
		
	</div>
		</div>
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-60">
		<label>Detalle</label>
<?php echo CHtml::activeTextField($model,'detalle',array('size'=>80,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'detalle'); ?>
	</div>

</div>


<div class="row-center">
	<?php	/*echo CHtml::Button (  'Agregar Pago en Efectivo', array (
			'onclick' => 'sendEfectivo();',
			'class' => 'btn btn-primary' 
	) );*/
?>
</div>


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