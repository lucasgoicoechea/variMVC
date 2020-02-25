<?php
$this->breadcrumbs=array(
	'Comunicacions'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List Comunicacion', 'url'=>array('index')),
	array('label'=>'Manage Comunicacion', 'url'=>array('admin')),
);
?>

<div class="titulo"> Crear una comunicación interna</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comunicacion-form',
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
