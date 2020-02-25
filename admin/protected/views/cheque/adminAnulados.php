<?php

$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Cheque' ),
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
				$.fn.yiiGridView.update('cheque-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Cheques</div>

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
		'id' => 'cheque-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
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
				array (
						'name' => 'id_cheque_reemplaza',
						'value' => '$data->chequeReemplazo!=null?$data->chequeReemplazo->descripcion:"A Reemplazar"' 
				),
				'FechaEmision',
				'FechaPago',
				'Importe',
				array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{reemplazarCheque}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'reemplazarCheque' => array (
										'label' => 'Reemplazar Cheque',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/preview.gif",
										'url' => '$data->getUrlReemplazoCheque()',
										'visible' => '$data->isAnulado()',
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						) 
				) 
		)
		 
) );
?>
