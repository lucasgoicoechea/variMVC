<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List Cuenta'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cuenta-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Administrar&nbsp;Cuentas</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cuenta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Codigo',
		'Nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
