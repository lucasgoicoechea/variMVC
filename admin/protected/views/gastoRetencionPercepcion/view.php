<?php
$this->breadcrumbs=array(
	'Gasto Retencion Percepcions'=>array('index'),
	$model->id_gasto_retencion_percepcion,
);


?>

<div class="titulo">Detalle de  Retencion-Percepcion Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array (
			'name' => 'ID_RET_GASTO',
			'value' => $model->id_gasto_retencion_percepcion
					),
		array (
						'name' => 'Gasto',
						'type'=>'raw',
						'value' => CHtml::link ( '<b>Ver Detalle Gasto -> <b> # ' . $model->gasto->id_gasto . ' ', $model->gasto->getVerGasto(), array (
							'title' => 'Ver Gasto',
							'target' => '_blank' 
					) )
		),
		array (
			'name' => 'Retencion/Percepcion',
			'value' => $model->retencionPercepcion->getDescripcionAbreviada()
					),
		'valor',
		'alicuota'
	),
)); ?>
	<div class="" id="list_entrevistas">
	<?php
	/*$resultadosEntrev = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $model->id_gasto );
	$montoTotalOP = 0.00;
	if ($resultadosEntrev != null) {
		$this->widget ( 'zii.widgets.CListView', array (
				'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
				'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
				'itemView' => '..gasto/_viewGasto',
				// 'viewData' => array( 'data' => null ),
				'ajaxUpdate' => false,
				// 'enablePagination'=>true
				'pager' => array (
						'header' => 'Ir a', // text before it
						'maxButtonCount' => 28 
				) 
		) );
		$resultados = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $model->id_gasto );
		foreach ( $resultados as $value ) {
			$temp = LGHelper::functions ()->unformatNumber( $value->gasto->Monto );
			$montoTotalOP = $montoTotalOP + $temp ;
		}
		$montoTotalOP =  LGHelper::functions ()->unformatNumber( $montoTotalOP );
	} else {
		echo "NO POSEE COMPROBANTES SELECCIONADOS";
	}*/
	?>
				
</div>
<div class="row-center">
<?php 
	echo CHtml::button ( 'Volver', array (
			'name' => 'btnBack',
			'onclick' => 'js:history.go(-1);returnFalse;',
			'class' => 'btn btn-primary'
	) );
	?></div>

