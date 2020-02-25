
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'Fecha'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				// 'model'=>'$model',
				'name' => 'RetiroCapital[Fecha]',
						 'language'=>'es',
				'value' => $model->Fecha != null ? LGHelper::functions()->displayFecha($model->Fecha) : LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:95px !important' 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
				) 
		) );
		;
		?>
<?php echo CHtml::error($model,'Fecha'); ?>
	</div>
	
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Importe'); ?>
<?php echo $form->textField($model,'Importe'); ?>
<?php echo $form->error($model,'Importe'); ?>
	</div>
			
<div class="contenedor-columna">
<label for="Cuenta">Cuenta</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cuenta',
							'fields' => 'descripcion',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textArea($model,'descripcion',array( 'style'=>'width: 752px; height: 87px;','size'=>140,'maxlength'=>250)); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>

</div>
