<?php
$opPago = $data;
$data = $opPago->ordenPago;
?>
<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('numero_op')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->numero_op), array('ordenPago/update', 'id'=>$data->id_orden_pago)); ?>
	
</div>
		<div class='contenedor-columna-10'>
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . "/img/icons/mod.gif";
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Ver/Editar Orden Pago" />', array (
					'ordenPago/update',
					'id' => $data->id_orden_pago 
			), array (
					'target' => '_blank',
					'class' => 'linkClass' 
			) );
			?>
		</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	</div>
		<div class='contenedor-columna-40'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta')); ?>:</b>
	<?php echo CHtml::encode($data->cuenta!=null?$data->cuenta->getDescripcion():''); ?>
		</div>

	</div>

	<div class="contenedor-fila">
		<div class='contenedor-columna-60'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('observacion')); ?>:</b>
	<?php echo CHtml::encode($data->observacion); ?>
		</div>
		<div class='contenedor-columna-30 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); text-align: center;">
			<b><label>MONTO</label></b> <b>$ <?php echo " ".CHtml::encode($data->getMonto()); ?></b>
		</div>
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . '/img/cruzRed.png';
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Quitar Orden de Pago del Pago" />', array (
					'pago/deleteOrdenPago',
					'id' => $opPago->id_pago_orden_pago 
			), 			// ajax options
			array (
					// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
					'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); return false;',
					'update' => '#list_ordenes_pago' 
			), 
					// htmloptions
					array (
							'target' => '_blank',
							'class' => 'linkClass',
							'id' => 'addNewEntrevistas' 
					) );
			
			?>
		
	</div>
</div>
		<?php
		$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $data->id_orden_pago );
		$montoTotalOP = 0.00;
		if ($resultadosEntrev != null) {
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
					// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
					// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewGastoRow',
					// 'viewData' => array( 'data' => null ),
					'ajaxUpdate' => false,
					// 'enablePagination'=>true
					'pager' => array (
							'header' => 'Ir a', // text before it
							'maxButtonCount' => 28 
					) 
			) );
			/*
			 * $resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $data->id_orden_pago ); foreach ( $resultados as $value ) { $montoTotalOP = $montoTotalOP + $value->gasto->Monto; }
			 */
		} else {
			echo "NO POSEE COMPROBANTES SELECCIONADOS";
		}
		?>

