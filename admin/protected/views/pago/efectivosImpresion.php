<?php $efectivo = new EfectivoPago();
$provider = $efectivo->searchWithPago($id_pago);
if ($provider!=null && $provider->totalItemCount>0) {
	
?>
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">PAGOS EN EFECTIVO
						</th>
			</tr>
		</thead>

	</table>
<div class="view">
	<div class="form">
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'efectivo-pago-grid',
	'dataProvider'=>$provider,
	//'filter'=>$efectivo,
	'columns'=>array(
		//'id_efectivo_pago',
		'monto',
		'detalle',
		)
)); 
$montoTotalEfectivo = Pago::model()->getTotalMontoEfectivo($id_pago);?>
<div id="id_efectivo_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS EN EFECTIVO</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoTotalEfectivo); ?></b>
				</div>
			</div>
		</div>
		<br>
		<br>
	
</div>
</div>
<?php }?>