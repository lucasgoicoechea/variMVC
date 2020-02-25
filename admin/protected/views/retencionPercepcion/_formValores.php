
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'valor'); ?>
<?php echo $form->textField($model,'valor'); ?>
<?php echo $form->error($model,'valor'); ?>
	</div>
	</div>
</div>
