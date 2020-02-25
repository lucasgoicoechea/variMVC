<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_comunicacion'); ?>
                <?php echo $form->textField($model,'id_comunicacion'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'mensaje'); ?>
                <?php echo $form->textField($model,'mensaje',array('size'=>60,'maxlength'=>360)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_userslogin_origen'); ?>
                <?php echo $form->textField($model,'id_userslogin_origen'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_userslogin_destino'); ?>
                <?php echo $form->textField($model,'id_userslogin_destino'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'leido'); ?>
                <?php echo $form->checkBox($model,'leido'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
