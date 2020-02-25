<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_ingreso'); ?>
                <?php echo $form->textField($model,'id_ingreso'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
