
<div class="titulo"> Buscar&nbsp;Empresa</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'empresa-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'codigo',
		'cuit',
		'inicio_actividad',
		'razon_social',
				array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' )
						),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
						),
						'name' => 'anulado',
						'type' => 'raw',
						'value' => '$data->isAnulado()?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
				),
			array(
					'class'=>'CButtonColumn',
			),
	),
)); ?>
