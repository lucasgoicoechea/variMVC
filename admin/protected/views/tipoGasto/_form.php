
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'codigo'); ?>
<?php echo $form->textField($model,'codigo',array('size'=>11,'maxlength'=>11)); ?>
	</div>

		<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>50,'maxlength'=>50,
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'nombre'); ?>
	</div>

	</div>
</div>


