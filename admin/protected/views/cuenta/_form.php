
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">

		<div class="contenedor-columna-30">
			<label> Código o Número</label>
<?php echo $form->textField($model,'Codigo',array('size'=>10,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Codigo'); ?>
	</div>
		<div class="contenedor-columna-20">
                <?php echo $form->labelEx($model,'cerrada'); ?>
                <?php echo $form->checkBox($model,'cerrada'); ?>
                
        </div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php echo $form->textField($model,'Nombre',array('size'=>40,'maxlength'=>40,
			'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;'));?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
</div>
</div>


