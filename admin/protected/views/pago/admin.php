<?php     $this->menu=array(
array('label'=>Yii::t('app',
				'List Pago'), 'url'=>array('index')),
array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
?>

<div class="titulo">Administrar&nbsp;Pagos</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php
$datap = $model->search();
?>
<->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pago-grid',
	'dataProvider'=>$datap,
	'filter'=>$model,
	'columns'=>array(
array (
						'name' => 'numero',
						'value' => '$data->numero',
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'fecha_emision',
						'value' => '$data->fecha_emision!=null?$data->fecha_emision:""',
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'fecha_cobro',
						'value' => '$data->fecha_cobro!=null?$data->fecha_cobro:""',
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;"
								)
								),
								array (
						'header' => 'Proveedor(Telefono)',
						'name' => 'id_proveedor',
						'value' => '$data->getProveedorDescripcion()',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre' 
								) ), 'id_proveedor', 'descripcion' )
								),
								array (
						'header' => 'Primera Obra',
						'value' => '$data->getObra()!=null?$data->getObra()->getDescripcion():""',
			
								),
								
								array (
						'name' => 'id_cuenta',
						'value' => '$data->cuenta!=null?$data->cuenta->descripcion:""',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
								) ), 'id_cuenta', 'descripcion' ),
						'htmlOptions' => array (
								'width' => '100px',
								'style' => "text-align:center;" 
								)
								),
								array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
								),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
								),
						//'name' => 'pagado',
						'type' => 'raw',
						'value' => '$data->isPagado()?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
						),
						array (
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;" 
								),
					'header'=>'A Pagar',
								//'type' => 'raw',
								//'value' => 'OrdenPago::model()->getMonto($data->id_orden_pago)'
						'value' => '"$ ".$data->getMonto()'
						),
						array (
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;" 
								),
					'header'=>'Pagado',
								//'type' => 'raw',
								//'value' => 'OrdenPago::model()->getMonto($data->id_orden_pago)'
						'value' => '"$ ".$data->getMontoPagado()'
						),
							array (
						'htmlOptions' => array (
								'width' => '20px' 
								),
						'header' => ' ',
						'template' => '{view}{update}{imprimirPago}{delete}',
						'class' => 'CButtonColumn',
						 'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
						'buttons' => array (
								'imprimirPago' => array (
										'label' => 'Imprimir Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
										'url' => '$data->getUrlImprimir()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
												))))
						)
												)); ?>
