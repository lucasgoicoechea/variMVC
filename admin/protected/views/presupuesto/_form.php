
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'NumeroOrden'); ?>
<?php echo $form->textField($model,'NumeroOrden'); ?>
<?php echo $form->error($model,'NumeroOrden'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha'); ?>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Presupuesto[Fecha]',
		'language' => 'es',
		'value' => $model->Fecha!=null?LGHelper::functions()->displayFecha($model->Fecha):'',
		'htmlOptions' => array (
				'size' => 10,
				'style' => 'width:80px !important' 
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
		) 
) );
;
?>
<?php echo $form->error($model,'Fecha'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="Obra">Obra</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'obra',
					'fields' => 'Nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false,
					'htmlOptions' => array (
							'style' => 'width: 500px;' 
					) 
			) );
			?>
			</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Cantidad'); ?>
<?php echo $form->textField($model,'Cantidad',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Cantidad'); ?>
	</div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'Detalle'); ?>
<?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>154)); ?>
<?php echo $form->error($model,'Detalle'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="Material">Material</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'material',
					'fields' => 'Nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
		<div class="contenedor-columna">
			<label for="Proveedor">Proveedor</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'proveedor',
					'fields' => 'Nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
	</div>

	<div class="contenedor-fila">

		<div class="contenedor-columna">
			<label for="AtencionVenta">Atencion Venta</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'atencionVenta',
					'fields' => 'nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
		
	</div>

</div>
