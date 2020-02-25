<?php

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Tarjeta' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
				'url' => array (
						'create' 
				) 
		) 
);

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('tarjeta-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Tarjetas</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'tarjeta-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				// 'id_tarjeta',
				'numero',
				'titular',
				array (
						'header' => 'Tipo Tarjeta',
						'name' => 'id_tipo_tarjeta',
						'value' => '$data->tipoTarjeta->descripcion',
						'filter' => CHtml::listData ( TipoTarjeta::model ()->findAll ( array (
								'order' => 'descripcion' 
						) ), 'id_tipo_tarjeta', 'descripcion' ) 
				),
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
