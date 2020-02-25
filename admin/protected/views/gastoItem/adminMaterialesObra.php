<?php //phpinfo();?>
<div class="titulo">Administrar&nbsp;Materiales/Obras</div>
<div class="search-form" >
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( 'gastoItem/materialesObras' ),
		'method' => 'get' 
) );
?>
<script type="text/javascript">
function exportar(){
	 $.fn.yiiGridView.update('gasto-grid',{
	    data: $('.search-form form').serialize() , 
       success: function() {
           $('#gasto-grid').removeClass('grid-view-loading');
           window.location = '<?php echo CController::createUrl('gastoItem/exportarSinPaginas',array('nombreArchivo'=>'gastos-por-obra')); ?>'+$('.search-form form').serialize() + '&export=true';
       },
   });	
}					

function imprimir(){
	var data = $('.search-form form').serialize() ;
	var url = '<?php echo CController::createUrl('gasto/imprimirGastosPorObra',array('nombreArchivo'=>'gastos-por-obra')); ?>&'+data;
	myWindow = window.open(url,'_blank');
}

function imprimir2(){
	var data = $('.search-form form').serialize() ;
	 $.ajax({
	 	  dataType: 'native',
	 	  url: '<?php echo CController::createUrl('gastoItem/materialesPorObraPrint',array('nombreArchivo'=>'gastos-por-obra')); ?>'+data,
		  xhrFields: {
	 	    responseType: 'blob'
	 	  },
	 	  success: function(blob){
	 	    console.log(blob.size);
	 	      var link=document.createElement('a');
	 	      link.href=window.URL.createObjectURL(blob);
	 	      link.download="MaterialesPorObra" + new Date() + ".pdf";
	 	      link.click();
	 	  }
	 	});	
}

</script>

<div class="contenedor-tabla">
	<div class="contenedor-fila">

	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label for="Obra">Obra</label>
<?php

			if ($model->id_obra != '') {
				$value = $model->obra->id_obra.'-'.$model->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'obra/autoCompleteBuscarAll' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>

		

	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-60">
			<label for="Proveedor">Proveedor</label><?php
			
			if ($model->id_proveedor != '' && $model->id_proveedor != 0) {
				$value = $model->proveedor->Nombre;
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_proveedor' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_proveedor',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'proveedor/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 100,
							'style' => "width:95%" 
					),
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_proveedor").val(0); }' 
					) 
			) );
			?>
			</div>
		<div class="contenedor-columna-30">
			<label>Telefono</label>
		 <?php
			
			if ($model->id_proveedor != '' && $model->id_proveedor != 0) {
				echo CHtml::textField ( "telefono", $model->proveedor->Telefono );
			} else {
				echo CHtml::textField ( "telefono", '' );
			}
			?>
		</div>
	</div>
</div>
	<div class="row-center">
                <?php //echo CHtml::submitButton(Yii::t('app', 'Buscar')); 
			  echo CHtml::submitButton ( 'BUSCAR', array (
		  		'id'=>'botonSumit',
			'class' => 'btn btn-primary') ); 
	?>
        </div>

<?php $this->endWidget(); ?>

</div>

<a target='_blank' id="export-button" onclick="exportar();">Exportar <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>

<div id="resultado">
<?php if ($busqueda){
	$this->renderPartial ( '_resultadoMaterialesTotales', array (
			'model' => $model
	) );
?>
<a target='_blank' id="export-button" onclick="imprimir();">Imprimir <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>
<?php }
?>
</div>