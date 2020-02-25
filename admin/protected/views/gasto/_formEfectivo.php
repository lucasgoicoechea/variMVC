
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'monto'); ?>
	
<?php echo CHtml::activeTextField($model,'monto',array('size'=>20,'maxlength'=>12,'id'=>'EfectivoPago_Monto2')); ?>
<?php echo CHtml::error($model,'monto'); ?>
	</div>
		<div class="contenedor-columna-60">
		<label>Detalle</label>
<?php echo CHtml::activeTextField($model,'detalle',array('size'=>40,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'detalle'); ?>
	</div>
	
		
	</div>

</div>
