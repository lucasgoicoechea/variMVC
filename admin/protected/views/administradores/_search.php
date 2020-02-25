<div class="wide form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( $this->route ),
		'method' => 'get' 
) );
?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'usuario'); ?>
                <?php echo $form->textField($model,'usuario',array('size'=>20,'maxlength'=>20)); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'clave'); ?>
                <?php echo $form->textField($model,'clave',array('size'=>20,'maxlength'=>20)); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'nombre'); ?>
                <?php echo $form->textField($model,'nombre',array('size'=>35,'maxlength'=>35)); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'apellido'); ?>
                <?php echo $form->textField($model,'apellido',array('size'=>35,'maxlength'=>35)); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'idTipo'); ?>
                <?php echo $form->textField($model,'idTipo',array('size'=>20,'maxlength'=>20)); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'verEntrevista'); ?>
                <?php echo $form->textField($model,'verEntrevista'); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'id_userslogin'); ?>
                <?php echo $form->textField($model,'id_userslogin'); ?>
        </div>

	<div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
