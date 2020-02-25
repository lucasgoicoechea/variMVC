<?php
$model = new Cheque();
//$model->pagada = $pagados?1:0;
$model->FechaEmision = $caja->fecha;

?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cheque-grid',
	'dataProvider'=>$model->search(),
	'enableSorting'=>false,
	//'filter'=>$model,
	'columns'=>array(
        'serie',
		'Numero',
		'id_obra',
				array (
						'name' => 'id_cuenta_banco',
						'value' => '$data->cuentaBanco->descripcion',
						'filter' => CHtml::listData ( CuentaBanco::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cuenta_banco', 'descripcion' ) 
				),
		'FechaEmision',
		'FechaPago',
		'Importe',
		
	),
)); ?>