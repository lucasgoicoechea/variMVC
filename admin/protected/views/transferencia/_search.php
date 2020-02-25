<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_transferencia'); ?>
                <?php echo $form->textField($model,'id_transferencia'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_cuenta_origen'); ?>
                <?php echo $form->textField($model,'id_cuenta_origen'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_cuenta_destino'); ?>
                <?php echo $form->textField($model,'id_cuenta_destino'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'importe'); ?>
                <?php echo $form->textField($model,'importe',array('size'=>10,'maxlength'=>10)); ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
