<div class="view">
	<div class="form">
	<?php
	if (Yii::app ()->user->hasFlash ( 'mensaje' )) {
		?>
		<h3 style="color: green;">
		<?php echo Yii::app()->user->getFlash('mensaje')?>
		</h3>
		<?php
	}
	?>
		<h4 class="subtitulo">
			Agregar Cheque
			<?php

			echo CHtml::link ( "<img src='" . Yii::app ()->theme->baseUrl . "/img/icons/add.png' >", 
					Yii::app ()->createUrl ( 'pago/agregarCheque', array (
		"asDialog" => 1,
								"id_pago" => $id_pago 
			)),
			// ajax options
			array (
							'onclick' => '$("#cru-dialog-cheque").dialog("open"); $("#cru-frame-cheque").attr("src",$(this).attr("href")); return false;',
							'update' => '#list_cheques' 
							),
							// htmloptions
							array (
							'id' => 'addNewCheque' 
							) );

							?>
		</h4>
	
		<div class="" id="list_cheques">
		<?php
		$montoTotalCheques = 0.00;
		$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $model->id_pago );
		if ($resultadosEntrev !=null && sizeof ( $resultadosEntrev )> 0) {
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
			// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Cheques	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
			// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewCheque',
			// 'viewData' => array( 'data' => null ),
					'ajaxUpdate' => false,
			// 'enablePagination'=>true
					'pager' => array (
							'header' => 'Ir a', // text before it
							'maxButtonCount' => 28 
			)
			) );
			$resultados = PagoCheque::model ()->searchWithPagoOO ( $model->id_pago );
			if (sizeof ( $resultados) > 0) {
				foreach ( $resultados as $value ) {
                  if (!$value->cheque->anulado) {
                  	$montoTotalCheques = $montoTotalCheques + LGHelper::functions()->unformatNumber($value->cheque->Importe);
                  }
				}}
		} else {
			echo "NO POSEE CHEQUES PARA EL PAGO SELECCIONADOS";
			$montoTotalCheques = 0.00;
		}
		?>
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoTotalCheques); ?>
					</b>
				</div>
			</div>
		</div>


		<?php
		// --------------------- begin new code --------------------------
		// add the (closed) dialog for the iframe
		$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
			'id' => 'cru-dialog-cheque',
			'options' => array (
					'title' => 'Actualizar datos',
					'autoOpen' => false,
					'modal' => true,
					'width' => 900,
					'height' => 400 
		)
		) );
		?>
		<iframe id="cru-frame-cheque" width="100%" height="100%"> </iframe>
		<?php

		$this->endWidget ();
		// --------------------- end new code --------------------------
		?>
	</div>
</div>
