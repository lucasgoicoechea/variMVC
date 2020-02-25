<?php
$this->breadcrumbs = array(
	'Cajas',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Caja', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Caja', 'url'=>array('admin')),
);
?>

<h1>Cajas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
