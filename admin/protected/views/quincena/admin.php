<div class="titulo">Administrar&nbsp;Quincenas Personal	</div>

<?php //echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div>


<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('quincena-grid',{ 
        success: function() {
            $('#quincena-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('quincena/exportar',array('nombreArchivo'=>'quincena-vari.xls')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}

</script>

<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quincena-grid',
	'dataProvider'=>$model->searchOrderQuincena(),
	'filter'=>$model,
	'columns'=>array(
		array (
			'name' => 'Indice',
			'header' => 'Indice',
			'htmlOptions' => array (
					'style' => 'width: 3px'
			),		
			'headerHtmlOptions' => array (
				'style' => 'width: 3px'
		)

		),
		array (
			'name' => 'id_proveedor',
			'header' => 'Personal',
			'value' => '$data->personal!=null?$data->personal->Apellido.",".$data->personal->Nombre:""',
			'htmlOptions' => array (
					'width' => '10'
			)
		) ,
		array (
			'name' => 'id_obra',
			'header' => 'Obra',
			'value' => '$data->obra!=null?$data->obra->getDescripcion():""',
			'htmlOptions' => array (
					'width' => '10'
			)
		) ,
			'Fecha',
		array (
			'name' => 'id_quincenal',
			'header' => 'Quincenal',
			'value' => '$data->quincenal!=null?$data->quincenal->getDescripcion():""',
			'filter' => CHtml::listData ( Quincenal::model ()->findAll ( array (
					"condition"=>'',
					'order' => 'anio DESC,mes DESC,quincena' 
			) ),  
			'id_quincenal','descripcion' ) 
	),
	array (
		'name' => 'id_cuenta',
		'header' => 'Cuenta',
		'value' => '$data->getCuenta()!=null?$data->getCuenta()->getDescripcion():""',
		'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
				"condition"=>'',
				'order' => 'Codigo ' 
		) ),  
		'id_cuenta','Nombre' ) 
),
		'horas',
		'efectivo',
		'extras',
		'adelantos',
		'viaticos',
		'movilidad',
		//'subtotal',
		'descuentos_adelantos',
		'Final',
		/*
		'horas_extras',
		'dias_trabajados',
		'nro_secuencia_quincena',
		'Quincena',
		'Indice',
		
		'id_empresa',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
