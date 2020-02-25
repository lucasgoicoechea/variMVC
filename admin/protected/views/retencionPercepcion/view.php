<?php
$this->breadcrumbs=array(
	'Retencion Percepcions'=>array('index'),
	$model->id_retencion_percepcion,
);


?>

<div class="titulo">Detalle de RetencionPercepcion Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_retencion_percepcion',
		'descripcion',
		'es_porcentaje',
	),
)); ?>
<div class="row-center">
<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?></div>

