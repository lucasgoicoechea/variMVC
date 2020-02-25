<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/mainPublic'); ?>
<style type="text/css">
.error {
	background-color: #BC1010;
	padding: 6px 12px;
	border-radius: 4px;
	color: white;
	font-weight: bold;
	margin-left: 16px;
	margin-top: 6px;
	position: absolute;
}
.error-sumary {
	background-color: #BC1010;
	border-radius: 4px;
	color: white;
	font-weight: bold;
	margin-left: 16px;
}


.error:before {
	content: '';
	border-top: 8px solid transparent;
	border-bottom: 8px solid transparent;
	border-right: 8px solid #BC1010;
	border-left: 8px solid transparent;
	left: -16px;
	position: absolute;
	top: 5px;
}

.errorPreguntas {
	background-color: #BC1010;
	border-radius: 4px 4px 4px 4px;
	color: white;
	float: right;
	font-weight: bold;
	margin-left: 400px;
	margin-top: 10px; -
	-opacity: 0.4;
	padding: 6px 12px;
	position: absolute;
}

.errorPreguntas:before {
	content: '';
	border-top: 8px solid transparent;
	border-bottom: 8px solid transparent;
	border-right: 8px solid #BC1010;
	border-left: 8px solid transparent;
	left: -16px;
	position: absolute;
	top: 5px;
}

span.validator {
	background-image: url("<?php echo Yii::app()->theme->baseUrl;?>/img/validator.gif");
	background-position: left center;
	background-repeat: no-repeat;
	color: #CC0000;
	display: inline;
	float: left;
	font-size: 10px;
	height: 15px;
	line-height: 15px;
	margin: 0;
	padding: 0;
	text-align: left;
	text-indent: 6px;
	vertical-align: baseline;
	width: 90%;
}

h3.titulon span {
	background-color: #31B6A3;
	color: #FFFFFF;
	font: 16px/26px 'TheSans', 'Arial';
	padding: 3px 8px 2px 12px;
}

p.botons input { -
	-background: -moz-linear-gradient(center top, #22A5D3 0%, #118FC2 100%)
		repeat scroll 0 0 transparent;
	background: -moz-linear-gradient(center top, #FF0000 0%, #111 100%)
		repeat scroll 0 0 transparent;
	background: #DC143C;
	border-radius: 3px 3px 3px 3px;
	border-style: none;
	color: #FFFFFF;
	cursor: pointer;
	font: bold 30px 'Arial';
	height: 65px;
	margin-bottom: 20px;
	margin-top: 5px;
	padding-left: 10px;
	padding-right: 8px;
	text-transform: uppercase;
	text-align: center;
}

table {
	width: 80%;
}

table th,td { -
	-width: 25%;
	border-left: 1px solid #CCCCCC;
	border-top: 1px solid #CCCCCC;
	color: black;
	font: bold 12px/16px Arial, sans-serif;
	padding: 5px 0;
	text-align: left;
	vertical-align: middle;
}

.wrap-file {
	border-bottom: 1px solid #E5EFFB;
	display: block;
	float: left;
	margin: 0;
	min-height: 40px;
	overflow: hidden;
	padding: 0;
	width: 100%;
}

.tns_container {
	border-spacing: 4px;
}

.tns_cell {
	background: url("<?php echo Yii::app()->theme->baseUrl;?>/img/bg_headernews.png") repeat-x scroll center top
		transparent;
	height: 65px;
	padding: 4px;
	vertical-align: top;
	width: 170px;
}

.content {
	background: url("<?php echo Yii::app()->theme->baseUrl;?>/img/bg_slotlet.jpg") repeat-x scroll center bottom
		#FFFFFF;
	padding: 35px 15px 15px;
	text-align: left;
	min-width: 910px;
}

color1 {
	background: none repeat scroll 0 0 #CCCCFF;
	padding: 2px 6px 4px;
}

.banner {
	background: url("<?php echo Yii::app()->theme->baseUrl;?>/img/pagemenu-bg.png") repeat-x scroll 0 0
		transparenjavascript:document.forms['EditForm'].screen.value=3;
	document .forms['EditForm'].submit(); t;
	width: 100%;
}

.sombra {
	color: #000;
	background: #ccc;
}

.sombra table {
	position: relative;
	left: -8px;
	top: -9px;
	width: 100%;
	background: url("<?php echo Yii::app()->theme->baseUrl;?>/img/pagemenu-bg.png") repeat-x scroll 0 0
		transparent;
}

.shadow {
	background: #96BA3A;
	text-align: left;
	-moz-box-shadow: 3px 3px 4px #111;
	-webkit-box-shadow: 3px 3px 4px #111;
	box-shadow: 3px 3px 4px #111;
	/* IE 8 */
	-ms-filter:
		"progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#111111')";
	/* IE 5.5 - 7 */
	filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135,
		Color='#111111');
}

.shadowrel {
	font: bold 12px/16px Arial, sans-serif;
}

.relaciona {
	border-right: 1px solid #CCCCCC; -
	-border-top: 1px solid #CCCCCC;
	display: table-cell;
	max-width: 99px;
	min-width: 99px;
	text-align: center;
}
</style>
</head>
<body>
	<div style="border-collapse: collapse;" frame="void" align="left"
		border="1" width='100%'>
		<div style="margin-top:20px">
			<div style="display: table-cell">
				<div align="left"
					style="margin-left: 20px; height: 100px; min-width: 130%;">
					<img
						src='<?php echo Yii::app()->theme->baseUrl;?>/img/LogoUNLP.png'
						height=" 90px" width=" 84px"
						align="left" src="LogoUNLP.png"> </a>
						<span style="font-family: arial; font-size: 24px; color: black; text-aling: center;">
						
							<b>UNIVERSIDAD NACIONAL DE LA PLATA</b><br> <span>Secretaria de Asuntos Académicos </span> <br>
							<span style="width: 100%">Dirección de Vinculación con el
								Graduado Universitario</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<span
			style='font-family: arial; font-size: 22px; color: black; display: block'>Encuesta
			de Grado a recientes egresados de la U.N.L.P.</span>
	</div>
	<br>

<div class="container" style="padding-top: 0">
	<div class="row-fluid">
		<div class="span12">
			<?php echo $content; ?>
		</div>
	</div>
</div>
<!-- content -->
<?php $this->endContent(); ?>