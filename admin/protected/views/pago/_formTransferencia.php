
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
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
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'monto'); ?>
<?php echo CHtml::activeTextField($model,'monto',array('size'=>10,'maxlength'=>10)); ?>
<?php echo CHtml::error($model,'monto'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-60">
		<label>CBU Destino</label>
<?php echo CHtml::activeTextField($model,'cbu_destino',array('size'=>40,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'cbu_destino'); ?>
	</div>
	
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'referencia'); ?>
<?php echo CHtml::activeTextField($model,'referencia',array('size'=>20,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'referencia'); ?>
	</div>
	</div>

</div>
