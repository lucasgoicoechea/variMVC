<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_efectivo_pago'); ?>
                <?php echo $form->textField($model,'id_efectivo_pago'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_pago'); ?>
                <?php echo $form->textField($model,'id_pago'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'monto'); ?>
                <?php echo $form->textField($model,'monto',array('size'=>10,'maxlength'=>10)); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'detalle'); ?>
                <?php echo $form->textField($model,'detalle',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
