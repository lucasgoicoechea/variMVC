
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Codigo'); ?>
<?php echo $form->textField($model,'Codigo'); ?>
<?php echo $form->error($model,'Codigo'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
</div>
</div>
