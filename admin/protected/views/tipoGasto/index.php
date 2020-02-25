<?php
$this->breadcrumbs = array(
	'Tipo Gastos',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' TipoGasto', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' TipoGasto', 'url'=>array('admin')),
);
?>

<h1>Tipo Gastos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
