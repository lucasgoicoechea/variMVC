<?php
$this->breadcrumbs=array(
	'Materials'=>array('index'),
	$model->id_material,
);


?>

<h1>Detalle de Material #<?php echo $model->id_material; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_material',
		'Codigo',
		'Nombre',
		'Costo',
		'rubro.Codigo',
		'subrubro.Codigo',
		'Observaciones',
		'Medida',
		'Fecha',
	),
)); ?>


<br /><h2> This OrdenCompra belongs to this Material: </h2>
<ul><?php foreach($model->ordenesCompras as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->numero_orden, array('ordencompra/view', 'id' => $foreignobj->id)));

				} ?></ul><br /><h2> This Presupuesto belongs to this Material: </h2>
<ul><?php foreach($model->presupuestos as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->NumeroOrden, array('presupuesto/view', 'id' => $foreignobj->id)));

				} ?></ul>