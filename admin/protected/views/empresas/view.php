<div class="titulo">Empresa: <?php echo $model->nombre; ?></div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'nombre',
				'codigo',
				'cuit',
				'inicio_actividad',
				'razon_social' 
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
	?>
</div>

