<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List OrdenCompra' ),
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
				$.fn.yiiGridView.update('orden-compra-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Orden Compras</div>

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
		'id' => 'orden-compra-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				array (
						'name' => 'numero_orden',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				'Fecha',
				array (
						'header' => 'Proveedor(Telefono)',
						'name' => 'id_proveedor',
						'value' => '$data->proveedor!=null?$data->proveedor->getDescripcion():"Sin Proveedor"',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_proveedor', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
							'value' => '$data->obra!=null?$data->obra->Nombre:"Sin OBRA"',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				'Solicitado',
				'Autorizo',
				'Entrega',
				/*array (
						'name' => 'Pagada',
						'value' => '$data->Pagada?Yii::t(\'app\',\'Si\'):Yii::t(\'app\', \'No\')',
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
						),
						'htmlOptions' => array (
								'width' => '25px',
								'style' => "text-align:center;" 
						) 
				),
				array (
						'name' => 'Impresa',
						'value' => '$data->Impresa?Yii::t(\'app\',\'Si\'):Yii::t(\'app\', \'No\')',
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
						),
						'htmlOptions' => array (
								'width' => '25px',
								'style' => "text-align:center;" 
						) 
				),*/
				array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{imprimirOferta}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'imprimirOferta' => array (
										'label' => 'Imprimir Orden de Compra',
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
