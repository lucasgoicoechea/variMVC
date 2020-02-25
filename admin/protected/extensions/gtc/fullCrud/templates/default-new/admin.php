<?php echo '<?php     '; ?>
$this->menu=array(
		array('label'=>Yii::t('app',
				'List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> <?php
echo Yii::t ( 'app', 'Administrar' ) . '&nbsp;';
echo $this->pluralize ( $this->class2name ( $this->modelClass ) );
?></div>

<?php echo "<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display: none">
<?php

echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n";
?>
</div>

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count = 0;
foreach ( $this->tableSchema->columns as $column ) {
	if (++ $count == 7)
		echo "\t\t/*\n";
	echo "\t\t'" . $column->name . "',\n";
}
if ($count >= 7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
