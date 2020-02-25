<?php
$this->breadcrumbs = array (
		'Presupuestos' => array (
				'index' 
		),
		$model->id_presupuesto 
);

?>
<div class="titulo">Detalle de Presupuesto</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id_presupuesto',
				'NumeroOrden',
				'Fecha',
				array (
						'label' => 'Obra',
						'type' => 'raw',
						'value' => $model->obra->Nombre 
				),
				array (
						'label' => 'Proveedor',
						'type' => 'raw',
						'value' => $model->proveedor->Nombre
				),
				'Cantidad',
				'Detalle',
				array (
						'label' => 'Material',
						'type' => 'raw',
						'value' => $model->material->Nombre 
				),
				array (
						'label' => 'Atención Venta',
						'type' => 'raw',
						'value' => $model->atencionVenta->nombre 
				),/*
				array (
						'label' => 'Empresa',
						'type' => 'raw',
						'value' => $model->empresa->nombre 
				),*/
		) 
) );
?>
<div class="row-center">
	<?php
	echo CHtml::link('Volver', $this->createUrl('presupuesto/admin'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	
	?>
</div>


