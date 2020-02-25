<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List TransferenciaPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('transferencia-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Transferencias usadas para el Pago</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferencia-pago-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_transferencia_pago',
		'id_cuenta_banco',
		'referencia',
		'monto',
		'cbu_destino',
		'id_pago',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
