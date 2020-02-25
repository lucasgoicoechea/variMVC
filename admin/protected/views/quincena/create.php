<div class="titulo">
Nueva Liquidación Quincena </div>

<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quincena-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
		'form' =>$form,
		'urlOperationAction' =>$urlOperationAction,
		'urlOperationAFinalction' => $urlOperationAFinalction,
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
