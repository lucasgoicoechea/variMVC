<?php
$this->breadcrumbs = array (
		'Accesoses' => array (
				Yii::t ( 'app', 'index' ) 
		),
		Yii::t ( 'app', 'Create' ) 
);
?>


<h1>Create Accesos</h1>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'accesos-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_form', array (
		'model' => $model,
		'form' => $form 
) );
?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Create'),array('class'=>'btn btn-primary btn-large')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
