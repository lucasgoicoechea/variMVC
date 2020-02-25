<?php
$this->breadcrumbs = array (
		'Accesoses',
		Yii::t ( 'app', 'Index' ) 
);

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'Create' ) . ' Accesos',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Manage' ) . ' Accesos',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>Accesoses</h1>

<?php

$this->widget ( 'zii.widgets.CListView', array (
		'dataProvider' => $dataProvider,
		'itemView' => '_view' 
) );
?>
