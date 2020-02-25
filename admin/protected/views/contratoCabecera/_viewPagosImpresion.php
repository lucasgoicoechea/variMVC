
		<div class="titulo " >Pagos realizados</div>
			<div class="contenedor-fila subtitulo">
	   <div class="contenedor-columna-10">FECHA</div>
	   <div class="contenedor-columna-20">IMPORTE</div>
	   <div class="contenedor-columna-40">DETALLE</div>
	   <div class="contenedor-columna-20">COMPROBANTE</div>
	   <div class="contenedor-columna-10">Nro.</div>
	    
	</div>			
<?php
$gasto = new Gasto ();
$montoTotalPagos = 0;
$gastos = Gasto::model ()->searchWithContrato ( $model->id_contrato_cabecera );
if (count ( $gastos ) > 0) {  ?>

<?php 	foreach ( $gastos as $gasti ) {
	$montoTotalPagos = $montoTotalPagos + LGHelper::functions()->unformatNumber($gasti->Monto);
		?>
	<div class="contenedor-fila">
	   <div class="contenedor-columna-10"><?php echo $gasti->FechaAsiento; ?></div>
	   <div class="contenedor-columna-20" style="text-align: center"><?php echo $gasti->Monto; ?></div>
	   <div class="contenedor-columna-40"><?php echo $gasti->Detalle; ?></div>
	   <div class="contenedor-columna-20"><?php echo $gasti->tipoComprobante->Nombre; ?></div>
	   <div class="contenedor-columna-10"><?php echo $gasti->NumComprobante; ?></div>
	  	</div>
<?php
	
}
	?>
<div class="contenedor-fila">
			<div
				style="border-radius: 25px; width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>TOTAL PAGOS</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoTotalPagos ); ?></b>
			</div>
		</div>		
<?php } else {?>
	<div class="contenedor-fila">SIN PAGOS REALIZADOS</div>
<?php }?>
<div class="row-center">
     <span>
    <?php 
    if ($montoTotalPagos<$model->getPrecioMasAdicionales()) {
    	echo CHtml::link ( 'Pagar', $this->createUrl ( 'gasto/createContratoPagado', array('id_contrato_cabecera'=> $model->id_contrato_cabecera) ), array (
    			'style' => 'color: white',
    			'class' => 'btn btn-primary'
    	) );
    }
    else {
    	echo CHtml::link ( 'IMPORTE PAGADO ES IGUAL O SUPERIOR AL SUBCONTRATO, Agregue ITEM DE SUBCONTRATO para poder PAGAR', $this->createUrl ( 'gasto/createContratoPagado', array('id_contrato_cabecera'=> $model->id_contrato_cabecera) ), array (
    			'style' => 'color: red',
    			'class' => 'btn',
    			'disabled'=> true
    	) );
    }
	?>
	</span>
</div>