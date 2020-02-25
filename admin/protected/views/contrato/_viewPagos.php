<div class="form">
		<div class="subtitulo">Pagos realizados</div>
			<div class="contenedor-fila subtitulo">
	   <div class="contenedor-columna-10">FECHA</div>
	   <div class="contenedor-columna-20">IMPORTE</div>
	   <div class="contenedor-columna-30">DETALLE</div>
	   <div class="contenedor-columna-20">COMPROBANTE</div>
	   <div class="contenedor-columna-20">Nro. COMPROBANTE</div>
	</div>
<?php
$gasto = new Gasto ();
$montoTotalPagos = 0;
$gastos = Gasto::model ()->searchWithContrato ( $model->id_contrato );
if (count ( $gastos ) > 0) {  ?>

<?php 	foreach ( $gastos as $gasti ) {
	$montoTotalPagos = $montoTotalPagos + $gasti->Monto;
		?>
	<div class="contenedor-fila">
	   <div class="contenedor-columna-10"><?php echo $gasti->FechaAsiento; ?></div>
	   <div class="contenedor-columna-20"><?php echo $gasti->Monto; ?></div>
	   <div class="contenedor-columna-30"><?php echo $gasti->Detalle; ?></div>
	   <div class="contenedor-columna-20"><?php echo $gasti->tipoComprobante->Nombre; ?></div>
	   <div class="contenedor-columna-20"><?php echo $gasti->NumComprobante; ?></div>
	</div>
<?php
	
}
	?>
	
<?php } else {?>
	<div class="contenedor-fila">SIN PAGOS REALIZADOS</div>
<?php }?>
<div class="contenedor-fila">
			<div
				style="border-radius: 25px; width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>TOTAL PAGOS</label></b> <b>$ <?php echo " ".CHtml::encode($model->getPrecioMasAdicionales()); ?></b>
			</div>
			<div
				style="border-radius: 25px; width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>PENDIENTE PAGO</label></b> <b>$ <?php echo " ".CHtml::encode($model->getPrecioMasAdicionales()-$montoTotalPagos); ?></b>
			</div>
		</div>	
<div class="row-center">
     <span>
    <?php 
	echo CHtml::link ( 'Pagar', $this->createUrl ( 'gasto/createContratoPagado', array('id_contrato'=> $model->id_contrato) ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
</div>
</div>			