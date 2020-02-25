<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

<div class="contenedor-tabla">
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
                <?php echo $form->label($model,'id_cuenta'); ?>
                <?php echo $form->textField($model,'id_cuenta'); ?>
        </div></div>
<div class="contenedor-fila">
       <div class='contenedor-columna-30'>
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo'); ?>
        </div>
</div>
     <div class="contenedor-fila">
       <div class='contenedor-columna-30'>
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>40,'maxlength'=>40)); ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div></div>
</div>
<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
