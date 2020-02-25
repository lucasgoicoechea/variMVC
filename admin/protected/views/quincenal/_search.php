<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_quincenal'); ?>
                <?php echo $form->textField($model,'id_quincenal'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'anio'); ?>
                <?php echo $form->textField($model,'anio'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'mes'); ?>
                <?php echo $form->textField($model,'mes'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'quincena'); ?>
                <?php echo $form->textField($model,'quincena'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'descripcion'); ?>
                <?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>80)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
