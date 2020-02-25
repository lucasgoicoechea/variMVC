
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'numero'); ?>
<?php echo $form->textField($model,'numero',array('size'=>40,'maxlength'=>80)); ?>
<?php echo $form->error($model,'numero'); ?>
	</div>

	
	<div class="contenedor-columna-30">
<label >Tipo Tarjeta</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'tipoTarjeta',
							'fields' => 'descripcion',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
	</div>
	
	<div class="contenedor-fila">
	<div class="contenedor-columna-90">
		<?php echo $form->labelEx($model,'titular'); ?>
<?php echo $form->textField($model,'titular',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'titular'); ?>
	</div>
	</div>
</div>
