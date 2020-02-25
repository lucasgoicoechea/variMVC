<div class="header" width="99%">Saldos Gastos por Cuenta</div>
<?php
$desde = $model->fechaDesde!==null?LGHelper::functions()->undisplayFecha($model->fechaDesde):null;
$hasta = $model->fechaHasta!==null?LGHelper::functions()->undisplayFecha($model->fechaHasta):null;
$acumulados = CuentaSaldosAcumulado::model()->getByCajaEntreFechas($desde,$hasta);
if (sizeof($acumulados)==0){
	echo "<b>NO HAY SALDOS CALCULADOS PARA LAS CAJAS DE ESAS FECHAS</b>";
} 
else {
	$this->renderPartial ( '_acumuladoHeaders', array (
	) );
	/*foreach ($acumulados as $cuentaSaldosAcum){
		$this->renderPartial ( '_acumulado', array (
				'data' => $cuentaSaldosAcum 
		) );
	}*/
}
?>

<div class="verGrilla" id="">
	<div class="contenedor-tabla">
<?php
$dataProvider = new CArrayDataProvider ( $acumulados, array (
		'keyField' => 'id_cuenta_saldos_acumulado',
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
		'itemView' => '/caja/_acumulado',  
        'enablePagination'=>false,
        'summaryText'=>'',
 ));
?>
</div>
</div>