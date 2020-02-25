<?php



Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('ingreso-cuenta-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Ingresos a Cuenta</div>

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
		'id' => 'ingreso-cuenta-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				// 'id_retirocapital',
				'fecha',
				array (
						'name' => 'id_cuenta',
						'value' => '$data->cuenta->descripcion',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
						) ), 'id_cuenta', 'descripcion' ) 
				),
				'importe',
				'descripcion',
				// 'id_forma_pago',
				// 'id_gasto',
				/*
				 *
				 */
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
?>
