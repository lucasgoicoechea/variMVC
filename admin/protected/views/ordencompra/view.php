<?php
$this->breadcrumbs = array (
		'Orden Compras' => array (
				'index' 
		),
		$model->id_orden 
);

?>

<div class="titulo">Detalle de Orden Compra</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				// 'id_orden',
				'numero_orden',
				'Fecha',
				array (
						'name' => 'Obra',
						'value' => $model->obra!=null?$model->obra->getDescripcion ():'Sin OBRA' 
				),
				array (
						'name' => 'Proveedor (Tel)',
						'value' => $model->proveedor!=null?$model->proveedor->getDescripcion () :'Sin Proveedor'
				),
				'Cantidad',
				array(
						'name' => 'Detalle',
						'value' =>  $model->Detalle//str_replace("\n", "<br />", $model->Detalle)
),
				'Atencion',
				'Autorizo',
				'Solicitado',
				'Entrega',
				'Recibe',
				/*array (
						'name' => 'Pagada',
						'value' => $model->Pagada ? "SI" : "NO" 
				),
				array (
						'name' => 'Impresa',
						'value' => $model->Impresa ? "SI" : "NO" 
				) */
		// 'material.Codigo',
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
	echo CHtml::link ( 'Volver', $this->createUrl ( 'ordencompra/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
</div>


