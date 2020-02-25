<?php
$chequePago = $data;
$data = $chequePago->cheque;
$idPago = $chequePago->id_pago;
?>
<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('serie')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->serie), array('cheque/update', 'id'=>$data->id_cheque)); ?>
	
</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Numero')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Numero), array('cheque/update', 'id'=>$data->id_cheque)); ?>
	
</div>
		<div class='contenedor-columna-10'>
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . "/img/icons/mod.gif";
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Ver/Editar Cheque" />', array (
					'cheque/update',
					'id' => $data->id_cheque 
			), array (
					'target' => '_blank',
					'class' => 'linkClass',
					'title' => 'Modificar Cheque' 
			) );
			?>
		</div>
		<div class='contenedor-columna-40'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_banco')); ?>:</b>
	<?php echo CHtml::encode($data->cuentaBanco->descripcion); ?>
	</div>
		<div class="contenedor-columna-5"> 
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . '/img/icons/delete_x.gif';
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Anular Cheque" />', Yii::app ()->createUrl ( 'pago/anularCheque', array (
					"asDialog" => 1,
					"id_pago" => $idPago,
					"id_cheque" => $data->id_cheque,
					'id' => $chequePago->id_pago_cheque 
			) ), 			// ajax options
			array (
					// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
					'onclick' => '$("#cru-dialog-cheque").dialog("open"); $("#cru-frame-cheque").attr("src",$(this).attr("href")); return false;',
					'update' => '#list_cheque',
					'title' => 'Anular Cheque' 
			), 
					// htmloptions
					array (
							'target' => '_blank',
							'class' => 'linkClass',
							'id' => 'anularCheque' 
					) );
			?>
					</div>
		<div class="contenedor-columna-5"> 
					<?php
					$imageUrl2 = Yii::app ()->theme->baseUrl . '/img/icons/window_new.png';
					echo CHtml::link ( '<img src="' . $imageUrl2 . '"
				alt="Quitar Cheque" />', array (
							'pago/reemplazarCheque',
							'id' => $chequePago->id_pago_cheque,
							"id_cheque" => $data->id_cheque,
							'id_pago' => $idPago 
					), 					// ajax options
					array (
							// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
							'onclick' => '$("#cru-dialog-cheque").dialog("open"); $("#cru-frame-cheque").attr("src",$(this).attr("href")); return false;',
							'update' => '#list_cheque',
							'title' => 'Reemplazar Cheque del Pago' 
					), 
							// htmloptions
							array (
									'target' => '_blank',
									'class' => 'linkClass',
									'id' => 'reemplazarCheque' 
							) );
					
					?>
		
	</div>

	</div>

	<div class="contenedor-fila">

		<div class='contenedor-columna-10'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaEmision')); ?>:</b>
	<?php echo CHtml::encode($data->FechaEmision); ?>
	</div>
		<div class="contenedor-columna-20">
			<b>A la orden:</b><?php echo CHtml::encode($data->a_la_orden); ?>
		</div>
		<div class="contenedor-columna-10">
			<b>Imp. Cheque:</b><?php echo CHtml::encode($data->porc_impuesto_cheque); ?>
		</div>
		<div class="contenedor-columna-10">
			<b>Imp. Deposito:</b><?php echo CHtml::encode($data->porc_impuesto_debito); ?>
		</div>
		<div class='contenedor-columna-30 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); text-align: center;">
			<b>
			<?php  if ($data->anulado){?>
				<span style="color: red">ANULADO</SPAN> <label
				style="text-decoration: line-through; color: red"> IMPORTE</label>
			<?php } else {?>
			<label> IMPORTE </label>
			<?php }?>	
			</b> <b>$ <?php echo " ".$data->Importe; ?></b>
		</div>
		<div class="contenedor-columna-10"> 
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . '/img/cruzRed.png';
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Quitar Cheque" />', array (
					'pago/deleteCheque',
					'id' => $chequePago->id_pago_cheque 
			), 			// ajax options
			array (
					// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
					'onclick' => '$("#cru-dialog-cheque").dialog("open"); $("#cru-frame-cheque").attr("src",$(this).attr("href")); return false;',
					'update' => '#list_cheque',
					'title' => 'Quitar Cheque del Pago' 
			), 
					// htmloptions
					array (
							'target' => '_blank',
							'class' => 'linkClass',
							'id' => 'addNewCheque' 
					) );
			?>
					</div>
	</div>

	<div class="contenedor-fila">

		<div class='contenedor-columna-20'>
			<b>Diferido:</b>
	<?php echo $data->id_cheque_dias!=0?$data->chequeDias->descripcion:''; ?>
	</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaPago')); ?>:</b>
	<?php echo CHtml::encode($data->FechaPago); ?>
	</div>
	<?php if (isset($data->id_cheque_reemplaza) && $data->id_cheque_reemplaza!=null  && $data->id_cheque_reemplaza!=0) { ?>
		<div class='contenedor-columna-30'>
		<b>REEMPLAZA AL CHEQUE: </b>
			<?php echo $data->chequeReemplazo->getDescripcion(); ?>
			</div>
	<?php }?>
	</div>
		<?php
		
		echo CHtml::link ( Yii::t ( 'app', '<<<<<  Completar >>>>>>' ), '', array (
				'class' => 'search-button' . $data->id_cheque,
				'onclick' => '$(".search-form' . $data->id_cheque . '").toggle();' 
		) );
		?>
<div class="search-form<?php echo $data->id_cheque;?>"
		style="display: none">
<?php

$this->renderPartial ( '_updateCheque', array (
		'model' => $data,
		'id_pago' => $idPago 
) );
?>
</div>
</div>
