
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'SaldoBanco'); ?>
<?php echo $form->textField($model,'SaldoBanco',array('size'=>12,'maxlength'=>12)); ?>
<?php echo $form->error($model,'SaldoBanco'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'SaldoEfectivo'); ?>
<?php echo $form->textField($model,'SaldoEfectivo',array('size'=>12,'maxlength'=>12)); ?>
<?php echo $form->error($model,'SaldoEfectivo'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha'); ?>
<?php echo $form->textField($model,'Fecha'); ?>
<?php echo $form->error($model,'Fecha'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Hora'); ?>
<?php echo $form->textField($model,'Hora'); ?>
<?php echo $form->error($model,'Hora'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_saldos'); ?>
<?php echo $form->textField($model,'id_saldos'); ?>
<?php echo $form->error($model,'id_saldos'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
<div class="contenedor-columna">
<label for="Cuenta">Belonging Cuenta</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cuenta',
							'fields' => 'Codigo',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
</div>
</div>
