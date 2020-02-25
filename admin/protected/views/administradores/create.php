<?php
$this->breadcrumbs = array (
		'Administradores' => array (
				Yii::t ( 'app', 'index' ) 
		),
		Yii::t ( 'app', 'Create' ) 
);
?>


<div class="titulo">Crear nuevo</div>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'administradores-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_form', array (
		'model' => $model,
		'form' => $form,
		'usuario'  => $usuario
) );
?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Crear Usuario'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
