
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_pago'); ?>
<?php echo $form->textField($model,'id_pago'); ?>
<?php echo $form->error($model,'id_pago'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'id_cheque'); ?>
<?php echo $form->textField($model,'id_cheque'); ?>
<?php echo $form->error($model,'id_cheque'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
<div class="contenedor-columna">
<label for="Pago">Belonging Pago</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'pago',
							'fields' => 'id_obra',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
<label for="Cheque">Belonging Cheque</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cheque',
							'fields' => 'id_obra',
							'allowEmpty' => true,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
</div>
</div>
