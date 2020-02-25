<?php
$this->breadcrumbs = array (
		'Cheques' => array (
				'index' 
		),
		$model->id_cheque 
);

?>

<div class="titulo">Detalle del Cheque</div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				// 'Codigo',
				'serie',
				// 'obra.Codigo',
				array (
						'name' => 'Cuenta Banco',
						'value' => $model->cuentaBanco->getDescripcion ()
				),
				'Numero',
				'FechaEmision',
				'FechaPago',
				'Importe',
				'a_la_orden',
				'porc_impuesto_cheque',
				'porc_impuesto_debito' 
		) 
) );
?>

<div class="row-center">
	<span>
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank' 
	) );
	?>
    </span> <span>
    <?php
				echo CHtml::link ( 'Volver', $this->createUrl ( 'cheque/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>
</div>
