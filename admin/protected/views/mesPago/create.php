

<h3 class="titulo"> Crear Mes de Pago</h3>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mes-pago-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary btn-large')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
