<?php
$this->breadcrumbs = array(
	'Mes Pagos',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' MesPago', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' MesPago', 'url'=>array('admin')),
);
?>

<h1>Mes Pagos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
