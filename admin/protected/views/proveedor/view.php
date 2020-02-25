<div  class="titulo">Detalle datos del Proveedor registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array (
						'name' => 'Codigo',
						'value' => $model->id_proveedor
				),
		'Nombre',
		'Telefono',
			'telefono_dos',
			'telefono_tres',
			'telefono_cuatro',
		'Celular',
		'Fax',
		'Direccion',
		'Contacto',
		'Cuit',
		'E_Mail',
			array (
					'name' => 'Tipo Gasto',
					'value' => $model->tipoGasto->nombre
			),
			array (
					'name' => 'Subtipo Gasto',
					'value' => $model->SubTipo
			),
			array (
					'name' => 'Categoría IVA',
					'value' => $model->categoriaIVA->descripcion
			),
			array (
					'name' => 'Moneda',
					'value' => $model->moneda->nombre
			),
	),
)); ?>

<div class="row-center">
	<?php
	echo CHtml::link('Volver', $this->createUrl('proveedor/admin'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	
	?>
</div>