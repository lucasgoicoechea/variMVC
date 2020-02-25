<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<div class="contenedor-tabla">

<?php
echo '<div class="contenedor-fila">';
echo "<div class='contenedor-columna-30'>  \t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
echo "</div>";
echo "</div>";
$count = 0;
foreach ( $this->tableSchema->columns as $column ) {
	if ($column->isPrimaryKey)
		continue;
	echo '<div class="contenedor-fila">';
	echo "<div class='contenedor-columna-30'>";
	if (++ $count == 7)
		echo "\t<?php /*\n";
	echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
	echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
	echo "</div>";
	echo "</div>";
}
if ($count >= 7)
	echo "\t*/ ?>\n";
?>

</div>
