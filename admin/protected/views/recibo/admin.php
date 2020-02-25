<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List Recibo'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('recibo-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Administrar&nbsp;Recibos</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recibo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_contrato',
		'fecha',
		'Importe',
		'Detalle',
		'id_proveedor',
		'id_obra',
		/*
		'id_recibo',
		
		'impreso',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
