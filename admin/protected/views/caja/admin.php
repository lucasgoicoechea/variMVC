<?php
$this->breadcrumbs=array(
	'Cajas'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Caja'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Caja'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('caja-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Cajas</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'caja-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_caja',
		'codigo',
array (
		'header' => 'Fecha',
		//'name' => 'tipoAdmin.descripcion',
		'value' => 'LGHelper::functions()->displayFecha($data->fecha)',
		'headerHtmlOptions' => array (
				//'style' => 'width:80px'
		)
),
		'numero',
		'importe',
		'id_cuenta',
		/*
		'cerrada',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
