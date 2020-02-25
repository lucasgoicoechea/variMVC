<?php


?>

<div class="titulo">
Modificar datos de la Orden de Compra </div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orden-compra-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form, 
		'update' => true
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->
