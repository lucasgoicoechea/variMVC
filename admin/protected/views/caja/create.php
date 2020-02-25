<div class=""> Crear Caja </div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'caja-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Create'),array('class'=>'btn')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
