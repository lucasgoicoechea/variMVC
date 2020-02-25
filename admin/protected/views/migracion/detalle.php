<div class="subtitulo">Detalle de Migración</div>
<div>
<?php echo $logs; ?>
</div>
<br>
<div class="subtitulo">Gastos registrados</div>

<?php 

foreach(  $gastos as $model ) {  ?>
<table class="items" width="100%"
style="font-size: 9pt; border: solid;">
<tr>PROVEEDOR (Télefono): <?php echo $model->getProveedorDescripcion();?> -- GASTO - Número: <?php echo $model->Codigo;?>
<b>-OBRA: </b> <?php echo $model->obra->getDescripcion(); ?></tr>
<tr>   
	<th class="header" width="20%">FECHA DE PAGO:</th>
	<td width="20%"><?php echo $model->FechaFactura;?></td>
	<th class="header" width="20%">Comprobante:</th>
	<td width="20%">Forma	<?php echo $model->tipoComprobante->Nombre; ?> - 
	<?php if ($model->NumComprobante!=null && $model->NumComprobante>0) { echo $model->NumComprobante;}
	else echo 'SIN NÚMERO';
	?></td>
	<th class="header" width="20%">EN CONCEPTO DE:</th>
	<td><?php echo $model->Detalle!=''?$model->Detalle:'Sin Detalles';?></td>
	<th class="header" width="20%">IMPORTE TOTAL:</th>
	<td><?php echo '$ '.$model->getMontoTotal();?></td>
</tr>

<!-- FIN ITEMS -->
</table>
<div class="linea"></div>
<?php } ?>