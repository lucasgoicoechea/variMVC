

<div class="header" width="99%">Transferencia entre Cuentas</div>
<?php $desde = LGHelper::functions()->undisplayFecha($model->fechaDesde);
$hasta = LGHelper::functions()->undisplayFecha($model->fechaHasta);
$transferencias = Transferencia::model()->getEntreFechasForCaja($desde,$hasta);
if (sizeof($transferencias)==0){
	echo "<b>NO HAY TRANSFERENCIAS ENTRE CUENTAS PARA LAS CAJAS ENTRE ESAS FECHAS</b>";
} 
else {
	$this->renderPartial ( '_transferenciaHeaders', array (
	) );
}
?>

<div class="verGrilla" id="">
	<div class="contenedor-tabla">
<?php
$dataProvider = new CArrayDataProvider ( $transferencias, array (
		'keyField' => 'id_transferencia',
		/*'sort'=>array(
		 'attributes'=>array(
		 		'apellido', 'nombre',
		 		//'id'
		 ),
		),
'pagination'=>array(
		'pageSize'=>12,
),*/
) );
$this->widget ( 'zii.widgets.CListView', array (
		'dataProvider' => $dataProvider,
		'itemView' => '/caja/_transferencia',  
        'enablePagination'=>false,
        'summaryText'=>'',
 ));
?>
</div>
</div>