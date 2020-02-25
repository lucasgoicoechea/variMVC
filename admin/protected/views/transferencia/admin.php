<?php

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Transferencia' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
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
				$.fn.yiiGridView.update('transferencia-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Transferencias entre Cuentas</div>

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
		'id' => 'transferencia-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				array (
						'name' => 'id_transferencia',
						'header' => 'Número',
						'value' => '$data->id_transferencia',
				),
				'fecha',
				array (
						'name' => 'id_cuenta_origen',
						'value' => '$data->cuentaOrigen->descripcion',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
						) ), 'id_cuenta', 'descripcion' ) 
				),
				array (
						'name' => 'id_cuenta_destino',
						'value' => '$data->cuentaDestino->descripcion',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
						) ), 'id_cuenta', 'descripcion' ) 
				),
				array (
						'name' => 'importe',
						'value' => 'LGHelper::functions ()->formatNumber ($data->importe)',
				),
				'descripcion',
				// 'id_forma_pago',
				// 'id_gasto',
				/*
				 *
				 */
				array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{imprimirPago}{delete}',
						'class' => 'CButtonColumn',
						'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
						'buttons' => array (
								'imprimirPago' => array (
										'label' => 'Imprimir Transferencia',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
										'url' => '$data->getUrlImprimir()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						) 
				) 
		) 
) );
?>
			

