
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fecha'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Recibo[fecha]',
								 //'language'=>'de',
								 'value'=>$model->fecha,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'fecha'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Importe'); ?>
<?php echo $form->textField($model,'Importe',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Importe'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Detalle'); ?>
<?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>510)); ?>
<?php echo $form->error($model,'Detalle'); ?>
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
		<div class="contenedor-columna-30">
			</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'impreso'); ?>
<?php echo $form->checkBox($model,'impreso'); ?>
<?php echo $form->error($model,'impreso'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
<div class="contenedor-columna">
<label for="Proveedor">Belonging Proveedor</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'proveedor',
							'fields' => 'Nombre',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
<label for="Obra">Belonging Obra</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'obra',
							'fields' => 'Codigo',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
<label for="Contrato">Belonging Contrato</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'contrato',
							'fields' => 'Fecha',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
</div>
</div>
