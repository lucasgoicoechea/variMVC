
<div class="titulo">
Crear nuevo RetencionPercepcion </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retencion-percepcion-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear y agregar Valores'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
