<div class="view">
	<div class="form">
		<div class="" id="list_entrevistas">
	<?php
	$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPagoSinPaginar ( $model->id_orden_pago );
	$montoTotalOP = 0.00;
	if ($resultadosEntrev != null) {
		/*$this->widget ( 'zii.widgets.CListView', array (
				'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
				'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
				'itemView' => '_viewGastoImpresion',
				// 'viewData' => array( 'data' => null ),
				'ajaxUpdate' => false,
				// 'enablePagination'=>true
				'pager' => array (
						'header' => 'Ir a', // text before it
						'maxButtonCount' => 28 
				) 
		) );*/
		$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
		foreach ($resultados as $comp){
			echo $this->renderPartial ( '_viewGastoImpresion', array (
					'data' => $comp,
			), true );
		}
		foreach ( $resultados as $value ) {
			$montoTotalOP = $montoTotalOP + $value->gasto->Monto;
		}
	} else {
		echo "NO POSEE COMPROBANTES SELECCIONADOS";
	}
	?>
				
</div>
	</div>
</div>