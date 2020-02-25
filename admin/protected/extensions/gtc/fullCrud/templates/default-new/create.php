
<div class="titulo">
<?php
printf ( '%s %s ', Yii::t ( 'app', 'Crear nuevo' ), $this->modelClass );
?>
</div>

<div class="form">

<?php

echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'" . $this->class2id ( $this->modelClass ) . "-form',
	'enableAjaxValidation'=>true,
)); \n";

echo "echo \$this->renderPartial('_form', array(
	'model'=>\$model,
	'form' =>\$form
	)); ?>\n";
?>

<div class="row-center">
	<?php echo "<?php echo CHtml::submitButton(Yii::t('app', 'Crear'),array('class'=>'btn btn-primary')); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div>
