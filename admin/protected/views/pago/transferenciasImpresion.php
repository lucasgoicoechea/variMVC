<?php $transferencia = new TransferenciaPago ();
$provider = $transferencia->searchWithPago ( $id_pago );
if ($provider !=null && sizeof ( $provider )> 0 && $provider->totalItemCount > 0) {
?>
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">TRANSFERENCIAS BANCARIAS
						</th>
			</tr>
		</thead>

	</table>
<div class="view">
	<div class="form">


<?php


	$this->widget ( 'zii.widgets.grid.CGridView', array (
			'id' => 'transferencia-pago-grid',
			'dataProvider' => $provider,
			//'filter'=>null,
			'columns' => array (
					array (
							'name' => 'id_cuenta_banco',
							'value' => '$data->cuentaBanco->descripcion',
					),
					'referencia',
					'cbu_destino',
					'monto'),
					
			) 
	) ;
$montoTotalTransferencias = Pago::model ()->getTotalMontoTransfenrencia ( $id_pago );
?>
<div id="id_transferencia_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS CON TRANSFERENCIAS</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalTransferencias); ?></b>
				</div>
			</div>
		</div>
		<br>
	</div>
</div>
<?php }?>