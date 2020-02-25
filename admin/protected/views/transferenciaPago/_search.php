<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_transferencia_pago'); ?>
                <?php echo $form->textField($model,'id_transferencia_pago'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_cuenta_banco'); ?>
                <?php echo $form->textField($model,'id_cuenta_banco'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'referencia'); ?>
                <?php echo $form->textField($model,'referencia',array('size'=>60,'maxlength'=>60)); ?>
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
                <?php echo $form->label($model,'cbu_destino'); ?>
                <?php echo $form->textField($model,'cbu_destino',array('size'=>60,'maxlength'=>60)); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_pago'); ?>
                <?php echo $form->textField($model,'id_pago'); ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
