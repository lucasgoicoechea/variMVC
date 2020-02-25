<?php
$this->breadcrumbs=array(
	'Mes Pagos'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List MesPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create MesPago'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('mes-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Manage&nbsp;Mes Pagos</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mes-pago-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'porcentage_rectorado',
		'porcentage_facultad',
		'fecha_pago',
		'numero',
		'id_conv_individual',
		/*
		'pagado',
		'id_forma_pago',
		'asignacion',
		'mes_periodo',
		'ano_periodo',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
