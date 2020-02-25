<?php
$this->menu=array(
		array('label'=>Yii::t('app',
				'List MesPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create MesPago'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('mes-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div class="titulo"> Pagos Meses</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<div class="contenedor-tabla">
	<div style="font-size: 12px" class="titulo">Pagos - Meses</div>
	
	<?php
	
	$this->widget ( 'zii.widgets.grid.CGridView', array (
			'id' => 'mes-pago-grid',
			'dataProvider' => $model->searchConvenioMarco(),
			'filter' => $model,
			'columns' => array (
					'id',
		/*'numero',
		'id_conv_individual',
		 'pagado',
		'id_forma_pago',
		*/
	array (
							'name' => 'fecha_pago',
							// 'value'=>'Facultades::getFacultadNombre($data->id_facultad)',
							'header' => 'Fecha de Pago',
							'headerHtmlOptions' => array (
									'style' => 'width:60px' 
							) 
					),
					array (
							'name' => 'mes_periodo',
							// 'value'=>'Facultades::getFacultadNombre($data->id_facultad)',
							'header' => 'Mes de Pago',
							'headerHtmlOptions' => array (
									'style' => 'width:40px' 
							) 
					),
					array (
							'name' => 'ano_periodo',
							// 'value'=>'Facultades::getFacultadNombre($data->id_facultad)',
							'header' => 'Año de Pago',
							'headerHtmlOptions' => array (
									'style' => 'width:40px' 
							) 
					),
array (
		//'name' => 'ano_periodo',
		'value'=>'$data->pagado==1?"Si":"No"',
		'header' => 'Pagado',
		'headerHtmlOptions' => array (
				'style' => 'width:40px'
		)
),
					
					'asignacion',
					'porcentage_rectorado',
					'porcentage_facultad',
					
					array (
							'class' => 'CButtonColumn',
							'updateButtonUrl' => 'Yii::app()->controller->createUrl("/mesPago/update",array("id"=>$data->id))',
							'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/mesPago/delete",array("id"=>$data->id))',
							'viewButtonUrl' => 'Yii::app()->controller->createUrl("/mesPago/view",array("id"=>$data->id))' 
					) 
			) 
	) );
	?>
</div>
