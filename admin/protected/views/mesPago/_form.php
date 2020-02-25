
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
	<div style="font-size: 12px" class="titulo">Datos Generales</div>
		
	<div class="contenedor-fila">
	        <label>ALUMNO: </label>
			<div class="contenedor-columna">
			<?php $conveee = ConvenioIndividual::model()->findByPk($model->id_conv_individual);
			echo isset($conveee)?$conveee->alumno:'SIN CONVENIO INDIVIDUAL';?>
			</div>
	</div>		
	<div class="contenedor-fila">
			<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'asignacion'); ?>
<?php echo $form->textField($model,'asignacion'); ?>
<?php echo $form->error($model,'asignacion'); ?>
	</div>
		<div class="contenedor-columna-30">
		<label>Monto Presidencia</label>
<?php echo $form->textField($model,'porcentage_rectorado'); ?>
<?php echo $form->error($model,'porcentage_rectorado'); ?>
	</div>
			<div class="contenedor-columna-30">
<label>Monto Facultad</label>
			<?php echo $form->textField($model,'porcentage_facultad'); ?>
<?php echo $form->error($model,'porcentage_facultad'); ?>
	</div>
	</div>



	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'fecha_pago'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'MesPago[fecha_pago]',
								 //'language'=>'de',
								 'value'=>$model->fecha_pago,
					'options' => array ( 
       								'showButtonPanel' => true,
									'changeYear' => true,
									'changeYear' => true,
									'showAnim'=>'fold', 
							        'dateFormat'=>'yy-mm-dd' )  ,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
								 )
							 );
					; ?>
<?php echo $form->error($model,'fecha_pago'); ?>
	</div>
	<div class="contenedor-columna-40">
<label for="FormaPago">Forma de Pago</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'formaPago',
							'fields' => 'descripcion',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>
		<div class="contenedor-columna-30">
	<label>Nro. de Cheque</label>
<?php echo $form->textField($model,'numero',array('size'=>25,'maxlength'=>45)); ?>
<?php echo $form->error($model,'numero'); ?>
	</div>
	</div>

<?php echo $form->hiddenField($model,'id_conv_individual',array('size'=>20,'maxlength'=>20)); ?>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'pagado'); ?>
<?php echo $form->checkBox($model,'pagado'); ?>
<?php echo $form->error($model,'pagado'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'mes_periodo'); ?>
		<?php echo CHtml::activeDropDownList($model,'mes_periodo',LGHelper::functions()->getMonths(),array('style'=>"width:100px")); ?>
<?php echo $form->error($model,'mes_periodo'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'ano_periodo'); ?>
<?php echo CHtml::activeDropDownList($model,'ano_periodo',LGHelper::functions()->getYears(),array('style'=>"width:100px")); ?>
<?php echo $form->error($model,'ano_periodo'); ?>
	</div>
	</div>


<?php echo $form->hiddenField($model,'id_forma_pago',array('size'=>20,'maxlength'=>20)); ?>

</div>
