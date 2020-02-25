<div class="wide form">

<?php

echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl(\$this->route),
        'method'=>'get',
)); ?>\n";
?>
<div class="contenedor-tabla">


<?php foreach($this->tableSchema->columns as $column): ?>
<?php

	$field = $this->generateInputField ( $this->modelClass, $column );
	if (strpos ( $field, 'password' ) !== false)
		continue;
	?>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
                <?php echo "<?php ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
        </div>
    </div>
<?php endforeach; ?>
        <div class="row-center">
                <?php echo "<?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>\n"; ?>
        </div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div>
</div>
<!-- search-form -->
