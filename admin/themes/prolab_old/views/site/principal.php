<?php 
$model=new Comunicacion('search');
$model->leido = 0;
$this->renderPartial('/comunicacion/adminRecibidas',array(
		'model'=>$model,
		'id_userslogin' => Yii::app ()->user->id
));

?>
<div style="text-align: center; width:660px;border:0px; bgcolor:white;	height:800px">
		<div align="center">
				<img
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/menu/bienvenido.gif" />
			
				<img
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo-ra.jpg"
					class="reflect" alt="reflection.js" />
		</div>
</div>
