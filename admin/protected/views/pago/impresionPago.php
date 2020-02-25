<?php  if ($model!== null){?>
<html>
<head>
<style>
body {
	font-family: sans-serif;
	font-size: 10pt;
}

p {
	margin: 0pt;
}

td {
	vertical-align: top;
}

.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}

.items  thead tr {
	background-color: #EEEEEE;
	text-align: center;
}

.items td.blanktotal {
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
}

.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}

.titulo {
	text-align: center;
	background-color: #5164AE;
	color: #FFFFFF;
}

.header {
	text-align: left;
}

.contenedor-tabla {
	background-color: #FFFFFF;
	border-color: #B8C1CB;
	border-style: solid;
	border-width: 1px;
	display: block;
	float: left;
	overflow-x: hidden;
	overflow-y: auto;
	width: 99%;
}
/*.contenedor-tabla {
	display: table;
	width:575px;
}*/
.contenedor-subtitulo {
	border-bottom: 1px solid #D1A19E;
	text-align: center;
	display: block;
	float: left;
	margin-left: 2%;
	min-height: 2px;
	padding-bottom: 2px;
	padding-top: 2px;
	width: 95.7%;
}

.contenedor-fila {
	border-bottom: 1px solid #D1EBFE;
	display: block;
	float: left;
	margin-left: 2%;
	min-height: 20px;
	padding-bottom: 10px;
	padding-top: 5px;
	width: 95.7%;
}

.contenedor-fila-header {
	border-bottom: 1px solid #D1EBFE;
	display: block;
	float: left;
	padding-top: 5px;
	width: 95.7%;
}

.contenedor-columna {
	display: block;
	float: left;
	width: 50%;
}

.contenedor-columna-50 {
	display: block;
	float: left;
	width: 50%;
}

.contenedor-columna-40 {
	display: block;
	float: left;
	width: 40%;
}

.contenedor-columna-30 {
	display: block;
	float: left;
	width: 30%;
}

.contenedor-columna-25 {
	display: block;
	float: left;
	width: 25%;
}

.contenedor-columna-20 {
	display: block;
	float: left;
	width: 20%;
}

.contenedor-columna-60 {
	display: block;
	float: left;
	width: 60%;
}

.contenedor-columna-70 {
	display: block;
	float: left;
	width: 70%;
}

.contenedor-columna-80 {
	display: block;
	float: left;
	width: 80%;
}
@page :last {
    header: myfooter;
}

@page :first {
    header: myheader;
}
</style>
</head>
<body>

	<!--mpdf
 <htmlpageheader name="myheader" style="display:none">
 <table width="100%" style="height:200px; border-style: solid;
    border-bottom:  dotted #109a00;"><tr>
 <td width="20%" style="color:#0000BB;"><span style="text-align: left">
		<b>Fecha Impresión: </b><?php echo date("d/m/Y"); ?> </span> </td>
		<td>Teléfono: (0221) 479-3174 - <br>rodrigoalba@ra-servicios.com</td>
 <td width="50%" style="text-align: right;"> 
 
	<img align="left" height="120" 
		src="<?php echo Yii::app ()->theme->baseUrl . '/img/logo-ra.jpg'?>"> </td>
 </tr></table>	
 </htmlpageheader>
 
<htmlpagefooter name="myfooter" style="display:none">
 Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
 <sethtmlpagefooter name="myfooter" value="on" />
 mpdf-->
	<br>
	<h1 style="text-align: center">ORDEN DE PAGO - Número: <?php echo $model->numero;?></h1>
	<h3>
		<div class="titulo">PROVEEDOR (Télefono): <?php echo $model->getProveedorDescripcion();?></div>
	</h3>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="header" width="90%">FECHA DE PAGO:
						<?php echo LGHelper::functions()->displayFecha($model->fecha_cobro);?></th>
			</tr>
		</thead>
	</table>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">COMPROBANTES A PAGAR
						</th>
			</tr>
		</thead>

	</table>
				<?php
	
	$op = $model->getOrdenPago ();
	echo $this->renderPartial ( 'comprobantesImpresion', array (
			'model' => $op->ordenPago,
			'id_orden_pago' => $op->id_orden_pago 
	), true );
	?>
	<div class="contenedor-tabla" style="color: red" id="totalesGrales">
<?php $this->actualizarTotalesGrales($model->id_pago ); ?>
</div>
	
	<?php

echo $this->renderPartial ( 'chequesImpresion', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
), true );

?>
	
	<?php echo $this->renderPartial ( 'transferenciasImpresion', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
), true )?>
	
	<?php echo $this->renderPartial ( 'efectivosImpresion', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
), true )?>
		
		<?php echo $this->renderPartial ( 'tarjetasImpresion', array (
			'model' => $model,
			'id_pago' => $model->id_pago 
	), true )?>
<?php } ?>
<br>
<br>
<br>
<br>
<br>
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
 <span style="font-weight: bold; float: left">Firma de Proveedor <?php echo "";?></span>
<span style="font-weight: bold; float: right">Aclaración de Firma <?php echo "";?></span><br>
</body>
</html>
<?php ?>