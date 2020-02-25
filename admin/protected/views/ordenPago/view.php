<?php
$this->breadcrumbs=array(
	'Orden Pagos'=>array('index'),
	$model->id_orden_pago,
);


?>

<div class="titulo">Detalle de Orden Pago Registrado</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'numero_op',
'fecha',
		'observacion',array (
					'name' => 'CUENTA ORIGEN',
					'value' => $model->cuenta!=null?$model->cuenta->descripcion:'Sin Cuenta'
			)
,array (
					'name' => 'MONTO',
					'value' => $model->getMonto()
			),array (
					'name' => 'PAGADO',
					'value' => $model->isPagada()?"SI":"NO"
			),
		
	),
)); ?>
	<div class="" id="list_entrevistas">
	<?php
	$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $model->id_orden_pago );
	$montoTotalOP = 0.00;
	if ($resultadosEntrev != null) {
		$this->widget ( 'zii.widgets.CListView', array (
				'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
				'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
				'itemView' => '_viewGastoSimple',
				// 'viewData' => array( 'data' => null ),
				'ajaxUpdate' => false,
				// 'enablePagination'=>true
				'pager' => array (
						'header' => 'Ir a', // text before it
						'maxButtonCount' => 28 
				) 
		) );
		$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $model->id_orden_pago );
		foreach ( $resultados as $value ) {
			$montoTotalOP = $montoTotalOP + $value->gasto->Monto;
		}
	} else {
		echo "NO POSEE COMPROBANTES SELECCIONADOS";
	}
	?>
		
		<div class="contenedor-fila">
			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalOP); ?></b>
			</div>
		</div>
</div>
	</div>
<div class="row-center">
<span >
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank' 
	) );
    ?>
    </span>
    <span>
    <?php 
	echo CHtml::link ( 'Editar OP', $this->createUrl ( 'ordenPago/update' ,array('id'=>$model->id_orden_pago )), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
	<span>
    <?php 
	echo CHtml::link ( 'Volver', $this->createUrl ( 'ordenPago/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
	</div>

