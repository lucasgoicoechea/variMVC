<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('gasto-grid',{ 
        success: function() {
            $('#gasto-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('gasto/exportar',array('nombreArchivo'=>'gastos-filtrados')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}
</script>
<?php
Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('gasto-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>

<div class="titulo">Administrar&nbsp;Facturas/Comprobantes</div>

<div class="search-form" style="display: block">
<?php

$this->renderPartial ( '_searchFiltros', array (
		'model' => $model 
) );
?>
</div>
<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>
<?php
$searDP = $model->searchFiltrosConMedioPago ();



/*$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $searDP,
		'filter' => $model,
		'columns' => array (
				array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
						)
		) 
) );*/

?>
