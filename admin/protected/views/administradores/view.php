<?php
$this->breadcrumbs = array (
		'Administradores' => array (
				'index' 
		),
		$model->id 
);

$this->menu = array (
		array (
				'label' => 'List Administradores',
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => 'Create Administradores',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => 'Update Administradores',
				'url' => array (
						'update',
						'id' => $model->id 
				) 
		),
		array (
				'label' => 'Delete Administradores',
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
				'label' => 'Manage Administradores',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>View Administradores #<?php echo $model->id; ?></h1>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id',
				'usuario',
				'clave',
				'nombre',
				'apellido',
				'idTipo',
				'verEntrevista',
				'id_userslogin' 
		) 
) );
?>


