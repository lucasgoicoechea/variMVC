<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_retencion_percepcion_valores'); ?>
                <?php echo $form->textField($model,'id_retencion_percepcion_valores'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_retencion_percepcion'); ?>
                <?php echo $form->textField($model,'id_retencion_percepcion'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'valor'); ?>
                <?php echo $form->textField($model,'valor'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'usuario_log'); ?>
                <?php echo $form->textField($model,'usuario_log',array('size'=>60,'maxlength'=>60)); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'fecha_log'); ?>
                <?php echo $form->textField($model,'fecha_log'); ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
