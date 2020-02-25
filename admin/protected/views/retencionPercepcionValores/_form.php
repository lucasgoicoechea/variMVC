
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
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
<?php echo $form->textField($model,'valor'); ?>
<?php echo $form->error($model,'valor'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'usuario_log'); ?>
<?php echo $form->textField($model,'usuario_log',array('size'=>60,'maxlength'=>60)); ?>
<?php echo $form->error($model,'usuario_log'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fecha_log'); ?>
<?php echo $form->textField($model,'fecha_log'); ?>
<?php echo $form->error($model,'fecha_log'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
</div>
</div>
