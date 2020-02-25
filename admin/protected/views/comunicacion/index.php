<?php
$this->breadcrumbs = array(
	'Comunicacions',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Comunicacion', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Comunicacion', 'url'=>array('admin')),
);
?>

<h1>Comunicacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
