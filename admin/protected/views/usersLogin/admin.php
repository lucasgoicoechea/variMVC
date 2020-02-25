<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array (
		'Usuarios' => array (
				'index' 
		),
		'Manage' 
);

$this->menu = array (
		array (
				'label' => 'Create Users',
				'url' => array (
						'create' 
				) 
		) 
);
?>
<h4>
	Manage Users <small> You may optionally enter a comparison operator (<b>&lt;</b>,
		<b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>)
		at the beginning of each of your search values to specify how the
		comparison should be done.
	</small>
</h4>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'users-grid',
		'itemsCssClass' => 'table table-striped',
		'pager' => array (
				'htmlOptions' => array (
						'class' => 'pagination' 
				) 
		),
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				'id',
				'username',
				'password',
				'email',
				'birthday',
				'name',
		/*
		'countries_id',
		'cities_id',
		'status',
		*/
		array (
						'class' => 'CButtonColumn' 
				) 
		),
)); ?>
