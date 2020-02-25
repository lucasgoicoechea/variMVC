<?php
$this->breadcrumbs = array (
		'Administradores',
		Yii::t ( 'app', 'Index' ) 
);

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'Create' ) . ' Administradores',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Manage' ) . ' Administradores',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>Administradores</h1>

<?php

$this->widget ( 'zii.widgets.CListView', array (
		'dataProvider' => $dataProvider,
		'itemView' => '_view' 
) );
?>
