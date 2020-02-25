<?php
$this->breadcrumbs=array(
	'Gastos'=>array('index'),
	$model->id_gasto,
);


?>
<div class="titulo">Detalle de Factura/Comprobante</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Codigo',
		'FechaAsiento',
			array (
						'name' => 'Obra',
						'value' => $model->obra->getDescripcion () 
				),
				array (
						'name' => 'Proveedor (Tel)',
						'value' => $model->proveedor->getDescripcion () 
				),array (
						'name' => 'Tipo Comprobante',
						'value' => $model->tipoComprobante->getDescripcion () 
				),
		'NumComprobante',
		'Monto',
		'FechaFactura',
		'Detalle'
			,array (
					'name' => 'PAGADO',
					'value' => $model->isPagada()?"SI":"NO"
			)	
			,array (
					'name' => 'TOMADO POR ORDEN DE PAGO',
					'value' => $model->en_orden_pago?"SI":"NO"
			),array (
					'name' => 'TICKET',
					'value' => $model->en_blanco?"SI":"NO"
			)	
	),
)); ?>
<div class="view">
	<div class="form">
<?php
$gastoRetPerc = new GastoRetencionPercepcion ();
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-retencion-percepcion-grid',
		'dataProvider' => $gastoRetPerc->searchWithGasto (  $model->id_gasto),
		//'filter' => $gastoRetPerc,
		'columns' => array (
				// 'id_gasto_retencion_percepcion',
				array (
						'name' => 'id_retencion_percepcion',
						'value' => '$data->retencionPercepcion->getDescripcionAbreviada()',
						'filter' => CHtml::listData ( RetencionPercepcion::model ()->findAll ( array (
								'order' => 'id_retencion_percepcion' 
						) ), 'id_retencion_percepcion', 'descripcion' ) 
				),
				array (
						'header' => 'Alicuota',
						'value' => '$data->retencionPercepcion->getAlicuota($data->valor)' 
				),
				array (
						'header' => 'Importe',
						'value' => '$data->alicuota' 
				),
				)
) );
$montoTotalRetenciones = Gasto::model ()->getTotalMontoRetenciones (  $model->id_gasto);
$montoTotalmas = $model->getMontoTotal();
?>
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>SUBTOTAL - RETENCIONES/PERCEPCIONES</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalRetenciones); ?></b>
				</div>
				<div
					style="border-radius: 25px; width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalmas); ?></b>
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
	echo CHtml::link ( 'Volver', $this->createUrl ( 'gasto/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span><span>
    <?php 
	echo CHtml::link ( 'Editar Comprobante', $this->createUrl ( 'gasto/update',array('id'=>$model->id_gasto) ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
	    <span>    <?php
     if ($model->id_contrato_cabecera != null) {
				echo CHtml::link ( 'Pago Subcontrato: '.CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimirContrato (), array (
							'style' => 'color: white',
							'class' => 'btn btn-primary',
							'target' => '_blank' 
					) );
     }
				
				?></span>
</div>
</div>
</div>