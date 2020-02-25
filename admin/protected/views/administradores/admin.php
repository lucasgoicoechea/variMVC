<div class="titulo">Usuarios&nbsp;Administradores</div>

<?php //echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
	<?php
	
$this->renderPartial ( '_search', array (
			'model' => $model 
	) );
	?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'administradores-grid',
		'dataProvider' => $model->search (),
		'ajaxUpdate' => false,
		// 'filter'=>$model,
		'baseScriptUrl' => Yii::app ()->theme->baseUrl,
		// 'enableSummary' => false,VERSION 1.1.13
		'enablePagination' => true,
		'columns' => array (
				array (
						'header' => 'Usuario',
						'name' => 'usuario',
						'headerHtmlOptions' => array (
								'style' => 'width:100px' 
						) 
				),
				array (
						'name' => 'clave',
						'headerHtmlOptions' => array (
								'style' => 'width:100px' 
						) 
				),
				array (
						'name' => 'nombre',
						'header' => 'Nombre',
						'headerHtmlOptions' => array (
								'style' => 'width:140px' 
						) 
				),
				
				array (
						'name' => 'apellido',
						'header' => 'Apellido',
						'headerHtmlOptions' => array (
								'style' => 'width:140px' 
						) 
				),
				array (
						'header' => 'Tipo',
						//'name' => 'tipoAdmin.descripcion',
						'value' => '$data->getTipoAdminDescripcion()',
						'headerHtmlOptions' => array (
								'style' => 'width:80px' 
						) 
				),
				array (
						'header' => ' ',
						'template' => '{update}{delete}',
						'class' => 'CButtonColumn',
						'updateButtonUrl' => 'Yii::app()->controller->createUrl("/administradores/update",array("id"=>$data->primaryKey))',
						'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/administradores/delete",array("id"=>$data->primaryKey))',
						'updateButtonImageUrl' => Yii::app ()->theme->baseUrl . '/img/gridview/update.png',
						'deleteButtonImageUrl' => Yii::app ()->theme->baseUrl . '/img/gridview/delete.png' 
				) 
		) 
) );
?>
<br>
<?php

$this->renderPartial ( 'create', array (
		'model' => $model,
		'usuario'=> $usuario 
) );
?>
<br>
<?php 
echo CHtml::ajaxButton('Backup Manual - Base de Datos', CController::createUrl('administradores/backupManual'), array( ), array());?>
(
<?php 
echo CHtml::link('Deshacer Ultimo Cierre',CController::createUrl('caja/deshacerUltimoCierre'),array('class'=>'search-button'));
?>)
