
<div class="titulo">
Registrar Orden de Pago </div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pago-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Agregar Comprobantes y Medios'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
