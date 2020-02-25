
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">

		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'monto'); ?>
<?php echo CHtml::activeTextField($model,'monto',array('size'=>10,'maxlength'=>10)); ?>
<?php echo CHtml::error($model,'monto'); ?>
	</div>
		<div class="contenedor-columna">
			<label for="Tarjeta">Tarjeta</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'tarjeta',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
	</div>
		<div class="contenedor-columna-20">
			<label>Fecha Pago</label>
				<?php
				$fechaV = $model->fecha_pago != null ? $model->fecha_pago : CTimestamp::formatDate ( 'Y-m-d' );
				$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
						'model' => '$model',
						'name' => 'TarjetaPago[fecha_pago]',
						'language'=>'es',
						'value' => LGHelper::functions()->displayFecha($fechaV),
						'htmlOptions' => array (
								'size' => 10,
								'style' => 'width:100px !important' 
						),
						'options' => array (
								'showButtonPanel' => true,
								'changeYear' => true,
								'changeYear' => true, 
						) 
				) );
				
				?>
<?php echo CHtml::error($model,'fecha_pago'); ?>
	</div>
	</div>
	<div class="contenedor-fila">

		<div class="contenedor-columna-80">
			<label>Detalle</label>
<?php echo CHtml::activeTextField($model,'detalle',array('size'=>40,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'detalle'); ?>
	</div>


	</div>

</div>
