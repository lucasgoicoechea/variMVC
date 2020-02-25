<div  class="titulo">Detalle datos del Personal registrado</div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			array (
					'name' => 'Codigo',
					'value' => $model->id_proveedor
			),
			'Apellido',
			'Nombre',
			'Telefono',
		'TipoDoc',
		'NumDoc',
		'CUIL',
		'Domicilio',
		'Nro',
		'Piso',
		'Dpto',
		'Localidad',
		'codigo_postal',
		'provincia',
		'Nacion',
			array (
					'name' => 'Categoria',
					'value' => $model->categoria->Nombre
			),
			array (
					'name' => 'Precio/hora',
					'value' => $model->categoria->ValorHora
			),
		'estado_civil',
		'codigo_area',
		'Telefono',
		'Numero_Libreta',
		'Banco_Fondo_Desempleo',
		'Numero_Fondo_Desempleo',
		'Asignacion_Familiar',
		'ObraSocial',
		'Pantalon',
		'Camisa',
		'Botin',
		'Fecha_Ingreso',
		'Fecha_Nacimiento',
		'Fecha_ropa',
		'Fecha_Baja',
	),
)); ?>


<div class="row-center">
	<?php
	echo CHtml::link('Volver', $this->createUrl('personal/admin'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	
	?>
</div>

