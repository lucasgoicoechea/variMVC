<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>


<div class="contenedor-tabla">

<div class="contenedor-fila">
       <div class='contenedor-columna-30'>
                <?php echo $form->label($model,'codigo'); ?>
                <?php echo $form->textField($model,'codigo'); ?>
        </div>
</div>

<div class="contenedor-fila">
       <div class='contenedor-columna-30'>
                <?php echo $form->label($model,'nombre'); ?>
                <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60)); ?>
        </div>
</div>
   
<div class="contenedor-fila">
       <div class='contenedor-columna-30'>
                <?php echo $form->label($model,'numero_cuenta'); ?>
                <?php echo $form->textField($model,'numero_cuenta',array('size'=>60,'maxlength'=>60)); ?>
        </div>
</div>


        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
