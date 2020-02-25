<?php
$this->breadcrumbs = array (
		'Accesoses' => array (
				'index' 
		),
		$model->id => array (
				'view',
				'id' => $model->id 
		),
		Yii::t ( 'app', 'Update' ) 
);

$this->menu = array (
		array (
				'label' => 'List Accesos',
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => 'Create Accesos',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => 'View Accesos',
				'url' => array (
						'view',
						'id' => $model->id 
				) 
		),
		array (
				'label' => 'Manage Accesos',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1> Update Accesos #<?php echo $model->id; ?> </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->
