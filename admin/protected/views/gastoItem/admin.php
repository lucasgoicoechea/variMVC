
<div class="titulo"> Lista de Detalles</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gasto-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_gasto_item',
		'cantidad',
		'consumido',
		'valor_unidad',
		'valor_final',
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
			array(
					'class'=>'CButtonColumn',
			),
	),
)); ?>
