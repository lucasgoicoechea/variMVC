
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'serie'); ?>
<?php echo $form->textField($model,'serie',array('size'=>10,'maxlength'=>110,
			'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;'));?>
<?php echo $form->error($model,'serie'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Numero'); ?>
<?php echo $form->textField($model,'Numero',array('size'=>20,'maxlength'=>110)); ?>
<?php echo $form->error($model,'Numero'); ?>
	</div>
		<div class="contenedor-columna">
			<label for="CuentaBanco">Cuenta Banco</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'cuentaBanco',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label>A la Orden de:</label>
<?php echo $form->textField($model,'a_la_orden',array('size'=>40,'maxlength'=>110)); ?>
<?php echo $form->error($model,'a_la_orden'); ?>
	</div>
		<div class="contenedor-columna-20">
			<label>Porcentaje impuesto al Debito:</label>
<?php echo $form->textField($model,'porc_impuesto_debito',array('size'=>10,'maxlength'=>110)); ?>
<?php echo $form->error($model,'porc_impuesto_debito'); ?>
			</div>
		<div class="contenedor-columna-20">
			<label>Porcentaje impuesto al Cheque:</label>
<?php echo $form->textField($model,'porc_impuesto_cheque',array('size'=>10,'maxlength'=>110)); ?>
<?php echo $form->error($model,'porc_impuesto_cheque'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'FechaEmision'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Cheque[FechaEmision]',
				'language' => 'es',
				'value' => $model->FechaEmision != null ? LGHelper::functions()->displayFecha($model->FechaEmision) : '',
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
<?php echo $form->error($model,'FechaEmision'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'FechaPago'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Cheque[FechaPago]',
				'language' => 'es',
				'value' => $model->FechaPago != null ? LGHelper::functions()->displayFecha($model->FechaPago) : '',
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
<?php echo $form->error($model,'FechaPago'); ?>
	</div>

	</div>
</div>
