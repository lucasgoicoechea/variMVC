<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List RetencionPercepcion'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('retencion-percepcion-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Administrar&nbsp;Retenciones/Percepciones</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'retencion-percepcion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id_retencion_percepcion',
		'descripcion',
								array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
								),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
								),
						'name' => 'es_porcentaje',
						'type' => 'raw',
						'value' => '$data->es_porcentaje?"Si":"No"' 
						),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
