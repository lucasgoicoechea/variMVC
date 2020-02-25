<?php

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Contrato' ),
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
				$.fn.yiiGridView.update('contrato-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Contratos</div>

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
		'id' => 'contrato-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				'codigo',
				array (
						'header' => 'Proveedor(Telefono)',
						'name' => 'id_proveedor',
						'value' => '$data->getProveedorDescripcion()',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_proveedor', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra!=null?$data->obra->getDescripcion():""',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				'Fecha',
				'Descripcion',
				'Precio',
				'Plazo',
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
