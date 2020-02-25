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
    color: #1d3c81;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-variant: normal;
    font-weight: bold;
    text-decoration: none;
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
 
<htmlpagefooter name="myfooter">
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
  Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
 <sethtmlpagefooter name="myfooter" value="on" />
 mpdf-->
	<br>
	<h1 style="text-align: center"><?php echo $titulo;?></h1>
	<h3>
			<div class="row-center" 
		style="<?php
		if (! $model->cerrada) {
			if (strlen($cierresPendientes)>0) {
				echo "background-color: orange; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
			}
			else 
				echo "background-color: green; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
		} else {
			echo "background-color: red; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
		}
		?>" >
		<span style="color: white; font-size: 16px; font-family: monospace;"><?php
		
		if (! $model->cerrada) {
            if (strlen($cierresPendientes)>0)  {
                echo 'EXISTEN CIERRES PENDIENTES ANTERIORES A '.LGHelper::functions()->displayFecha($model->fecha).':'.$cierresPendientes;
            }
			else echo "PERMITE CIERRE DE CAJA".'  <--- '.LGHelper::functions()->displayFecha($model->fecha).' --->';
		} else
			echo "CIERRE DE CAJA REALIZADO".'  <--- '.LGHelper::functions()->displayFecha($model->fecha).' --->';
		?>
	</span>

	</div>
	</h3>
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="header" width="90%"></th>
			</tr>
		</thead>
	</table>

<div class="contenedor-tabla">

	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Gastos Diarios Pagados</th>
			</tr>
		</thead>
	</table>

<?php

echo $this->renderPartial ( 'gastosImpresion', array (
		'caja' => $model,
		'pagados' => true,
		'id_caja' => $model->id_caja 
), true );

?>

</div>
<div class="contenedor-tabla">	
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Gastos Diarios Pendientes de Pago</th>
			</tr>
		</thead>
	</table>
<?php

echo $this->renderPartial ( 'gastosImpresion', array (
		'caja' => $model,
		'pagados' => false,
		'id_caja' => $model->id_caja 
), true );

?>
</div>
		
			<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Saldos Gastos por Cuenta</th>
			</tr>
		</thead>
	</table>
	<br>
<div class="contenedor-tabla">	
<?php

echo $this->renderPartial ( 'saldosGastosPorCuenta', array (
		'id_caja' => $model->id_caja 
), true );

?>
</div>
	<div class="contenedor-tabla">
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Transferencias entre Cuentas</th>
			</tr>
		</thead>
	</table>
<?php

echo $this->renderPartial ( 'transferenciasCuentasImpresion', array (
		'model' => $model
), true )?>
</div>
<div class="contenedor-tabla">
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Cheques Emitidos</th>
			</tr>
		</thead>
	</table>
	
	<?php

echo $this->renderPartial ( 'chequesEmitidosImpresion', array (
		'caja' => $model 
), true )?>

	</div>
	
	<div class="contenedor-tabla">
	<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Transferencias Banco</th>
			</tr>
		</thead>
	</table>
<?php
$model->fechaDesde = $model->fecha;
$model->fechaHasta = $model->fecha;
echo $this->renderPartial ( 'transferenciaBancoImpresion', array (
		'caja' => $model
), true );
 ?>
</div>	
<div class="contenedor-tabla">
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Pagos con Tarjeta</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'tarjetasImpresion', array (
			'caja' => $model 
	), true )?>

</div>

				<div class="contenedor-tabla">
				
<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Cobros</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'cobrosImpresion', array (
			'caja' => $model 
	), true )?>
</div>
<div class="contenedor-tabla">

<table class="items" width="100%"
		style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">
		<thead>
			<tr>
				<th class="subtitulo" width="90%">Ingresos a Cuenta</th>
			</tr>
		</thead>
	</table>
	<?php
	echo $this->renderPartial ( 'ingresosACuentaImpresion', array (
			'caja' => $model 
	), true )?>

</div>
<?php } ?>

</body>
</html>
<?php ?>