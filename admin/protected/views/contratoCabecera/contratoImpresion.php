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
.contenedor-columna-10 {
	display: block;
	float: left;
	width: 10%;
}
</style>
</head>
<body>

	<!--mpdf
 <htmlpageheader name="myheader">
 <table width="100%" style="height:300px; border-bottom:  dotted #109a00;"><tr>
 <td width="20%" style="color:#0000BB;"><div style="text-align: left">
		<b>Fecha Impresión: </b><?php echo date("d/m/Y"); ?> </div> </td>
 <td width="80%" style="text-align: right;"> 
	<img align="left" height="120" 
		src="<?php echo Yii::app ()->theme->baseUrl . '/img/logo-ra.jpg'?>"><br> </td>
 </tr></table>
 </htmlpageheader>
 
<htmlpagefooter name="myfooter">
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
 Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
 <sethtmlpagefooter name="myfooter" value="on" />
 mpdf-->
	<br>
	<h1 style="text-align: center">DETALLES DE SUBCONTRATO - Número: <?php echo $model->codigo;?></h1>
	<h3>
		<b>OBRA: </b> <?php echo $model->obra->getDescripcion(); ?></h3>
	<div class="titulo">PROVEEDOR (Télefono): <?php echo $model->getProveedorDescripcion();?></div>
	<table class="items" width="100%"
		style="font-size: 11pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr style="border: solid;">
				<th class="header" width="20%">DETALLE:
			</th>
				<td><?php echo $model->descripcion!=''?$model->descripcion:'Sin Detalles';?>
			</td>
			</tr>
			<tr style="border: solid;">
				<th class="header" width="20%">FECHA:</th>
				<td width="90%"><?php echo $model->Fecha;?></td>
			</tr>
			<tr style="border: solid;">
				<th class="header" width="20%">PLAZO:</th>
				<td width="90%"><?php echo $model->Plazo;?></td>
			</tr>
			<tr style="border: solid;">
				<th class="header" width="20%">PRECIO:</th>
				<td width="90%">	<?php echo $model->Precio;?></td>
			</tr>			
			<tr style="border: solid;">
				<th class="header" width="20%">Solicitado por:</th>
				<td width="90%">	<?php echo $model->getUsuarioSolicito();?></td>
			</tr>
						
			<tr style="border: solid;">
				<th class="header" width="20%">Autorizado por:</th>
				<td width="90%">	<?php echo $model->getUsuarioAutorizo();?></td>
			</tr>
			<tr style="border: solid;">
				<th class="header" width="20%">ACUERDO:</th>
				<td width="90%">	<?php echo $model->Acuerdo;?></td>
			</tr>
					
 <!-- FIN ITEMS -->
			
			</thead>
		<tbody>
	</table>
	<div class="contenedor-tabla">
<?php echo $items; ?>
</div>
<div class="contenedor-tabla">
<?php 	echo $this->renderPartial ( '_viewContrato', array (
		'model' => $model
) ); ?>
</div>
        
        <div class="contenedor-tabla"><BR><BR><BR><BR>FIRMA PROVEEDOR:-------------------------------------------------- FIRMA EMPRESA:--------------------------------------</div>
<?php } ?>
</body>
</html>
<?php ?>