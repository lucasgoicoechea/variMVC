
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
				<div class="contenedor-columna-20">
		<label>Código</label>
<?php echo $form->textField($model,'id_transferencia',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'id_transferencia'); ?>
	</div>
	
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'fecha',array('readonly'=>true)); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				// 'model'=>'$model',
				'name' => 'Transferencia[fecha]',
				'language'=>'es',
				'value' => $model->fecha != null ? LGHelper::functions()->displayFecha($model->fecha) : LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
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
<?php echo CHtml::error($model,'fecha'); ?>
	</div>
	
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'importe'); ?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
		'element'=>'#Transferencia_importe',
		'currency'=>'PHP',
		'config'=>array(
				'symbolStay'=>true,
				'thousands'=>'.',
				'decimal'=>',',
				'precision'=>2,
		)
));
echo $form->textField($model,'importe',['id'=>'Transferencia_importe']); 
?>
<?php echo $form->error($model,'importe'); ?>
	</div>
			
<div class="contenedor-columna">
<label for="Cuenta">Cuenta Origen</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cuentaOrigen',
							'fields' => 'descripcion',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
			<div class="contenedor-columna">
<label for="Cuenta">Cuenta Destino</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cuentaDestino',
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
<?php echo $form->textArea($model,'descripcion',array( 'style'=>'width: 752px; height: 87px;','size'=>140,'maxlength'=>250,
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;'));
?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>
</div>
