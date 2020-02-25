<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Presupuesto' ),
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
				$.fn.yiiGridView.update('presupuesto-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Presupuestos</div>

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
		'id' => 'presupuesto-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				// 'id_presupuesto',
				'NumeroOrden',
				'Fecha',
				array (
						'name' => 'id_obra',
						'value' => '$data->obra->Nombre',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre ASC' 
						) ), 'id_obra', 'Nombre' ) 
				),
				array (
						'name' => 'id_proveedor',
						'value' => '$data->proveedor->Nombre',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre ASC' 
						) ), 'id_proveedor', 'Nombre' ) 
				),
				'Cantidad',
				'Detalle',
		/*
		'Detalle',
		'id_material',
		'id_atencion_venta',
		
		*/
		array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
