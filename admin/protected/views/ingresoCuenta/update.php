<?php


?>

<div class="titulo">Editar datos del Ingreso a Cuenta</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ingreso-cuenta-form',
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
