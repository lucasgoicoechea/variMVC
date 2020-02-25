
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Codigo'); ?>
<?php echo $form->textField($model,'Codigo'); ?>
<?php echo $form->error($model,'Codigo'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Costo'); ?>
<?php echo $form->textField($model,'Costo',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Costo'); ?>
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
		<?php echo $form->labelEx($model,'Observaciones'); ?>
<?php echo $form->textField($model,'Observaciones',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Observaciones'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Medida'); ?>
<?php echo $form->textField($model,'Medida',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Medida'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Material[Fecha]',
								 //'language'=>'de',
								 'value'=>$model->Fecha,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'Fecha'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		
<div class="contenedor-columna">
<label for="Rubro">Belonging Rubro</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'rubro',
							'fields' => 'Codigo',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
<div class="contenedor-columna">
<label for="SubRubro">Belonging SubRubro</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'subrubro',
							'fields' => 'Codigo',
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
