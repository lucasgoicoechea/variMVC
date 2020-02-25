<?php
$this->breadcrumbs = array (
		'Retiro Capitals' => array (
				'index' 
		),
		$model->id_retirocapital 
);

?>


<div class="titulo">Ver datos del Retiro de Capital</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				// 'id_retirocapital',
				'Fecha',
				array (
						'name' => 'Cuenta',
						'value' => $model->cuenta->getDescripcion () 
				),
				'Importe',
				///'formaPago.Codigo',
				//'gasto.Codigo',
				'descripcion' 
		) 
) );
?>
<div class="row-center">
<?php
echo CHtml::button ( 'Volver', array (
		'name' => 'btnBack',
		'onclick' => 'js:history.go(-1);returnFalse;',
		'class' => 'btn btn-primary' 
) );
?></div>

