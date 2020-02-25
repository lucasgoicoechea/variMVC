<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
			<label>Código</label>
<?php echo $form->textField($model,'id_proveedor',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'id_proveedor'); ?>
	</div>
	
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha_Ingreso'); ?>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Personal[Fecha_Ingreso]',
		// 'language'=>'de',
		'value' => $model->Fecha_Ingreso != null ? LGHelper::functions()->displayFecha($model->Fecha_Ingreso) : '',
		'htmlOptions' => array (
			'size' => 12,
			'style' => 'width:100px !important'  
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
				'changeYear' => true 
		) 
) );
;
?>
<?php echo $form->error($model,'Fecha_Ingreso'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha_Baja'); ?>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Personal[Fecha_Baja]',
		// 'language'=>'de',
		'value' => $model->Fecha_Baja != null ? LGHelper::functions()->displayFecha($model->Fecha_Baja) : '',
		'htmlOptions' => array (
			'size' => 12,
			'style' => 'width:100px !important'  
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
				'changeYear' => true 
		) 
) );
;
?>
<?php echo $form->error($model,'Fecha_Baja'); ?>
	</div>
	<div class="contenedor-columna-10">
		<label>Activo</label>
<?php echo CHtml::activeCheckBox($model,'activo'); ?>
<?php //echo CHtml::error($model,'pagada'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<?php echo $form->labelEx($model,'Apellido'); ?>
<?php echo $form->textField($model,'Apellido',array('size'=>43,'maxlength'=>43)); ?>
<?php echo $form->error($model,'Apellido'); ?>
</div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php

echo $form->textField ( $model, 'Nombre', array (
		'size' => 60,
		'maxlength' => 70,
		'onkeyup' => 'javascript:this.value=this.value.toUpperCase();',
		'style' => 'text-transform:uppercase;' 
) );
?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
				<?php echo $form->labelEx($model,'TipoDoc'); ?>
<?php echo $form->textField($model,'TipoDoc',array('size'=>18,'maxlength'=>18)); ?>
<?php echo $form->error($model,'TipoDoc'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'NumDoc'); ?>
<?php echo $form->textField($model,'NumDoc',array('size'=>17,'maxlength'=>17)); ?>
<?php echo $form->error($model,'NumDoc'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'CUIL'); ?>
<?php echo $form->textField($model,'CUIL',array('size'=>34,'maxlength'=>34)); ?>
<?php echo $form->error($model,'CUIL'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-60">
		<?php echo $form->labelEx($model,'Domicilio'); ?>
<?php echo $form->textField($model,'Domicilio',array('size'=>80,'maxlength'=>80)); ?>
<?php echo $form->error($model,'Domicilio'); ?>
	</div>

		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'Nro'); ?>
<?php echo $form->textField($model,'Nro',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Nro'); ?>
	</div>

		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'Piso'); ?>
<?php echo $form->textField($model,'Piso',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Piso'); ?>
	</div>

		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'Dpto'); ?>
<?php echo $form->textField($model,'Dpto',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Dpto'); ?>
	</div>

		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'Localidad'); ?>
<?php echo $form->textField($model,'Localidad',array('size'=>28,'maxlength'=>28)); ?>
<?php echo $form->error($model,'Localidad'); ?>
	</div>

		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'codigo_postal'); ?>
<?php echo $form->textField($model,'codigo_postal',array('size'=>4,'maxlength'=>4)); ?>
<?php echo $form->error($model,'codigo_postal'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'provincia'); ?>
<?php echo $form->textField($model,'provincia',array('size'=>18,'maxlength'=>18)); ?>
<?php echo $form->error($model,'provincia'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Nacion'); ?>
<?php echo $form->textField($model,'Nacion',array('size'=>9,'maxlength'=>9)); ?>
<?php echo $form->error($model,'Nacion'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'codigo_area'); ?>
<?php echo $form->textField($model,'codigo_area',array('size'=>7,'maxlength'=>7)); ?>
<?php echo $form->error($model,'codigo_area'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Telefono'); ?>
<?php echo $form->textField($model,'Telefono',array('size'=>32,'maxlength'=>32)); ?>
<?php echo $form->error($model,'Telefono'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<label for="Categoria">Categoria</label>
		<?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'categoria',
					'fields' => 'Nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false ,
			) );
			?>
	</div>

	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha_Nacimiento'); ?>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Personal[Fecha_Nacimiento]',
		// 'language'=>'de',
		'value' => $model->Fecha_Nacimiento != null ? LGHelper::functions()->displayFecha($model->Fecha_Nacimiento) : '',
		'htmlOptions' => array (
			'size' => 12,
			'style' => 'width:100px !important' 
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
				'changeYear' => true 
		) 
) );
;
?>
<?php echo $form->error($model,'Fecha_Nacimiento'); ?>
	</div>
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'estado_civil'); ?>
<?php echo $form->textField($model,'estado_civil',array('size'=>12,'maxlength'=>12)); ?>
<?php echo $form->error($model,'estado_civil'); ?>
	</div>
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Numero_Libreta'); ?>
<?php echo $form->textField($model,'Numero_Libreta',array('size'=>35,'maxlength'=>35)); ?>
<?php echo $form->error($model,'Numero_Libreta'); ?>
	</div>

	</div>

	<div class="contenedor-fila">
	
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Banco_Fondo_Desempleo'); ?>
<?php echo $form->textField($model,'Banco_Fondo_Desempleo',array('size'=>16,'maxlength'=>16)); ?>
<?php echo $form->error($model,'Banco_Fondo_Desempleo'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Numero_Fondo_Desempleo'); ?>
<?php echo $form->textField($model,'Numero_Fondo_Desempleo',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'Numero_Fondo_Desempleo'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Asignacion_Familiar'); ?>
<?php echo $form->textField($model,'Asignacion_Familiar',array('size'=>3,'maxlength'=>3)); ?>
<?php echo $form->error($model,'Asignacion_Familiar'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'ObraSocial'); ?>
<?php echo $form->textField($model,'ObraSocial',array('size'=>28,'maxlength'=>28)); ?>
<?php echo $form->error($model,'ObraSocial'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Pantalon'); ?>
<?php echo $form->textField($model,'Pantalon'); ?>
<?php echo $form->error($model,'Pantalon'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Camisa'); ?>
<?php echo $form->textField($model,'Camisa'); ?>
<?php echo $form->error($model,'Camisa'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Botin'); ?>
<?php echo $form->textField($model,'Botin'); ?>
<?php echo $form->error($model,'Botin'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha_ropa'); ?>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Personal[Fecha_ropa]',
		// 'language'=>'de',
		'value' => $model->Fecha_ropa != null ? LGHelper::functions()->displayFecha($model->Fecha_ropa) : '',
		'htmlOptions' => array (
				'size' => 12,
				'style' => 'width:100px !important' 
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true,
				'changeYear' => true 
		) 
) );
;
?>
<?php echo $form->error($model,'Fecha_ropa'); ?>
	</div>

	</div>
</div>