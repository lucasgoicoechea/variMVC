<div class="view">
	<div class="form">
<?php
$gastoRetPerc = new GastoRetencionPercepcion ();
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-retencion-percepcion-grid',
		'dataProvider' => $gastoRetPerc->searchWithGasto ( $id_gasto ),
		//'filter' => $gastoRetPerc,
		'columns' => array (
				// 'id_gasto_retencion_percepcion',
				array (
						'name' => 'id_retencion_percepcion',
						'value' => '$data->retencionPercepcion->getDescripcionAbreviada()',
						'filter' => CHtml::listData ( RetencionPercepcion::model ()->findAll ( array (
								'order' => 'id_retencion_percepcion' 
						) ), 'id_retencion_percepcion', 'descripcion' ) 
				),
				array (
						'header' => 'Alicuota',
						'value' => '$data->retencionPercepcion->getAlicuota($data->valor)' 
				),
				array (
						'header' => 'Importe',
						'value' => '$data->alicuota' 
				),
				
				array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						//'template' => '{view}{update}{borrarRetPercep}',
						'template' => '{borrarRetPercep}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'borrarRetPercep' => array (
										'click' => "function() {
						if(!confirm('Borrar Retención-Percepción?')) return false;
						$.fn.yiiGridView.update('gasto-retencion-percepcion-grid', {
						type:'POST',
						url:$(this).attr('href'),
						success:function(text,status) {
							$.fn.yiiGridView.update('gasto-retencion-percepcion-grid');
							var subtotal = $('#Gasto_Monto').val();			
						 $.ajax({
						   	  dataType : 'html',
							 data: {refresh:'true',neto_tmp: subtotal},
						   	  url: '" . Yii::app ()->createUrl ( 'gasto/calcularTotalGasto', array (
												'refresh' => true,
												'id_gasto' => $id_gasto 
										) ) . "',
						  	  success: function(dataHtml) {
						   	    // Do something after AJAX is completed.
						   		  dataInnerHtml = dataHtml;
						   	      window.parent.$('#totalGastoID').html(dataInnerHtml);
						   	  }
						   	})
						}
						});
						return false;
						}",
										'label' => 'Borrar Retención-Percepción',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/delete.png",
										'url' => '$data->getUrlDelete()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						) 
				) 
		) 
) );
$montoTotalRetenciones = Gasto::model ()->getTotalMontoRetenciones ( $id_gasto );
?>
<div id="id_retenciones_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - RETENCIONES/PERCEPCIONES</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalRetenciones); ?></b>
				</div>
			</div>
		</div>
		<br> <br> <br> <br> <br>
<?php
$this->renderPartial ( 'createRetPercep', array (
		'model' => $gastoRetPerc,
		'id_gasto' => $id_gasto,
		'grillaPosgrados' => 'id_retenciones_list',
		'urlOperationAction' => Gasto::model ()->getUrlAgregarRetenciones ( $id_gasto ) 
) );
?>
</div>
</div>