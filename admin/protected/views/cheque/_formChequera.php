
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
<?php //echo 'Current PHP version: ' . phpversion();?>
	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'serie'); ?>
<?php echo $form->textField($model,'serie',array('size'=>10,'maxlength'=>110)); ?>
<?php echo $form->error($model,'serie'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Numero'); ?>
<?php echo $form->textField($model,'Numero',array('size'=>20,'maxlength'=>110)); ?>
<?php echo $form->error($model,'Numero'); ?>
	</div>
		<div class="contenedor-columna-30">
		<label>hasta Número</label>
<?php echo $form->textField($model,'chequeNroHasta',array('size'=>20,'maxlength'=>110)); ?>
<?php echo $form->error($model,'chequeNroHasta'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label for="CuentaBanco">Cuenta Banco</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'cuentaBanco',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
<div class="contenedor-columna">
		<label>A la Orden de:</label>
<?php echo $form->textField($model,'a_la_orden',array('size'=>60,'maxlength'=>110)); ?>
<?php echo $form->error($model,'a_la_orden'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
<div class="contenedor-columna-30">
	<label>Porcentaje impuesto al Debito:</label>
<?php echo $form->textField($model,'porc_impuesto_debito',array('size'=>10,'maxlength'=>110)); ?>
<?php echo $form->error($model,'porc_impuesto_debito'); ?>
			</div>
<div class="contenedor-columna-30">
		<label>Porcentaje impuesto al Cheque:</label>
<?php echo $form->textField($model,'porc_impuesto_cheque',array('size'=>10,'maxlength'=>110)); ?>
<?php echo $form->error($model,'porc_impuesto_cheque'); ?>
	</div>
	</div>

</div>
