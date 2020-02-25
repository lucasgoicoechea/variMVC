<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_presupuesto'); ?>
                <?php echo $form->textField($model,'id_presupuesto'); ?>
       
                <?php echo $form->label($model,'NumeroOrden'); ?>
                <?php echo $form->textField($model,'NumeroOrden'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php echo $form->textField($model,'Fecha'); ?>
       
                <?php echo $form->label($model,'Cantidad'); ?>
                <?php echo $form->textField($model,'Cantidad',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Detalle'); ?>
                <?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>154)); ?>
        </div>

         <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
