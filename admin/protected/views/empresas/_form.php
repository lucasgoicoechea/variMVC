
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'nombre'); ?>
	</div>
	</div>
	<div class="contenedor-fila">

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'razon_social'); ?>
<?php echo $form->textField($model,'razon_social',array('size'=>60,'maxlength'=>200)); ?>
<?php echo $form->error($model,'razon_social'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'codigo'); ?>
<?php echo $form->textField($model,'codigo',array('size'=>6,'maxlength'=>6)); ?>
<?php echo $form->error($model,'codigo'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'cuit'); ?>
<?php echo $form->textField($model,'cuit'); ?>
<?php echo $form->error($model,'cuit'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'email'); ?>
<?php echo CHtml::activeEmailField($model,'email'); ?>
<?php echo $form->error($model,'email'); ?>
	</div>

	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'inicio_actividad'); ?>
<?php
$model->inicio_actividad = LGHelper::functions()->displayFecha($model->inicio_actividad);
$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Empresas[inicio_actividad]',
				'language' => 'es',
				'value' => $model->inicio_actividad,
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
						'showAnim' => 'fold',
					
				),
				'htmlOptions' => array (
						'size' => 13,
						'style' => 'width:100px !important' 
				) 
		) );
		;
		?>
<?php echo $form->error($model,'inicio_actividad'); ?>
	</div>
		<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'gerente'); ?>
<?php echo $form->textField($model,'gerente',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'gerente'); ?>
	</div>
	</div>

</div>
