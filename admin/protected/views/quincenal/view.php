<?php

$this->menu=array(
	array('label'=>'Cargar Liquidación Quincena', 'url'=>array('quincena/create')),
	array('label'=>'Modificar Quincena', 'url'=>array('update', 'id'=>$model->id_quincenal)),
	array('label'=>'Ver Quincenas anteriores', 'url'=>array('admin')),
);
?>
<div class="titulo"> Quincena </div>

<?php 
$modeli= $model;
$model = new Quincenal();
$model->anio = null;
$model->mes = null;
$model->quincena=null;
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$modeli,
	'attributes'=>array(
		array (
			'name' => 'Codigo',
			'value' => $modeli->id_quincenal,
			'htmlOptions' => array (
					'style' => 'width: 3px'
			),		
			'headerHtmlOptions' => array (
				'style' => 'width: 3px'
		)
	),array (
		'name' => 'Año',
		'value'=> $modeli->anio,
		'htmlOptions' => array (
				'style' => 'width: 3px'
		),		
		'headerHtmlOptions' => array (
			'style' => 'width: 3px'
	)
),

array (
	'name' => 'Mes',
	'value' => LGHelper::functions ()->getMonthLabel ( $modeli->mes),
	'htmlOptions' => array (
			'width' => '10'
	)
) ,

array (
	'name' => 'quincena',
	'value' => $modeli->quincena==1?"PRIMERA":"SEGUNDA",
	'htmlOptions' => array (
			'width' => '10'
	)
) ,
		
		'descripcion',

	),
)); ?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quincenal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		array (
			'name' => 'id_quincenal',
			'header' => 'Codigo',
			'htmlOptions' => array (
					'style' => 'width: 3px'
			),		
			'headerHtmlOptions' => array (
				'style' => 'width: 3px'
		)
	),array (
		'name' => 'anio',
		'header' => 'Año',
		'htmlOptions' => array (
				'style' => 'width: 3px'
		),		
		'headerHtmlOptions' => array (
			'style' => 'width: 3px'
	)
),
array (
	'name' => 'mes',
	'header' => 'Mes',
	'value' => 'LGHelper::functions ()->getMonthLabel ( $data->mes)',
	'htmlOptions' => array (
			'width' => '10'
	)
) ,

array (
	'name' => 'quincena',
	'header' => 'Quincena',
	'value' => '$data->quincena==1?"PRIMERA":"SEGUNDA"',
	'htmlOptions' => array (
			'width' => '10'
	)
) ,
		
		'descripcion',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{update}{quincenas}',
			'buttons' => array (
				'quincenas' => array (
						'label' => 'Ver Quincenas Personal',
						'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
						'url' => '$data->getUrlQuincenas()',
						'visible' => 'true',
						'options' => array (
								'target' => '_blank' 
								)
								),
			)

		),
	),
)); ?>
