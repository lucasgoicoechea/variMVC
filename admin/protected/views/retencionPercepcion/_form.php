
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>120)); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'es_porcentaje'); ?>
<?php echo $form->checkBox($model,'es_porcentaje'); ?>
<?php echo $form->error($model,'es_porcentaje'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
</div>
</div>
