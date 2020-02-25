<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'nombre'); ?>
                <?php echo $form->textField($model,'nombre',array('size'=>50,'maxlength'=>50)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_tipo_gasto'); ?>
                <?php echo $form->textField($model,'id_tipo_gasto'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'codigo'); ?>
                <?php echo $form->textField($model,'codigo',array('size'=>11,'maxlength'=>11)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'usuario_log'); ?>
                <?php echo $form->textField($model,'usuario_log',array('size'=>60,'maxlength'=>60)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'fecha_log'); ?>
                <?php echo $form->textField($model,'fecha_log'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
