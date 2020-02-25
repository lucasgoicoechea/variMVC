<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn ( $this->tableSchema->columns );
$label = $this->pluralize ( $this->class2name ( $this->modelClass ) );
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>


?>

<div class="titulo">Detalle de <?php echo $this->modelClass; ?> Registrado</div>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach ( $this->tableSchema->columns as $column ) {
	if ($column->isForeignKey) {
		foreach ( $this->relations as $key => $relation ) {
			if ($relation [2] == $column->name) {
				$columns = CActiveRecord::model ( $relation [1] )->tableSchema->columns;
				$suggestedfield = $this->suggestName ( $columns );
				echo "\t\t'{$key}.{$suggestedfield->name}',\n";
			}
		}
	} else
		echo "\t\t'" . $column->name . "',\n";
}
?>
	),
)); ?>
<div class="row-center">
<?php	printf ( "<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?>");
?>
</div>

<?php
/*foreach ( CActiveRecord::model ( $this->model )->relations () as $key => $relation ) {
	if ($relation [0] == 'CManyManyRelation' || $relation [0] == 'CHasManyRelation') {
		$columns = CActiveRecord::model ( $relation [1] )->tableSchema->columns;
		
		$suggestedtitle = $this->suggestName ( $columns );
		
		printf ( "<br /><h2> This %s belongs to this %s: </h2>\n", $relation [1], $this->modelClass );
		echo CHtml::openTag ( 'ul' );
		printf ( "<?php foreach(\$model->%s as \$foreignobj) { \n
				printf('<li>%%s</li>', CHtml::link(\$foreignobj->%s, array('%s/view', 'id' => \$foreignobj->id)));\n
				} ?>", $key, $suggestedtitle->name, strtolower ( $relation [1] ) );
		echo CHtml::closeTag ( 'ul' );
	}
}*/
?>
