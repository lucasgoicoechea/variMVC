<?php
/*$this->breadcrumbs=array(
	'Personals'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Personal'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Personal'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('personal-grid', {
data: $(this).serialize()
});
				return false;
				});
			");*/
		?>

<div class="titulo">Administrar&nbsp;Personal</div>

<?php //echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div>


<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('personal-grid',{ 
        success: function() {
            $('#personal-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('personal/exportar',array('nombreArchivo'=>'personal-vari.xls')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}

</script>

<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'personal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Codigo',
		'Apellido',
		'Nombre',
		//'TipoDoc',
		//'NumDoc',
		'CUIL',
		/*'Domicilio',
		'Nro',
		'Piso',
		'Dpto',*/
		'Localidad',
		//'codigo_postal',
		'provincia',
			array (
					'name' => 'codigo_area',
					'header' => 'Cod.Area',
					'htmlOptions' => array (
							'width' => '5'
					),
					'headerHtmlOptions' => array (
							'style' => 'width: 5'
					)
			),
			
			'Telefono',
		//	'Nacion',
			'Fecha_Ingreso',
			'Fecha_Nacimiento',
		//	'Fecha_ropa',
		   'Fecha_Baja',
			array (
					'name' => 'id_categoria_mano_obra',
					'header' => 'Categoria',
					'value' => '$data->categoria!=null?$data->categoria->Nombre:""',
					'htmlOptions' => array (
							'width' => '10'
					)
			),
		/*'id_categoria_mano_obra',
		'estado_civil',

		'id_empresa',
		'Numero_Libreta',
		'Banco_Fondo_Desempleo',
		'Numero_Fondo_Desempleo',
		'Asignacion_Familiar',
		'ObraSocial',
		array (
					'name' => 'id_proveedor',
					'htmlOptions' => array (
							'width' => '5'
					),
					'headerHtmlOptions' => array (
							'style' => 'width: 5'
					)
			),
		
		'Pantalon',
		'Camisa',
		'Botin',
		'id_obra',
		'id_proveedor',
		
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
