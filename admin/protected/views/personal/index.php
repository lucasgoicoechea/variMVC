<?php
$this->breadcrumbs = array(
	'Personals',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Personal', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Personal', 'url'=>array('admin')),
);
?>

<h1>Personals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
