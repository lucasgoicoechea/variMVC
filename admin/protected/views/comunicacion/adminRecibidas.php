<?php ?>
<div class="subtitulo texto4 pregunta">Comunicaciones Internas - RECIBIDAS</div>
<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'comunicacion-grid',
		'dataProvider' => $model->searchRecibidasByUser ( $id_userslogin ),
		//'filter' => $model,
		'columns' => array (
				array (
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
						),
						'name' => 'fecha_emision' 
				)
				,
				'mensaje',
				array (
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
						),
						'name' => 'id_userslogin_origen',
						'type' => 'raw',
						'value' => 'UsersLogin::getAdministradorUserNameByUsersLoginID($data->id_userslogin_origen)' 
				),
				array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
						),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
						),
						'name' => 'leido',
						'type' => 'raw',
						'value' => '$data->leido?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
				),
		array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{reemplazarCheque}',
						'class' => 'CButtonColumn',
						'buttons' => array (
										'reemplazarCheque' => array (
												'label' => 'Marcar como leido',
												'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/preview.gif",
												'url' => '$data->getUrlMarcarComoLeido()',
												//'visible' => '$data->isAnulado()',
												'options' => array (
													//	'target' => '_blank'
												)
										),
	) )
) ));
?>
