<div class="view">
	<div class="form">
	<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List Gasto Items'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('efectivo-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>


<div class="titulo"> Administrar&nbsp;Pagos en Detalles Items</div>



<?php $gastoitem = new GastoItem();
$gastoitem->nulearValores();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gasto-item-grid',
	'dataProvider'=>$gastoitem->searchWithGasto($model->id_gasto),
	'filter'=>$gastoitem,
		'columns'=>array(
			array (
				'header' => 'Codigo(ID)',
				'name' => 'id_gasto_item',
				'value' => '$data->id_gasto_item',
			),
			array (
				'header' => 'Material',
				'name' => 'id_material',
				'value' => '$data->getDescripcionMaterial()',
			),	
			'cantidad',
			'consumido',
			'valor_unidad',
			'valor_final',
		array (
		'htmlOptions' => array (
				'width' => '20px'
		),
		'header' => ' ',
		'template' => '{view}{updaten}{borrarEfectivo}',
		'class' => 'CButtonColumn',
		'buttons' => array (
			'updaten' => array(
				'label' => 'Editar Gasto Item',
				'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/update.png",
				'url' => '$data->getUrlUpdate()',
				'visible' => 'true',
				'options' => array (
						'target' => '_blank'
				)
			),
				'borrarEfectivo' => array(
										'click' => "function() {
						if(!confirm('Borrar el Detalle Item?')) return false;
						$.fn.yiiGridView.update('gasto-item-grid', {
						type:'POST',
						url:$(this).attr('href'),
						success:function(text,status) {
							$.fn.yiiGridView.update('gasto-item-grid');
						}
						});
						return false;
						}",
						'label' => 'Borrar Gasto Item',
						'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/delete.png",
						'url' => '$data->getUrlDelete()',
						'visible' => 'true',
						'options' => array (
								'target' => '_blank'
						)
				)
		)
	)
))); 
?>
		<br>
<?php
$this->renderPartial ( 'createDetalleItem', array (	
	'model' => $gastoitem,
	'id_gasto'=>$model->id_gasto,
'grillaPosgrados' => 'id_gasto_item_list',
	'urlOperationAction'=>Gasto::model()->getUrlAgregarDetalleItem($model->id_gasto,$model->id_obra,$model->id_proveedor)) );
?>
</div>
</div>