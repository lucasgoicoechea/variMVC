<?php
$model = new Cheque();
//$model->pagada = $pagados?1:0;
$model->FechaEmision = $caja->fecha;
Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cheque-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>
<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '/cheque/_search', array (
		'model' => $model 
) );
?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cheque-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'serie',
		'Numero',
		'id_obra',
				array (
						'name' => 'id_cuenta_banco',
						'value' => '$data->cuentaBanco->descripcion',
						'filter' => CHtml::listData ( CuentaBanco::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cuenta_banco', 'descripcion' ) 
				),
		'FechaEmision',
		'FechaPago',
		'Importe',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>