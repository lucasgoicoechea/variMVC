
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_cuenta_banco'); ?>
<?php echo $form->textField($model,'id_cuenta_banco'); ?>
<?php echo $form->error($model,'id_cuenta_banco'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'referencia'); ?>
<?php echo $form->textField($model,'referencia',array('size'=>60,'maxlength'=>60)); ?>
<?php echo $form->error($model,'referencia'); ?>
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
		<?php echo $form->labelEx($model,'cbu_destino'); ?>
<?php echo $form->textField($model,'cbu_destino',array('size'=>60,'maxlength'=>60)); ?>
<?php echo $form->error($model,'cbu_destino'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_pago'); ?>
<?php echo $form->textField($model,'id_pago'); ?>
<?php echo $form->error($model,'id_pago'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
</div>
</div>
