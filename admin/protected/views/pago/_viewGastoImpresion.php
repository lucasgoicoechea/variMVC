
<!-- <div class="contenedor-tabla"> -->
<?php
 $opGasto = $data; 
 $data = $data->gasto;
?>
<!-- <div class="contenedor-fila">-->
		<div class='contenedor-columna-20'>
			<b>Tipo:</b>
	<?php echo CHtml::encode($data->tipoComprobante->getDescripcion()); ?>
			</div>
		<div class='contenedor-columna-20'>
			<b>Nro.:</b>
	<?php echo CHtml::encode($data->NumComprobante); ?>
			</div>
				<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaAsiento')); ?>:</b>
	<?php echo CHtml::encode($data->FechaAsiento); ?>
	</div>
		<br>
<!-- </div>
<div class="contenedor-fila"> -->
	<div class='contenedor-columna-30 center'
			style="border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 200px; text-align: center; padding: 5px;">
			<b><label>Importe</label></b> <b>$ <?php echo " ".CHtml::encode($data->getMontoTotal()); ?></b>
		</div>
	
		<div class='contenedor-columna-70'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php echo CHtml::encode($data->obra->getDescripcion()); ?>
		</div>
	<hr>
	

<!-- </div> -->
