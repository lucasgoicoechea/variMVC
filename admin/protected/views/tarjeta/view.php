<?php
$this->breadcrumbs = array (
		'Tarjetas' => array (
				'index' 
		),
		$model->id_tarjeta 
);

?>

<div class="titulo">Detalle de Tarjeta Registrada</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				// 'id_tarjeta',
				'numero',
				'titular',
				array (
						'name' => 'Tipo Tarjeta',
						'value' => $model->tipoTarjeta->descripcion
				) 
		) 
) );
?>
<div class="row-center">
	<span>
    <?php
				echo CHtml::link ( 'Volver', $this->createUrl ( 'tarjeta/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>
</div>

