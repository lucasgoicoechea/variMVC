<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = ' Nueva contraseña ';
$this->breadcrumbs = array (
		'Nueva Contraseña' 
);
?>

<h1>Ingrese sus datos requeridos</h1>


<div class="form">
<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'reactivacion-form',
		'enableClientValidation' => false,
		'clientOptions' => array (
				'validateOnSubmit' => false 
		) 
) );
?>
 <?php if (!$reactivacion){?>
	<div>
		Usuario (en algún caso puede ser DNI)
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
<?php } else {?>
	<div>
		Password
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div>
		Reingrese password
		<?php echo $form->passwordField($model,'new_password'); ?>
		<?php echo $form->error($model,'new_password'); ?>
	</div>
<?php }?>

	<div class="buttons row-center">
		<?php echo CHtml::submitButton('Enviar',array("class"=>"btn btn-primary btn-large")); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->
