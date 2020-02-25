<p class="note">
	Fields with <span class="required">*</span> are required.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
<?php echo $form->textField($model,'codigo'); ?>
<?php echo $form->error($model,'codigo'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Caja[fecha]',
								 //'language'=>'de',
								 'value'=>$model->fecha,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'fecha'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
<?php echo $form->textField($model,'numero',array('size'=>40,'maxlength'=>40)); ?>
<?php echo $form->error($model,'numero'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'importe'); ?>
<?php echo $form->textField($model,'importe',array('size'=>12,'maxlength'=>12)); ?>
<?php echo $form->error($model,'importe'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'id_cuenta'); ?>
<?php echo $form->textField($model,'id_cuenta'); ?>
<?php echo $form->error($model,'id_cuenta'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'cerrada'); ?>
<?php echo $form->checkBox($model,'cerrada'); ?>
<?php echo $form->error($model,'cerrada'); ?>
	</div>


