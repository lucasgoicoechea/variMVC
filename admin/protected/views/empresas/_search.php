<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_empresa'); ?>
                <?php echo $form->textField($model,'id_empresa'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'nombre'); ?>
                <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'codigo'); ?>
                <?php echo $form->textField($model,'codigo',array('size'=>6,'maxlength'=>6)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'cuit'); ?>
                <?php echo $form->textField($model,'cuit'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'inicio_actividad'); ?>
                <?php echo $form->textField($model,'inicio_actividad'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'razon_social'); ?>
                <?php echo $form->textField($model,'razon_social',array('size'=>60,'maxlength'=>200)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
