<?php
$this->breadcrumbs = array (
		'Clientes' => array (
				'index' 
		),
		$model->id_cliente 
);

?>

<div class="titulo">Detalle de Cliente</div>
<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id_cliente',
				'codigo',
				'nombre',
				'telefono',
				'fax',
				'localidad.d_descripcion',
				'moneda.nombre' 
		) 
) );
?>
<div class="row-center">
	<?php
	echo CHtml::link ( 'Volver', $this->createUrl ( 'cliente/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	
	?>
</div>
