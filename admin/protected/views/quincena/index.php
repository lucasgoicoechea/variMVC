<?php
$this->breadcrumbs = array(
	'Quincenas',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Quincena', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Quincena', 'url'=>array('admin')),
);
?>

<h1>Quincenas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
