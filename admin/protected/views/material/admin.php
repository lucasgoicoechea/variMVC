<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List Material'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('material-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Administrar&nbsp;Materials</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'material-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_material',
		'Codigo',
		'Nombre',
		'Costo',
		'id_rubro',
		'id_subrubro',
		/*
		'Observaciones',
		'Medida',
		'Fecha',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
