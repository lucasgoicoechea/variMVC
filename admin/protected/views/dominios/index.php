<?php
$this->breadcrumbs = array (
		'Dominioses',
		Yii::t ( 'app', 'Index' ) 
);

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'Create' ) . ' Dominios',
				'url' => array (
						'create' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Manage' ) . ' Dominios',
				'url' => array (
						'admin' 
				) 
		) 
);
?>

<h1>Dominioses</h1>

<?php

$this->widget ( 'zii.widgets.CListView', array (
		'dataProvider' => $dataProvider,
		'itemView' => '_view' 
) );
?>
