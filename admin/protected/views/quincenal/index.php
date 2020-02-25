<?php
$this->breadcrumbs = array(
	'Quincenals',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Quincenal', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Quincenal', 'url'=>array('admin')),
);
?>

<h1>Quincenals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
