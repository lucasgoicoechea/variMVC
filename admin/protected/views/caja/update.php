<?php
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	$model->id_caja=>array('view','id'=>$model->id_caja),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List Caja', 'url'=>array('index')),
	array('label'=>'Create Caja', 'url'=>array('create')),
	array('label'=>'View Caja', 'url'=>array('view', 'id'=>$model->id_caja)),
	array('label'=>'Manage Caja', 'url'=>array('admin')),
);
?>

<h1> Update Caja #<?php echo $model->id_caja; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'caja-form',
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
