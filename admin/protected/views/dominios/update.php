<?php
$this->breadcrumbs = array (
		'Dominioses' => array (
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
				'label' => 'List Dominios',
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => 'Create Dominios',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => 'View Dominios',
				'url' => array (
						'view',
						'id' => $model->id 
				) 
		),
		array (
				'label' => 'Manage Dominios',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1> Update Dominios #<?php echo $model->id; ?> </h1>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'dominios-form',
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
