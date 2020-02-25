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

		<h4 class="titulo">Agregar comprobante
<?php

echo CHtml::link ( "<img src='" . Yii::app ()->theme->baseUrl . "/img/icons/add.png' >", Yii::app ()->createUrl ( 'ordenPago/agregarComprobante', array (
		"asDialog" => 1,
		"id_orden_pago" => $id_orden_pago 
) ), 
		// ajax options
		array (
				// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
				'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); return false;',
				'update' => '#list_entrevistas' 
		), 
		// htmloptions
		array (
				'id' => 'addNewEntrevistas' 
		) )
// 'href' => Yii::app ()->createUrl ( 'usuariosObservaciones/create', array ("asDialog" => 1,"id_usuario" => $model->id) ),
;
?>
</h4>
		<div class="" id="list_entrevistas">
	<?php
	$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $model->id_orden_pago );
	$montoTotalOP = 0.00;
	if ($resultadosEntrev != null) {
		$this->widget ( 'zii.widgets.CListView', array (
				'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
				'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
				'itemView' => '_viewGasto',
				// 'viewData' => array( 'data' => null ),
				'ajaxUpdate' => false,
				// 'enablePagination'=>true
				'pager' => array (
						'header' => 'Ir a', // text before it
						'maxButtonCount' => 28 
				) 
		) );
		$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
		foreach ( $resultados as $value ) {
			$montoTotalOP = $montoTotalOP + $value->gasto->Monto;
		}
	} else {
		echo "NO POSEE COMPROBANTES SELECCIONADOS";
	}
	?>
		
		<div class="contenedor-fila">
			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalOP); ?></b>
			</div>
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