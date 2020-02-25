
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_pago'); ?>
<?php echo $form->textField($model,'id_pago'); ?>
<?php echo $form->error($model,'id_pago'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'monto'); ?>
<?php echo $form->textField($model,'monto',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'monto'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fecha_pago'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'TarjetaPago[fecha_pago]',
								 //'language'=>'de',
								 'value'=>$model->fecha_pago,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'fecha_pago'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_tarjeta'); ?>
<?php echo $form->textField($model,'id_tarjeta'); ?>
<?php echo $form->error($model,'id_tarjeta'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
</div>
</div>
