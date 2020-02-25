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
</style>
</head>
<body>

	<!--mpdf
 <htmlpageheader name="myheader">
 <table width="100%" style="height:300px"><tr>
 <td width="20%" style="color:#0000BB;"><div style="text-align: left">
		<b>Fecha Impresión: </b><?php echo date("d/m/Y"); ?> </div> </td>
 <td width="80%" style="text-align: right;"> 
	<img align="left" height="120" 
		src="<?php echo Yii::app ()->theme->baseUrl . '/img/logo-ra.jpg'?>"><br> </td>
 </tr></table>
 </htmlpageheader>
 
<htmlpagefooter name="myfooter">
<h4>Firma de quien Recibe: <?php echo "";?></h4><br><br><br>
<h4>Aclaración de Firma: <?php echo "";?></h4><br>
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
 Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
 <sethtmlpagefooter name="myfooter" value="on" />
 mpdf-->
	<br>
	<h1 style="text-align: center">ORDEN DE COMPRA - Número: <?php echo $model->numero_orden;?></h1>
	<h3>
		<b>OBRA: </b> <?php echo $model->obra->getDescripcion(); ?></h3>
	<div class="titulo">PROVEEDOR: <?php echo $model->proveedor->getDescripcion();?></div>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="header" width="90%">FECHA DE ORDEN:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->Fecha;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">SOLICITO:</th>
			</tr>
				<tr>
				<th class="header" width="90%">ATENCIÓN EN PROVEEDOR:</th>
			</tr>
			<tr>
				<td width="90%"><?php echo $model->Atencion;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">SOLICITO:</th>
			</tr>		
			<tr>
				<td width="90%">	<?php echo $model->Solicitado;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">AUTORIZO:</th>
			</tr>
			
			<tr>
				<td width="90%">	<?php echo $model->Autorizo;?></td>
			</tr>
			
			<tr>
				<th class="header" width="90%">RECIBE:</th>
			</tr>
			<tr>
			<td width="90%"><?php echo $model->Recibe;?></td>
			</tr>
			<tr>
				<th class="header" width="90%">ENTREGA:</th>
			</tr>
			<tr>
						<td>
			   <?php echo $model->Entrega;?>
			</td>
						</tr>
		
			
			<tr>
				<th class="header" width="90%">DETALLE:
			</th>
			
			</tr>
			<tr>
				
				<td><?php echo $model->Detalle!=''?$model->Detalle:'Sin Detalles';?>
			</td>
			
			</tr>
		 
		
 <!-- FIN ITEMS -->
			
			/thead>
		<tbody>
	</table>
<?php } ?>
</body>
</html>
<?php ?>