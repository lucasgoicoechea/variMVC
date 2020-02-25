
<div class="titulo">Crear nueva Cuenta Banco </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cuenta-banco-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
