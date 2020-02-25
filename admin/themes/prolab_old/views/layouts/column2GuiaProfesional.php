<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<style type="text/css">
a:link {
	text-decoration: none
}

a:visited {
	text-decoration: none
}

a:active {
	text-decoration: none
}

.abecedario {
	padding: 4px 6px;
	background-color: #F5F5F5;
	background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
}

.formulariobusq {
	height: 18px;
	float: right;
}

.formulariobusq button {
	background-color: #9099A1;
	border: none;
	border-radius: 0 3px 3px 0;
	color: #FFF;
	cursor: pointer;
	float: right;
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
	width: 189px;
	height: 18px;
	overflow: visible;
	padding-right: 12px;
	position: relative;
	text-transform: uppercase;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
	width: 40px;
}

.formulariobusq-btn {
	background-color: #9099A1;
	border: none;
	border-radius: 0 3px 3px 0;
	color: #FFF;
	cursor: pointer;
	float: right;
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
	width: 189px;
	height: 18px;
	overflow: visible;
	padding-right: 12px;
	position: relative;
	text-transform: uppercase;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
	width: 40px;
}

.formulariobusq-input {
	height: 9px;
}

.boxpersona {
	display: block; -
	-float: left;
	margin-right: 15px;
	margin-top: 5px;
	text-align: left;
	text-transform: capitalize;
	width: 500px;
}

.boxpersona label {
	text-transform: lowercase;
	width: 400px;
}

.pagination { -
	-height: 36px;
	margin: 18px 0;
}

.pagination ul {
	border-radius: 3px 3px 3px 3px;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	display: inline-block;
	margin-bottom: 0;
	margin-left: 0;
}

.pagination li {
	display: inline;
}

.pagination a {
	-moz-border-bottom-colors: none;
	-moz-border-image: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-color: #DDDDDD;
	border-style: solid;
	border-width: 1px 1px 1px 0;
	float: left;
	line-height: 34px;
	padding: 0 14px;
	text-decoration: none;
}

.pagination a:hover,.pagination .active a {
	background-color: #F5F5F5;
}

.pagination .active a {
	color: #999999;
	cursor: default;
}

.pagination .disabled a,.pagination .disabled a:hover {
	background-color: transparent;
	color: #999999;
	cursor: default;
}

.pagination li:first-child a {
	border-left-width: 1px;
	border-radius: 3px 0 0 3px;
}

.pagination li:last-child a {
	border-radius: 0 3px 3px 0;
}

.pagination-centered {
	text-align: center;
}

.pagination-right {
	text-align: right;
}
</style>
<!-- PROFESIONES -->
<div style="background-color: #F3D615; height: 1566px;"
	class="lateralIzq">
	
 <?php $this->widget('ProfesionesActivas'); ?>
						  

	  </div>
<!-- END PROFESIONES -->

<!-- CUERPO -->
<div style="background-color: white;" class="lateralDer">
	<div class="pagina">
		<br>
		<div style="width: 100%; text-align: left">
			<img width="71px" style="text-decoration: none; border: none;"
				src="<?php echo Yii::app()->theme->baseUrl;?>/img/imgprofesionales/logosintext.png">
			<img width="499" style="text-decoration: none; border: none;"
				src="<?php echo Yii::app()->theme->baseUrl;?>/img/imgprofesionales/banneryellow.png">
		</div>
				<?php $this->widget('BuscadorGuia')?>
		  		<div style="width: 100%; text-align: center">
					<?php
					$abecedario = range ( 'A', 'Z' );
					foreach ( $abecedario as $abc ) {
						$params ['letra'] = $abc;
						echo CHtml::link ( $abc, Yii::app ()->urlManager->createUrl ( '/guiaProfesional/viewProfesionInicial/', $params ), array (
								'class' => 'button buttlnk abecedario',
								'style' => 'color: black' 
						) );
					}
					?>
				</div>
		<!--  <div style="width: 100%; text-align:right">
				     <span><a class="button buttlnk abecedario"   href="indexGuiaProfesionales.php"><img height="18" width="18" src="./imgprofesionales/all.png">Todos>></a></span>
				</div>-->
		<br>
			<?php echo $content; ?>
		  </div>
</div>
<!-- END CUERPO -->
<!-- END BAJO ENCABEZADO -->
<?php $this->endContent(); ?>