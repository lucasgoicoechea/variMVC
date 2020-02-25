<?php 
		$montoTotalCheques = 0.00;
		$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $model->id_pago );
		if ($resultadosEntrev !=null && sizeof ( $resultadosEntrev )> 0) {
		?>
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">CHEQUES
						</th>
			</tr>
		</thead>

	</table>
<div class="view">
	<div class="form">
			<div class="" id="list_cheques">
		<?php
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
			// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Cheques	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
			// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewChequeImpresion',
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
		?>
		<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoTotalCheques); ?>
					</b>
				</div>
			</div>
		<?php } else {
			//echo "NO POSEE CHEQUES PARA EL PAGO SELECCIONADOS";
		}
		?>
			
		</div>
	</div>
</div>
