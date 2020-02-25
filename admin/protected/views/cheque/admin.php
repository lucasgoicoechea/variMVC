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
						'header' => 'Fecha Emision',
						// 'name' => 'tipoAdmin.descripcion',
						'value' => 'LGHelper::functions()->displayFecha($data->FechaEmision)',
						'headerHtmlOptions' => array ()
						// 'style' => 'width:80px'
						 
				),
				array (
						'header' => 'Fecha al Cobro',
						// 'name' => 'tipoAdmin.descripcion',
						'value' => 'LGHelper::functions()->displayFecha($data->FechaPago)',
						'headerHtmlOptions' => array ()
						// 'style' => 'width:80px'
						 
				),
				'Importe',
				array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{anularCheque}{reemplazarCheque}{pago}',
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
										),
								'pago' => array (
										'label' => 'Ver Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
										'url' => '$data->getUrlPagoEditar()',
										'visible' => '$data->isConPago()',
										'options' => array (
												'target' => '_blank'
										)
								),
								'anularCheque' => array (
										'label' => 'ANULARS Cheque',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/delete_x.gif",
										'url' => '$data->getUrlAnularCheque()',
										'visible' => '!$data->isAnulado()',
										'click' => "function(){
    $.fn.yiiGridView.update('cheque-grid', { 
        type:'GET',
        url:$(this).attr('href'),
        success:function(data) {
				alert('Cheque ANULADO CON EXITO');
              $.fn.yiiGridView.update('cheque-grid'); 
        }
    })
    return false;
  }
",
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						) 
				) 
		) 
) );
?>
