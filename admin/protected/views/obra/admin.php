<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Obra' ),
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
				$.fn.yiiGridView.update('obra-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Obras</div>

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
		'id' => 'obra-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '40' 
						) 
				),
				'Nombre',
				'Direccion',
				'Localidad',
				/*array (
						'name' => 'id_tipo_obra',
						'value' => '$data->tipoObra->nombre',
						'filter' => CHtml::listData ( TipoObra::model ()->findAll (), 'id_tipo_obra', 'nombre' ) 
				),*/
array (
						'name' => 'id_cliente',
						'value' => '$data->cliente->nombre',
						'filter' => CHtml::listData ( Cliente::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cliente', 'descripcion' ) 
				),
		/*
		'Monto',
		'FechaInicio',
		'FechaFin',
		'Justiprecio',
		'Avance',
		'Detalles',
		'id_cliente',
				*/
		array (
						'class' => 'CButtonColumn',
						'template' => '{update}{view}' 
				) 
		) 
)
 );
?>
