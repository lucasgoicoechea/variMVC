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
			Agregar Orden de Pago
			<?php

			echo CHtml::link ( "<img src='" . Yii::app ()->theme->baseUrl . "/img/icons/add.png' >", Yii::app ()->createUrl ( 'pago/agregarOrdenPago', array (
					"asDialog" => 1,
					"id_pago" => $id_pago 
			) ),
			// ajax options
			array (
			// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
							'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); return false;',
							'update' => '#list_ordenes_pago' 
							),
							// htmloptions
							array (
							'id' => 'addNewEntrevistas' 
							) );

							?>
		</h4>
		<div class="" id="list_ordenes_pago">
		<?php
		$montoTotalOP = 0.00;
		$resultadosEntrev = PagoOrdenPago::model ()->searchWithPago ( $model->id_pago );
		if ($resultadosEntrev !=null && sizeof ( $resultadosEntrev )> 0) {
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
			// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Ordenes de Pago	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
			// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewOrdenPago',
			// 'viewData' => array( 'data' => null ),
					'ajaxUpdate' => false,
			// 'enablePagination'=>true
					'pager' => array (
							'header' => 'Ir a', // text before it
							'maxButtonCount' => 28 
			)
			) );
			$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $model->id_pago );
			if (sizeof ( $resultados) > 0) {
				foreach ( $resultados as $value ) {
					$montoTotalOP = $montoTotalOP + $value->ordenPago->getMonto ();
				}}
		} else {
			echo "NO POSEE ORDENES DE PAGO SELECCIONADAS";
			$montoTotalOP = 0.00;
		}
		?>
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - ORDEN DE PAGO</label> </b> <b>$ <?php echo " ".CHtml::encode($montoTotalOP); ?>
					</b>
				</div>
			</div>
		</div>


		<?php
		// --------------------- begin new code --------------------------
		// add the (closed) dialog for the iframe
		$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
			'id' => 'cru-dialog',
			'options' => array (
					'title' => 'Actualizar datos',
					'autoOpen' => false,
					'modal' => true,
					'width' => 900,
					'height' => 400 
		)
		) );
		?>
		<iframe id="cru-frame" width="100%" height="100%"> </iframe>
		<?php

		$this->endWidget ();
		// --------------------- end new code --------------------------
		?>
	</div>
</div>
