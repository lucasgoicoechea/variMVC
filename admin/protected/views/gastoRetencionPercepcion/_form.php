
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_gasto'); ?>
<?php echo $form->textField($model,'id_gasto'); ?>
<?php echo $form->error($model,'id_gasto'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_retencion_percepcion'); ?>
<?php echo $form->textField($model,'id_retencion_percepcion'); ?>
<?php echo $form->error($model,'id_retencion_percepcion'); ?>
	</div>
	</div>
	

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'valor'); ?>
<?php echo $form->textField($model,'valor',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'valor'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'alicuota'); ?>
<?php echo $form->textField($model,'alicuota',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'alicuota'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		
</div>
</div>
