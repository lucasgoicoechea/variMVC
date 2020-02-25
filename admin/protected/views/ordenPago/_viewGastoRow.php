
<div class="contenedor-tabla">
<?php
 $opGasto = $data; 
 $data = $data->gasto;
?>
<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_comprobante')); ?>:</b>
	<?php echo CHtml::encode($data->tipoComprobante->getDescripcion()); ?>
			</div>
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('NumComprobante')); ?>:</b>
	<?php echo CHtml::encode($data->NumComprobante); ?>
			</div>
		<div class='contenedor-columna-30 center'
			>
			<b><label>MONTO</label></b> <b>$ <?php echo " ".CHtml::encode($data->Monto); ?></b>
		</div>
	</div>	
	
<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Codigo')); ?>:</b>
	<?php
	echo CHtml::encode ( $data->Codigo );
	?>
</div>
		<div class='contenedor-columna-10'>
			<?php
			$imageUrl = Yii::app ()->theme->baseUrl . "/img/icons/mod.gif";
			echo CHtml::link ( '<img src="' . $imageUrl . '"
				alt="Ver/Editar Comprobante" />', array (
					'gasto/update',
					'id' => $data->id_gasto 
			), array (
					'target' => '_blank',
					'class' => 'linkClass' 
			) );
			?>
		</div>
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaAsiento')); ?>:</b>
	<?php echo CHtml::encode($data->FechaAsiento); ?>
	</div>
		<div class='contenedor-columna-40'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::encode($data->obra->getDescripcion()); ?>
		</div>
		<div class='contenedor-columna'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor->getDescripcion()); ?>
			</div>
	</div>

</div>
