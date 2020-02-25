<?php
$this->breadcrumbs = array (
		'Accesoses' => array (
				'index' 
		),
		$model->id 
);

$this->menu = array (
		array (
				'label' => 'List Accesos',
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => 'Create Accesos',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => 'Update Accesos',
				'url' => array (
						'update',
						'id' => $model->id 
				) 
		),
		array (
				'label' => 'Delete Accesos',
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
				'label' => 'Manage Accesos',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>View Accesos #<?php echo $model->id; ?></h1>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id',
				'descripcion',
				'orden' 
		) 
) );
?>


