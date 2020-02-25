<div class="titulo">Administrar&nbsp;Quincenales</div>

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
	'id'=>'quincenal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		array (
			'name' => 'id_quincenal',
			'header' => 'Codigo',
			'htmlOptions' => array (
					'style' => 'width: 3px'
			),		
			'headerHtmlOptions' => array (
				'style' => 'width: 3px'
		)
	),array (
		'name' => 'anio',
		'header' => 'Año',
		'htmlOptions' => array (
				'style' => 'width: 3px'
		),		
		'headerHtmlOptions' => array (
			'style' => 'width: 3px'
	)
),
array (
	'name' => 'mes',
	'header' => 'Mes',
	'value' => 'LGHelper::functions ()->getMonthLabel ( $data->mes)',
	'htmlOptions' => array (
			'width' => '10'
	)
) ,

array (
	'name' => 'quincena',
	'header' => 'Quincena',
	'value' => '$data->quincena==1?"PRIMERA":"SEGUNDA"',
	'htmlOptions' => array (
			'width' => '10'
	)
) ,
		
		'descripcion',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{update}{quincenas}',
			'buttons' => array (
				'quincenas' => array (
						'label' => 'Ver Quincenas Personal',
						'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
						'url' => '$data->getUrlQuincenas()',
						'visible' => 'true',
						'options' => array (
								'target' => '_blank' 
								)
								),
			)

		),
	),
)); ?>
