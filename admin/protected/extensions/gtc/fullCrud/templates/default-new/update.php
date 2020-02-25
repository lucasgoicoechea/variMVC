<?php
echo "<?php\n";
?>


?>

<?php
$pk = "\$model->" . $this->tableSchema->primaryKey;
printf ( '<h1> %s %s #%s </h1>', Yii::t ( 'app', 'Guardar' ), $this->modelClass, '<?php echo ' . $pk . '; ?>' );
?>

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
	<?php echo "<?php echo CHtml::submitButton(Yii::t('app', 'Guardar'),array('class'=>'btn btn-primary')); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div>
<!-- form -->
