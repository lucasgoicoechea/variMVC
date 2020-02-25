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
                <?php echo $form->label($model,'codigo_dominio'); ?>
                <?php echo $form->textField($model,'codigo_dominio'); ?>
        </div>

	<div class="row">
                <?php echo $form->label($model,'descripcion'); ?>
                <?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>255)); ?>
        </div>

	<div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
