


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cobro-form',
	'enableAjaxValidation'=>true,
)); 
if ($cobrado){
echo $this->renderPartial('_formCobrado', array(
	'model'=>$model,
	'form' =>$form,
		'update'=>false
	)); 
} else {
	echo $this->renderPartial('_form', array(
		'model'=>$model,
		'form' =>$form,
		'update'=>false
));
}
?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
