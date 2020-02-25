<?php
$this->breadcrumbs=array(
	'Comunicacions'=>array('index'),
	$model->id_comunicacion=>array('view','id'=>$model->id_comunicacion),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List Comunicacion', 'url'=>array('index')),
	array('label'=>'Create Comunicacion', 'url'=>array('create')),
	array('label'=>'View Comunicacion', 'url'=>array('view', 'id'=>$model->id_comunicacion)),
	array('label'=>'Manage Comunicacion', 'url'=>array('admin')),
);
?>

<h1> Update Comunicacion #<?php echo $model->id_comunicacion; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comunicacion-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->
