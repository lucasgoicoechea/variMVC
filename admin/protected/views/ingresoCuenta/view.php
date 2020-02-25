<div class="titulo">Ver datos del Ingreso a Cuenta</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				// 'id_retirocapital',
				'fecha',
				array (
						'name' => 'Cuenta',
						'value' => $model->cuenta->getDescripcion () 
				),
				'importe',
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

