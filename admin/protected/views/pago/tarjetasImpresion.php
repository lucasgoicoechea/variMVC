<?php $tarjeta = new TarjetaPago();
$provider = $tarjeta->searchWithPago($id_pago);
if ($provider!=null && $provider->totalItemCount>0){
?>	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">PAGOS CON TARJETA
						</th>
			</tr>
		</thead>

	</table>
<div class="view">
	<div class="form">

<?php 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tarjeta-pago-grid',
	'dataProvider'=>$provider,
	//'filter'=>$tarjeta,
	'columns'=>array(
				array (
						'name' => 'id_tarjeta',
						'value' => '$data->tarjeta->descripcion',
						),
		'monto',
		'fecha_pago',
		'detalle',
		))); 
$montoTotalTarjeta = Pago::model()->getTotalMontoTarjeta($id_pago);?>
<div id="id_tarjeta_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS CON TARJETA</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalTarjeta); ?></b>
				</div>
			</div>
		</div>
		<br>
		<br>
	
</div>
<?php }?>