
<div class="titulo">
Crear nuevo Sub-Contrato </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contrato-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form,
		'update'=>false
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
