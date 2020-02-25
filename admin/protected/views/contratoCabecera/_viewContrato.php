<div class="form">
	<div class="titulo ">Items de Subcontrato</div>
	<div class="contenedor-fila subtitulo">
		<div class="contenedor-columna-10">FECHA</div>
		<div class="contenedor-columna-10">IMPORTE</div>
		<div class="contenedor-columna-60">DETALLE</div>
		<div class="contenedor-columna-10">PLAZO</div>
	</div>
<?php
$contrato = new Contrato ();
$montoTotalPagos = 0;
$montoPagos = 0;
$gastos = Gasto::model ()->searchWithContrato ( $model->id_contrato_cabecera );
//echo 'ddd'. $model->id_contrato_cabecera;
if (count ( $gastos ) > 0) {
	foreach ( $gastos as $gasti ) {
		$montoPagos = $montoPagos + LGHelper::functions()->unformatNumber($gasti->Monto);
	}
}
$contratos = Contrato::model ()->searchWithContrato ( $model->id_contrato_cabecera );
if (count ( $contratos ) > 0) {
	?>

<?php
	
foreach ( $contratos as $contr ) {
		$montoTotalPagos = $montoTotalPagos + LGHelper::functions()->unformatNumber($contr->Precio);
		?>
	<div class="contenedor-fila"
		style="font-family: sans-serif; font-size: 7pt;">
		<div class="contenedor-columna-10"><?php echo $contr->Fecha; ?></div>
		<div class="contenedor-columna-10"><?php echo $contr->Precio; ?></div>
		<div class="contenedor-columna-60"><?php echo $contr->Detalle; ?></div>
		<div class="contenedor-columna-10"><?php echo $contr->Plazo; ?></div>
<div class="contenedor-columna-10"><a style="color: white" class="btn btn-primary"><img src="/apps/ralbaMVC/admin/themes/prolab_old/img/icons/b_drop.png" alt=""></a></div>

	</div>
<?php
	}
	
		

	?>

<?php } else {?>
	<div class="contenedor-fila">SIN ITEMS DE CONTRATO</div>
<?php }?>
<div class="contenedor-fila">
<div			style="border: solid 1px; border-radius: 25px; width: 150px; text-align: center; padding: 5px;"
			class="contenedor-columna-40">
			<b><label>TOTAL IMPORTE</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($model->getPrecioMasAdicionales()); ?></b>
		</div>
		<div
			style="border: solid 1px; border-radius: 25px; width: 150px; text-align: center; padding: 5px;"
			class="contenedor-columna-40">
			<b><label>TOTAL PAGOS</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoPagos); ?></b>
		</div>
		<div
			class="contenedor-columna-20">
			<label>    </label>
		</div>
		<div
			style="border: solid 1px;border-radius: 25px; width: 250px; text-align: center; padding: 5px;"
			class="contenedor-columna-40">
			<b><label>PENDIENTE PAGO</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($model->getPrecioMasAdicionales() -$montoPagos ); ?></b>
		</div>
	</div>		
<div class="row-center"></div>

</div>
