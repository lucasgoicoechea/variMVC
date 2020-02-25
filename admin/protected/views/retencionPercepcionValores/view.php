<?php
$this->breadcrumbs=array(
	'Retencion Percepcion Valores'=>array('index'),
	$model->id_retencion_percepcion_valores,
);


?>

<div class="titulo">Detalle de RetencionPercepcionValores Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_retencion_percepcion_valores',
		'id_retencion_percepcion',
		'valor',
		'usuario_log',
		'fecha_log',
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

