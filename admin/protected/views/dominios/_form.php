
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'codigo_dominio'); ?>
<?php echo $form->textField($model,'codigo_dominio'); ?>
<?php echo $form->error($model,'codigo_dominio'); ?>
	</div>
	</div>
</div>

<div class="contenedor-fila">
	<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
</div>
</div>


