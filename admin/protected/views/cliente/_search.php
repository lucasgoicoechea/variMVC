<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
 <div class="contenedor-tabla">


        <div class="contenedor-fila">
                <?php echo $form->label($model,'codigo'); ?>
                <?php echo $form->textField($model,'codigo'); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'nombre'); ?>
                <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>62)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'telefono'); ?>
                <?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'fax'); ?>
                <?php echo $form->textField($model,'fax',array('size'=>60,'maxlength'=>100)); ?>
        </div>

          <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>
</div>
<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
