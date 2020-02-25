
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textField($model,'descripcion',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>
</div>

<div class="contenedor-fila">
	<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'orden'); ?>
<?php echo $form->textField($model,'orden'); ?>
<?php echo $form->error($model,'orden'); ?>
	</div>
</div>
</div>


