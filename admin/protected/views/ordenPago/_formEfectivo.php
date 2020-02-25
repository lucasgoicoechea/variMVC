
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabelEx($model,'monto'); ?>
	<?php
	//	$model->monto = $this->monto==null?0.00:LGHelper::functions()->formatNumber($model->monto);
		    $this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#EfectivoPago_Monto2,#TarjetaPago_Monto,#Cheque_Importe,#TransferenciaPago_Monto',
                    'currency'=>'PHP',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>'.',
                        'decimal'=>',',
                        'precision'=>2,
                    )
                ));
		?>
<?php echo CHtml::activeTextField($model,'monto',array('size'=>20,'maxlength'=>12,'id'=>'EfectivoPago_Monto2')); ?>
	</div>
		<div class="contenedor-columna-60">
		<label>Detalle</label>
<?php echo CHtml::activeTextField($model,'detalle',array('size'=>40,'maxlength'=>60)); ?>
<?php echo CHtml::error($model,'detalle'); ?>
	</div>
	
		
	</div>

</div>
