<?php
$this->breadcrumbs = array (
		'Transferencias' => array (
				'index' 
		),
		$model->id_transferencia 
);

?>

<div class="titulo">Detalle de Transferencia registrada</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'fecha',
				array (
						'name' => 'Cuenta Origen',
						'value' => $model->cuentaOrigen->getDescripcion () 
				),
				array (
						'name' => 'Cuenta Destino',
						'value' => $model->cuentaDestino->getDescripcion () 
				),
				array(
					'name'=>'Importe',
						'value'=> LGHelper::functions ()->formatNumber ( $model->importe ),
),
				//'importe',
				// /'formaPago.Codigo',
				// 'gasto.Codigo',
				'descripcion' 
		) 
) );
?>
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
				echo CHtml::link ( 'Volver', $this->createUrl ( 'transferencia/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>
</div>

