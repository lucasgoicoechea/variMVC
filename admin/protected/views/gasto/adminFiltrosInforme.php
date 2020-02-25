<?php
Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('cobro-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>
<?php

?>
<div class="titulo">Informe Balance - Compras/Ventas/IVA</div>
<div class="search-form">
<?php

$this->renderPartial ( '_searchFiltrosInforme', array (
		'model' => $model 
) );
?>
</div>

<script type="text/javascript">
					
function exportar(){
	 $.fn.yiiGridView.update('cobro-grid',{ 
        success: function() {
            $('#cobro-grid').removeClass('grid-view-loading');
            window.location = '<?php echo CController::createUrl('gasto/exportar',array('nombreArchivo'=>'Compras-Ra')); ?>';
        },
        data: $('.search-form form').serialize() + '&export=true'
    });	
}
function exportarXLS(){
		$('#descargar-xls').attr("disabled",true).html("Generando XLS...");
		window.open('<?php echo CController::createUrl('gasto/balanceMensuales',array('nombreArchivo'=>'Compras-Ra')); ?>' + '&export=true&'+$('#yw0 [name^="BalanceMensualesForm["]' ).serialize());
		 $('#descargar-xls').attr("disabled",false).html("Descargar en Excel");
}
</script>

<br>
<div class="row-center">
	<a target='_blank' id="descargar-xls" class="btn btn-primary"
		onclick="exportarXLS();">Descargar en EXCEL</a>
</div>
