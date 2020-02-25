<div class="titulo">Usuarios&nbsp;Administradores</div>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'administradores-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_form', array (
		'model' => $model,
		'form' => $form,
		'usuario' => $usuario 
) );
?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Actualizar Usuario'),array('class'=>'btn btn-primary')); ?>
</div>
<?php $this->endWidget(); ?>

</div>
<!-- form -->
