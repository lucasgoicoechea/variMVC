<?php
$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	$model->id_cliente,
);


?>

<h1>Detalle de Cliente #<?php echo $model->id_cliente; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_cliente',
		'codigo',
		'nombre',
		'telefono',
		'fax',
		'localidad.d_descripcion',
		'moneda.nombre',
	),
)); ?>


<br /><h2> This Cobro belongs to this Cliente: </h2>
<ul><?php foreach($model->cobros as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->Indice, array('cobro/view', 'id' => $foreignobj->id)));

				} ?></ul><br /><h2> This Obra belongs to this Cliente: </h2>
<ul><?php foreach($model->obras as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->Codigo, array('obra/view', 'id' => $foreignobj->id)));

				} ?></ul>