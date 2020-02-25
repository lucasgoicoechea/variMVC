<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app ()->name . ' - EN CONSTRUCCI&Oacute;N';
// $this->breadcrumbs=array();
?>
<div class="login">

	<div class="menuBody" id="menuBodyLogin">
<!-- <h1><?php echo CHtml::encode("VARI Constructora"); ?></h1> -->

<!--<p><?php echo CHtml::encode("ACCESO AL SISTEMA DE ADMINISTRACIÓN"); ?></p>-->

</div>
</div>
<!-- LOGIN -->
<div style="width: 1734px" class="login">

	<div class="menuBody" id="menuBodyLogin">



		<div class="menu portlet-content">
			<br> <br>
				<?php
				
if (Yii::app ()->user->isGuest) {
					$this->widget ( 'UserLogin', array (
							'tipoUsersLogin' => Administradores::TIPO_USERS,
							'title' => "Acceso de operador" 
					) );
					echo CHtml::link ( "Olvide mi contrase&ntilde;a", array (
							"/usersLogin/forgotPassword/4" 
					), array (
							"class" => "recordarClave" 
					) );
				} else {
					echo "<div style='text-align: center;'> <div class='btn btn-primary'>";
					echo CHtml::link ( "Cerrar sesión -> " . UsersLogin::getTipoUsersLoginDescripcion ( Yii::app ()->user->id ), array (
							'/site/logout' 
					), array (
							"style" => "color:black" 
					) );
					echo "</div>";
					echo "</div>";
				}
				?>	
				<br> <br>
		</div>
	</div>
</div>
<div class="form"></div>
<!-- form -->
<div style="float: center; position: relative;" class="menu portlet-content">
<?php

$imageUrl = Yii::app ()->theme->baseUrl . "/img/banner-ra.jpg";
echo CHtml::image ( $imageUrl, '', array (
		'class' => 'deals_product_image',
		'style' => 'border-style: none; text-align: center; display: inline;',
		'border' => "0" 
) );
?>
<?php


/*$imageUrl = Yii::app ()->theme->baseUrl . "/img/logo-ra.jpg";
echo CHtml::image ( $imageUrl, '', array (
		'class' => 'deals_product_image',
		'style' => 'border-style: none; text-align: right; display: inline;',
		'border' => "0" 
) );*/
?>
</div>
