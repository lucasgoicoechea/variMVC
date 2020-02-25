<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'users-form',
		'enableAjaxValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true 
		) 
) );
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-error')); ?>
    <div class="row-fluid">
		<div class="span6">
			<legend>Usuario</legend>

			<div>
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div>
				<?php
				if (! $model->isNewRecord) {
					echo $form->hiddenField ( $model, 'password', array (
							'type' => "hidden" 
					) );
				} else {
					echo $form->labelEx ( $model, 'password' );
					echo $form->textField ( $model, 'password', array (
							'size' => 60,
							'maxlength' => 128 
					) );
					echo $form->error ( $model, 'password' );
				}
				?>
			</div>
		</div>
	</div>
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-large')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->