<?php //phpinfo();?>
<div class="titulo">Administrar&nbsp;Materiales/Comprobantes</div>
<div class="search-form" >
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( 'gastoItem/materialesFiltros' ),
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
	 	  url: '<?php echo CController::createUrl('gasto/imprimirGastosPorObra',array('nombreArchivo'=>'gastos-por-obra')); ?>'+data,
		  xhrFields: {
	 	    responseType: 'blob'
	 	  },
	 	  success: function(blob){
	 	    console.log(blob.size);
	 	      var link=document.createElement('a');
	 	      link.href=window.URL.createObjectURL(blob);
	 	      link.download="GastoPorObra" + new Date() + ".pdf";
	 	      link.click();
	 	  }
	 	});	
}

</script>

<div class="contenedor-tabla">
	<div class="contenedor-fila">
<div class="contenedor-columna-20">
			<label>Fecha Asiento </label>
			desde -
                <?php
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$comprobante',
																		'name' => 'Gasto[fechaAsientoDesde]',
																		'value' => $comprobante->fechaAsientoDesde,
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'language' => 'es',
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																
																?>
        </div>
	
		<div class="contenedor-columna-20">
			<label>Fecha Asiento </label>	hasta -
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$comprobante',
																		'name' => 'Gasto[fechaAsientoHasta]',
																		'value' => $comprobante->fechaAsientoHasta,
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'language' => 'es',
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>
        
		<div class="contenedor-columna-20">
				<label>Fecha Factura </label>	desde -
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$comprobante',
																		'name' => 'Gasto[fechaDesde]',
																		// 'language'=>'de',
																		'value' => $comprobante->fechaDesde,
																		'language' => 'es',
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'changeMonth' => true,
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>

		<div class="contenedor-columna-20">
						<label>Fecha Factura </label>	hasta -
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$comprobante',
																		'name' => 'Gasto[fechaHasta]',
																		'value' => $comprobante->fechaHasta,
																		'language' => 'es',
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label for="Obra">Obra</label>
<?php

			if ($comprobante->id_obra != '') {
				$value = $comprobante->obra->id_obra.'-'.$comprobante->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $comprobante, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $comprobante,
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
                                                                                { jQuery("#Gasto_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>

		

	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-60">
			<label for="Proveedor">Proveedor</label><?php
			
			if ($comprobante->id_proveedor != '' && $comprobante->id_proveedor != 0) {
				$value = $comprobante->proveedor->Nombre;
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $comprobante, 'id_proveedor' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_proveedor',
					'value' => $value,
					'model' => $comprobante,
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
                                                                                { jQuery("#Gasto_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_proveedor").val(0); }' 
					) 
			) );
			?>
			</div>
		<div class="contenedor-columna-30">
			<label>Telefono</label>
		 <?php
			
			if ($comprobante->id_proveedor != '' && $comprobante->id_proveedor != 0) {
				echo CHtml::textField ( "telefono", $comprobante->proveedor->Telefono );
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
	$this->renderPartial ( '_resultadoMaterialesPorObra', array (
			'model' => $comprobante,
			'gastoitem' =>$model
	) );
?>
<a target='_blank' id="export-button" onclick="imprimir();">Imprimir <img
	src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/exportExcel32.png'
	width='32'></a>
<?php }
?>
</div>