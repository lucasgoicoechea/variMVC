<!DOCTYPE html>
<html lang="en">
<head>
<?php

Yii::app ()->getSession ()->open ();
//(Yii::app ()->getSession ()->get ( 'accessAllow' ) != 'true') ? $this->redirect ( Yii::app ()->controller->createUrl ( 'site/loginAdmin' ) ) : '';
 (Yii::app()->user->isGuest)?$this->redirect(Yii::app()->controller->createUrl('site/loginAdmin')):'';
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
<link
	href="<?php echo Yii::app()->theme->baseUrl;?>/gridview/styles.css"
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
<link
	href="<?php echo Yii::app()->theme->baseUrl;?>/css/jquery.tree.view.css"
	rel="stylesheet">
<script type="text/javascript"
	src="<?php echo Yii::app()->theme->baseUrl;?>/js/reflection.js"></script>
<script type="text/javascript"
	src="<?php echo Yii::app()->theme->baseUrl;?>/gridview/jquery.yiigridview.js"></script>
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
	href="<?php echo Yii::app()->theme->baseUrl;?>/ico/favicon.png">
</head>
<body class="cuerpo" topmargin="0px" leftmargin="0px">

	<div class="fondo">
		<!-- ENCABEZADO -->
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
						<span style="color: green;">Nosotros:</span>
						“VARI Constructora” en La Plata
                                                <span style="color: green;"><<CORREO ELECTRONICO>></span>
					</div>
					<hr>
					<div>
						<span style="color: grey;"> Calle 528 entre 10 y 11 
							| La Plata - Buenos Aires - Argentina - CP 1900 |
							Tel&eacute;fonos: (0221) xxx-xxxx </span>
					</div>
				</div>
				<div class="rbbot">
					<div></div>
				</div>
			</div>

		</div>
		<!-- FIN FOOTER -->
	</div>
<script type="text/javascript">
$(document).ready( function() {
	$(":submit").click(function() {
		$(this).attr("disabled",true)
		.attr("value", "Registrando...")
		.parents("form").submit();
	});
});
/*$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});
$(document).on('keypress', 'input, select, checkbox, radio, button', function (e){
	if (e.which === 13) {
		e.preventDefault();
        //var index = $('.inputs').index(this) + 1;
        //$('.inputs').eq(index).focus();
		$(this).next().focus();
    }
});*/
$(document).on('keypress', 'input, select, checkbox, radio, button', function (e) {
    return focusNextOnEnter(e, this);
});
function focusNextOnEnter(e, selector) {
    var longSelector = 'input:visible:enabled:not([readonly="readonly"]), textarea:visible:enabled:not([readonly="readonly"]), select:visible:enabled, button:visible:enabled';
    var keyCode = e.keyCode || e.which;
    if ($(selector).is(':not(textarea)')  // it's not a textarea - enter in text area
            && keyCode === 13 // it's enter key
            && !$(selector).is('[type="submit"]')) // it's not submitButton, save-on-enter here
    {
        e.preventDefault();
        $(longSelector)[$(longSelector).index($(selector)) + 1].focus();
        return true;
    }
}
</script>
	<!-- FIN CLASS FONDO -->
</body>
</html>
