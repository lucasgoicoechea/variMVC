<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List Cliente'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cliente-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Administrar&nbsp;Clientes</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cliente-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'nombre',
		'telefono',
		'fax',
			'responsable',
		//'id_localidad',
		/*
		'id_moneda',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
