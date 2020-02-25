
<div class="titulo">
Crear nuevo PagoCheque </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pago-cheque-form',
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
