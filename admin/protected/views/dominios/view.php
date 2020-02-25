<?php
$this->breadcrumbs = array (
		'Dominioses' => array (
				'index' 
		),
		$model->id 
);

$this->menu = array (
		array (
				'label' => 'List Dominios',
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => 'Create Dominios',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => 'Update Dominios',
				'url' => array (
						'update',
						'id' => $model->id 
				) 
		),
		array (
				'label' => 'Delete Dominios',
				'url' => '#',
				'linkOptions' => array (
						'submit' => array (
								'delete',
								'id' => $model->id 
						),
						'confirm' => 'Are you sure you want to delete this item?' 
				) 
		),
		array (
				'label' => 'Manage Dominios',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>View Dominios #<?php echo $model->id; ?></h1>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id',
				'codigo_dominio',
				'descripcion' 
		) 
) );
?>


