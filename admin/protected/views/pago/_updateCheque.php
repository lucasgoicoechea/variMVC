
<script type="text/javascript">
   
	 function calcularFechaCobro(id_cheque)
	 {
		   var data='';
		  var dataInnerHtml;
		  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
		  data=$("#cheque_update"+id_cheque).find( "[name*='Cheque']" ).serialize();
		  $.ajax({
			async: false,  
		   type: 'GET',
		    url: '<?php echo Yii::app()->createUrl('pago/calcularFecha', array()); ?>',
		   data:data,
		success:function(data){
						$('#nuevaFecha_cheque'+id_cheque).html(data);
		              },
		   error: function(data) { // if error occured
		         alert("Error occured.please try again");
		         alert(data);
		    },
		 
		  dataType:'html'
		  });
}
function sendCheque(id_cheque)
 {
	
   var data='';
  var dataInnerHtml;
  //data= {ajaxid:4,UserID: UserID , EmailAddress:encodeURIComponent(EmailAddress)},
  data=$("#cheque_update"+id_cheque).find( "[name*='Cheque']" ).serialize();
  $.ajax({
	async: false,  
   type: 'GET',
    url: '<?php echo Yii::app()->createUrl('pago/modificarCheque', array('id_pago'=>$id_pago)); ?>&id_cheque='+id_cheque,
   data:data,
success:function(data){
				//alert(data);
				$('#list_cheques').html(data);
				 refreshTotalesGenerales();
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });

}
 
</script>
<div id="cheque_update<?php echo $model->id_cheque;?>">
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label>A la Orden de:</label>
			<?php echo CHtml::activeTextField($model,'a_la_orden',array('size'=>40,'maxlength'=>110)); ?>
			<?php echo CHtml::error($model,'a_la_orden'); ?>
		</div>
		<div class="contenedor-columna-20">
			<label>Porcentaje impuesto al Debito:</label>
			<?php echo CHtml::activeTextField($model,'porc_impuesto_debito',array('size'=>10,'maxlength'=>110)); ?>
			<?php echo CHtml::error($model,'porc_impuesto_debito'); ?>
		</div>
		<div class="contenedor-columna-20">
			<label>Porcentaje impuesto al Cheque:</label>
			<?php echo CHtml::activeTextField($model,'porc_impuesto_cheque',array('size'=>10,'maxlength'=>110)); ?>
			<?php echo CHtml::error($model,'porc_impuesto_cheque'); ?>
		</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo CHtml::activelabelEx($model,'FechaEmision'); ?>
		<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Cheque[FechaEmision]',
	'language'=>'es',
				'value' => $model->FechaEmision,
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:90px !important' 
						),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
						)
						) );
						;
						?>
						<?php echo CHtml::error($model,'FechaEmision'); ?>
		</div>
		<div class="contenedor-columna-20">
			<label>Monto:</label>
			<?php 
          //$model->Importe= LGHelper::functions()->formatNumber($model->Importe);
           if($model->Importe==nulll){
              $model->Importe = 0.00;
           }
	 		echo CHtml::activeTextField($model,'Importe',array('size'=>10,'maxlength'=>110,'id'=>'Cheque_Importe'.$model->Numero)); 
			$this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#Cheque_Importe'.$model->Numero,
                    'currency'=>'PHP',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>'.',
                        'decimal'=>',',
                        'precision'=>2,
                    )
                ));

               ?>
			<?php echo CHtml::error($model,'Importe'); ?>

		</div>
		<div class="contenedor-columna-30">
			<label for="Cuenta">Diferido Dias</label>
			<?php
			$htmlOptions = array (
				"onclick" => "calcularFechaCobro(".$model->id_cheque.");"
			);

			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'chequeDias',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false ,
			'htmlOptions' => $htmlOptions
			) );
			?>
		</div> 
		<div class="contenedor-columna-30">
			<label>Fecha Cobro</label>
			
<div id="nuevaFecha_cheque<?php echo $model->id_cheque ?>" >
			<?php

			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Cheque[FechaPago]',
			'language'=>'es',
				'value' => $model->FechaPago,
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:90px !important' 
						),
				'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
				)
				) );
						;
						?>
	</div>					
		<?php echo CHtml::error($model,'FechaPago'); ?>
		</div>

	</div>
	<div class="row-center">
	<?php

	echo CHtml::Button ( 'Guardar', array (
			'onclick' => 'sendCheque('.$model->id_cheque.');',
			'class' => 'btn btn-primary' 
	) );
	?>
	</div>
</div>
