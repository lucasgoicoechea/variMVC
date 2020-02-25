<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- MENU -->
<?php 
$this->beginWidget('application.extensions.leftsidebar.LeftSidebar', array('title' => 'Menu', 'collapsed' => true));
 ?>
 <div class="lateralIzq">
	<!-- LINKS - ENLACES -->
	<!--<div class="menu"> -->
	<div align="center" class="titulo">Usuario: <?php echo UsersLogin::getAdministradorUserNameByUsersLoginID(Yii::app()->user->id)?></div>
	-><img width="22" align="top" height="20"
					style="width: 16px; height: 16px" id="icon_objTreeMenu_1_node_1"
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/salir.png"> <?php echo CHtml::link('CERRAR SESION',Yii::app()->baseUrl.'/site/logout',array('class'=>'linkHome')); ?>
				<div class="row-center" 
		style="<?php  
		$ultimaCaja = Caja::model()->getUltimaCaja();
		if (! $ultimaCaja->cerrada) {
			$hoy=date("Y-m-d");
			if ($ultimaCaja->fecha<$hoy){
				Caja::model()->cerrarCajaYNoAbrir($ultimaCaja);
				$ultimaCaja->cerrada=1;
				echo "background-color: red;  ";
			}
			else echo "background-color: green; ";
		} else {
			echo "background-color: red;  ";
		}
		?>" >
		<span style="color: white; font-size: 16px; font-family: monospace;">
		<?php echo $ultimaCaja->cerrada?"CAJA CERRADA: ":"CAJA ABIERTA: ";
		   echo LGHelper::functions ()->displayFecha ( $ultimaCaja->fecha );
		?>
	</span>
	</div>					<br>
					
	<div class="">
		<table width="100%" align="center">

			<tr>
				<td align="left" class="principal"><img width="22" align="top"
					height="20" id="icon_objTreeMenu_1_node_1"
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/b_home.png"> <?php echo CHtml::link('INICIO',Yii::app()->homeUrl,array('class'=>'linkHome')); 	?>
				</td>
				<td></td>
			</tr>
			<tr>
				<td align="center" class="principalMenuArbol"><?php
			   if (!Yii::app ()->user->isGuest){
					$admiin = UsersLogin::getAdministradorByUsersLoginID ( Yii::app()->user->id );
					Yii::app()->getSession()->add('id_administrador', 	$admiin->id);
					Yii::app()->getSession()->add('publico_administrador',$admiin->getPublico());
			   }
				/*$this->widget ( 'CTreeView', array (
						'id' => 'unit-treeview',
						'url' => array (
								'request/fillTree' 
						),
						'htmlOptions' => array (
								'class' => 'treeview-red' 
						),
						'persist' => 'cookie',
						'prerendered'=>true,
						'cookieId' => 'group-tree',
						'animated' => 'fast',
						'collapsed' => true, 
						'unique'=> true,
								) );*/
             $data = LGHelper::functions()->getMenuData();
           //  print_r(array_values($data));
			 $this->widget('CTreeView',array('data'=>$data,
                                             'animated'=>'slow',
											'id' => 'unit-treeview',
											'unique'=>false,
                                             'collapsed'=>true,
											'persist' => 'cookie',
											'cookieId' => 'group2-tree',
											'htmlOptions'=>array('class'=>'treeview-red'))); 
				?> 
				<?php 
/*
				       * $this->widget('CTreeView', array('data'=>$data, 'animated'=>'slow', 'collapsed'=>true, 'htmlOptions'=>array('class'=>'treeview-gray'))); //ese es asincronico $this->widget('CTreeView', array('url'=>array('treeFill'), 'animated'=>'slow', 'htmlOptions'=>array('class'=>'treeview-red')));
				       */
				?>
				</td>

			</tr>
		</table>
	</div>
	<br>
</div>
<?php 
$this->endWidget();
 ?>

<!-- END SIDEBAR -->
<div class="container" style="padding-top: 0">
	<div class="row-fluid">
		<div class="span12">
			<?php echo $content; ?>
		</div>
	</div>
</div>
<!-- content -->
<?php $this->endContent(); ?>