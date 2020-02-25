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
.subtitulo {
	text-align: center;
	
}

.header {
	text-align: left;
}
 	.linea {  
  height: 1px;
 border-width: 1px;
  border-color: red;
   border-style: dashed; 
   width: 100%;
} 
 	.cuadro {  
  height: 1px;
 border-width: 2px;
  border-color: black;
   border-style: solid; 
   width: 100%;
   float: right;
   text-align: right;
} 
</style>
</head>
<body>

	<!--mpdf
 <htmlpageheader name="myheader">
 <table width="100%"><tr>
 <td  style="color:#0000BB;"><div style="text-align: left">
		<b>Fecha Impresión: </b><?php echo date("d/m/Y"); ?> </div> </td>
 <td width="80%" style="text-align: right;"> 
	<img align="left" height="60" 
		src="<?php echo Yii::app ()->theme->baseUrl . '/img/logo-ra.jpg'?>"> </td>
 </tr></table>
 </htmlpageheader>
 
<htmlpagefooter name="myfooter">
<h4>Firma de quien Solicitó: <?php echo "";?></h4><br><br><br>
<h4>Aclaración de Firma: <?php echo "";?></h4><br>
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
 Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
 <sethtmlpagefooter name="myfooter" value="on" />
 mpdf-->
	<h3>
	<div class="subtitulo">RECIBO DE TRANSFERENCIA ENTRE CUENTAS</div>	
		<div class="cuadro">ORIGINAL</div>
	<div class="titulo">	<b>CUENTA ORIGEN: </b> <?php echo $model->cuentaOrigen->getDescripcion(); ?></h3></div>
	<div class="titulo">CUENTA DESTINO: <?php echo $model->cuentaDestino->getDescripcion();?></div>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
		   <tr>
				<th class="header" width="90%">NRO. TRANSFERENCIA:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->id_transferencia;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">FECHA TRANSFERENCIA:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->fecha;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">IMPORTE:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->importe;?></td>
			</tr>
		 <tr>
				<th class="header" width="90%">EN CONCEPTO DE:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->descripcion;?></td>
			</tr>
		
 <!-- FIN ITEMS -->
			
			</thead>
		<tbody>
	</table>
	<br><br>
	<div class="linea"></div>
	
	<table width="100%" style="height:130px"><tr>
 <td width="20%" style="color:#0000BB;"><div style="text-align: left">
		<b>Fecha Impresión: </b><?php echo date("d/m/Y"); ?> </div> </td>
 <td width="80%" style="text-align: right;"> 
	<img align="left" height="60" 
		src="<?php echo Yii::app ()->theme->baseUrl . '/img/logo-ra.jpg'?>"><br> </td>
 </tr></table>
 	<h3>
	<div class="subtitulo">RECIBO DE TRANSFERENCIA ENTRE CUENTAS</div>
			<div class="cuadro">DUPLICADO</div>
	<div class="titulo">	<b>CUENTA ORIGEN: </b> <?php echo $model->cuentaOrigen->getDescripcion(); ?></h3></div>
	<div class="titulo">CUENTA DESTINO: <?php echo $model->cuentaDestino->getDescripcion();?></div>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
		   <tr>
				<th class="header" width="90%">NRO. TRANSFERENCIA:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->id_transferencia;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">FECHA TRANSFERENCIA:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->fecha;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">IMPORTE:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->importe;?></td>
			</tr>
		   <tr>
				<th class="header" width="90%">EN CONCEPTO DE:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->descripcion;?></td>
			</tr>
		
 <!-- FIN ITEMS -->
			
			</thead>
		<tbody>
	</table>
<?php } ?>
</body>
</html>
<?php ?>