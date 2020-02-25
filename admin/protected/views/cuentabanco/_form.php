
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'codigo'); ?>
<?php echo $form->textField($model,'codigo',array('readonly'=>true)); ?>
<?php echo $form->error($model,'codigo'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'numero_cuenta'); ?>
<?php echo $form->textField($model,'numero_cuenta',array('size'=>60,'maxlength'=>60)); ?>
<?php echo $form->error($model,'numero_cuenta'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-70">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60,
			'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;'));?>
<?php echo $form->error($model,'nombre'); ?>
	</div>
<!-- 	<div class="contenedor-columna-30">
<label for="Empresas">Empresa</label><?php 
					/*$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'empresa',
							'fields' => 'nombre',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						);*/ ?>
			</div> -->
	</div>


</div>
