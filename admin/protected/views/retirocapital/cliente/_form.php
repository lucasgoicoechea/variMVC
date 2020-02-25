
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'codigo'); ?>
<?php echo $form->textField($model,'codigo'); ?>
<?php echo $form->error($model,'codigo'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>62)); ?>
<?php echo $form->error($model,'nombre'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'telefono'); ?>
<?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'telefono'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fax'); ?>
<?php echo $form->textField($model,'fax',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'fax'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			</div>
	</div>



	<div class="contenedor-fila">
		
<div class="contenedor-columna">
<label for="Localidad">Belonging Localidad</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'localidad',
							'fields' => 'd_descripcion',
							'allowEmpty' => true,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
<label for="Moneda">Belonging Moneda</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'moneda',
							'fields' => 'nombre',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
</div>
<div class="contenedor-columna">
</div>
</div>
</div>
