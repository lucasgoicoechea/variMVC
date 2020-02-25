
<div class="titulo">
Crear nuevo Valor para la Retención/Percepción </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retencion-percepcion-valores-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_formValores', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
