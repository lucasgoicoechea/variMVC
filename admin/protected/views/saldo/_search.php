<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_cuenta'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'SaldoBanco'); ?>
                <?php echo $form->textField($model,'SaldoBanco',array('size'=>12,'maxlength'=>12)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'SaldoEfectivo'); ?>
                <?php echo $form->textField($model,'SaldoEfectivo',array('size'=>12,'maxlength'=>12)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php echo $form->textField($model,'Fecha'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Hora'); ?>
                <?php echo $form->textField($model,'Hora'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_saldos'); ?>
                <?php echo $form->textField($model,'id_saldos'); ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
