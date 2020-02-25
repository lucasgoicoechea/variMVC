<!DOCTYPE html>
<html lang="en">
<head>
<?php

Yii::app ()->getSession ()->open ();
(Yii::app ()->params ['enableUnderConstruction'] && Yii::app ()->getSession ()->get ( 'accessUnderConstruction' ) != 'true') ? $this->redirect ( 'site/underConstruction' ) : '';
// '':'';
?>
<meta charset="utf-8">
<title><?php echo $this->pageTitle;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link
	href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css"
	rel="stylesheet">
<link
	href="<?php echo Yii::app()->theme->baseUrl;?>/css/responsive.min.css"
	rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/estilos.css"
	rel="stylesheet">
<link rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/flotante.css"
	rel="stylesheet">
<link
	href="<?php echo Yii::app()->theme->baseUrl;?>/css/sl_document.css"
	rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/grilla.css"
	rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144"
	href="<?php echo Yii::app()->theme->baseUrl;?>/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="<?php echo Yii::app()->theme->baseUrl;?>/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="<?php echo Yii::app()->theme->baseUrl;?>/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed"
	href="<?php echo Yii::app()->theme->baseUrl;?>/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon"
	href="<?php echo Yii::app()->theme->baseUrl;?>/css/favicon.ico">
</head>
<body class="cuerpo" topmargin="0px" leftmargin="0px">

	<div class="fondo">
		<!-- ENCABEZADO -->
		<div class="encabezado">
			<div class="upper_image">
				<img
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/logoProlab.jpg"
					title="" HEIGHT="72" WIDTH="177" alt=""> <a
					href="www.prolab.unlp.edu.ar"> <img
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/banner_homeunlp_large2.gif"
					title="" width="580" height="70" alt="">
				</a>
				<noscript>&lt;div class='no-javascript-error'&gt;Se requiere
					Javascript, y/o algunos agregados, para mostrar ciertos contenidos
					en su navegador.&lt;/div&gt;</noscript>
			</div>
		</div>

		<div class="encabezado2">
			<div class="mainMenu">
				<div class="tabLogo">
					<span><img width="32" height="32" alt="" title=""
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/logoUNLPazul.jpg">
					</span> <span class="tabLogoLetras"> <b>PROGRAMA DE OPORTUNIDADES
							LABORALES Y RR.HH.</b><br> <b>UNIVERSIDAD NACIONAL DE LA PLATA</b>
					</span>
				</div>
				<div class="social-box">
					<a style="text-decoration: none; border: medium none;"
						href="http://www.facebook.com/unlp.prolab" target="blank"> <img
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/facebook-icon.jpg"
						border="0" title="Seguinos en FACEBOOK" HEIGHT="25" WIDTH="60"
						alt="" style="text-decoration: none; border: medium none;">
					</a><a style="text-decoration: none; border: medium none;"
						href="https://twitter.com/ProlabUnlp" target="blank"> <img
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/twitter-icon.jpg"
						border="0" title="Seguinos en TWITTER" HEIGHT="25" WIDTH="60"
						alt="" style="text-decoration: none; border: medium none;">
					</a> <a href="http://www.linkedin.com/in/prolabunlp"><img
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/linkedin.jpg"
						border="0" title="Seguinos en LINKED" HEIGHT="25" WIDTH="60"
						alt="" style="text-decoration: none; border: medium none;"></a>
				</div>
			</div>
		</div>
		<div id="menu-top">
			<div id="mainmenu">
<?php

$this->widget ( 'zii.widgets.CMenu', array (
		'activeCssClass' => 'active',
		'activateParents' => true,
		'items' => array (
				array (
						'label' => 'Inicio',
						'url' => array (
								'/site/index' 
						) 
				),
				array (
						'label' => 'Postulantes',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Registrarse',
										'url' => array (
												'/usuarios/create' 
										),
										'linkOptions' => array (
												'id' => 'menuCompany' 
										),
										'itemOptions' => array (
												'id' => 'itemCompany' 
										),
										'visible' => ! UsersLogin::isUsuario ( Yii::app ()->user->id ) 
								),
								array (
										'label' => 'Actualizarse',
										'url' => array (
												'/usuarios/update/' . UsersLogin::getUsuarioDNIByUsersLoginID ( Yii::app ()->user->id ) 
										),
										'linkOptions' => array (
												'id' => 'menuCompany' 
										),
										'itemOptions' => array (
												'id' => 'itemCompany' 
										),
										'visible' => UsersLogin::isUsuario ( Yii::app ()->user->id ) 
								),
								array (
										'label' => 'Modificar CV',
										'url' => array (
												'/usuarios/cv/' . UsersLogin::getUsuarioDNIByUsersLoginID ( Yii::app ()->user->id ) 
										),
										'linkOptions' => array (
												'id' => 'menuCompany' 
										),
										'itemOptions' => array (
												'id' => 'itemCompany' 
										),
										'visible' => UsersLogin::isUsuario ( Yii::app ()->user->id ) 
								) 
						)
						 
				),
				array (
						'label' => 'Empresas',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Servicios',
										'url' => array (
												'site/articulosInfo/53' 
										) 
								),
								array (
										'label' => 'Suscripcion',
										'url' => array (
												'site/articulosInfo/8' 
										) 
								) 
						) 
				),
				array (
						'label' => 'Institucional',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Quienes somos',
										'url' => array (
												'site/articulosInfo/5' 
										) 
								),
								array (
										'label' => 'Objetivos',
										'url' => array (
												'site/articulosInfo/6' 
										) 
								) 
						) 
				),
				array (
						'label' => 'Asesoramiento',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Como armar tu CV',
										'url' => array (
												'site/articulosInfo/10' 
										) 
								),
								array (
										'label' => 'Carta de presentación',
										'url' => array (
												'site/articulosInfo/12' 
										) 
								),
								array (
										'label' => 'Asesoramiento contable',
										'url' => array (
												'site/articulosInfo/17' 
										) 
								) 
						) 
				),
				array (
						'label' => 'Investigaciones',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Estadisticas',
										'url' => array (
												'site/articulosInfo/46' 
										) 
								),
								array (
										'label' => 'Informes',
										'url' => array (
												'site/articulosInfo/46' 
										) 
								),
								array (
										'label' => 'Encuestas',
										'url' => array (
												'site/articulosInfo/46' 
										) 
								),
								array (
										'label' => 'Articulos',
										'url' => array (
												'site/articulosInfo/69' 
										) 
								) 
						) 
				),
				array (
						'label' => 'Guía Profesionales',
						'url' => Yii::app ()->baseUrl . '/profesionales/verGuia',
						'linkOptions' => array (
								'encode' => false,
								'style' => "background-image: url('" . Yii::app ()->theme->baseUrl . "/img/imgprofesionales/logosintext.png'); background-size: 25% auto; background-repeat:no-repeat;",
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'items' => array (
								array (
										'label' => 'Buscar profesional',
										'url' => array (
												'/guiaProfesional/guia' 
										) 
								),
								array (
										'label' => 'Agregate',
										'url' => array (
												'/profesionales/elegirOpcion' 
										) 
								),
								array (
										'label' => 'Que es la Guía?',
										'url' => array (
												'site/viewTestimonio/83' 
										) 
								) 
						) 
				),
				array (
						'label' => '(Usuario: ' . UsersLogin::getUserName ( Yii::app ()->user->id ) . ')',
						'url' => '#',
						'linkOptions' => array (
								'id' => 'menuCompany' 
						),
						'itemOptions' => array (
								'id' => 'itemCompany' 
						),
						'visible' => ! Yii::app ()->user->isGuest,
						'items' => array (
								array (
										'label' => 'Cerrar Sessión',
										'url' => array (
												'/site/logout' 
										) 
								) 
						) 
				) 
		) 
)
 );
/*
 * <a title='Guia de Profesionales' href='<?php echo Yii::app()->baseUrl;?>/profesionales/verGuia'> <img width='136' src='<?php echo ' style='text-decoration: none; border: none;'> </a>
 */
?>
</div>
		</div>
		
		
		
<?php if(!empty($this->breadcrumbs)):?>
  			<div class="breadcrumbs-right-gray">
      <?php
	
	$this->widget ( 'zii.widgets.CBreadcrumbs', array (
			'homeLink' => CHtml::link ( 'Inicio', array (
					'site/index' 
			) ),
			'links' => $this->breadcrumbs 
	) );
	?>
				<!-- breadcrumbs -->
		</div>
<?php endif?>
<?php if(($msgs=Yii::app()->user->getFlashes())!==null and $msgs!==array()):?>
  <div class="" style="padding-top: 0">
			<div class="">
				<div class="">
        <?php foreach($msgs as $type => $message):?>
          <div class="alert alert-<?php echo $type?>">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<h4><?php //echo ucfirst($type)?>!</h4>
            <?php echo $message?>
          </div>
        <?php endforeach;?>
      </div>
			</div>
		</div>
<?php endif;?>
<?php echo $content;?>
  


  <!-- FOOTER -->
		<div class="footerProlab">

			<div class="rbroundbox">
				<div class="rbtop">
					<div></div>
				</div>
				<div class="rbcontent">
					<div>
						<span style="color: navy;">Para comunicarse con nosotros:</span>
						prolab@presi.unlp.edu.ar - www.prolab.unlp.edu.ar
					</div>
					<hr>
					<div>
						<span style="color: navy;"> Calle 7 Nro. 776 (UNLP - Presidencia)
							| La Plata - Buenos Aires - Argentina - CP 1900 |
							Tel&eacute;fonos: (0221) 427-7196 - 424-5420 </span>
					</div>
				</div>
				<div class="rbbot">
					<div></div>
				</div>
			</div>

		</div>
		<!-- FIN FOOTER -->
	</div>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42947085-1', 'unlp.edu.ar');
  ga('send', 'pageview');

</script>
	<!-- FIN CLASS FONDO -->
</body>
</html>
