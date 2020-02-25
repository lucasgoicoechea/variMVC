<?php
$this->breadcrumbs = array (
		'Dominioses' => array (
				Yii::t ( 'app', 'index' ) 
		),
		Yii::t ( 'app', 'Manage' ) 
);

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Dominios' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Create Dominios' ),
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
				$.fn.yiiGridView.update('dominios-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Manage&nbsp;Dominioses</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'dominios-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				'id',
				'codigo_dominio',
				'descripcion',
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
