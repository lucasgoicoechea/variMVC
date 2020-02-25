<?php
$this->breadcrumbs = array (
		'Accesoses' => array (
				Yii::t ( 'app', 'index' ) 
		),
		Yii::t ( 'app', 'Manage' ) 
);

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Accesos' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Create Accesos' ),
				'url' => array (
						'create' 
				) 
		) 
);

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('accesos-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<h1>Manage&nbsp;Accesoses</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'accesos-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		// 'ajaxU'
		'columns' => array (
				'id',
				'descripcion',
				'orden',
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
