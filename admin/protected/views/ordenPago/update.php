<?php
?>

<div class="titulo">Modificar datos de la Orden de Pago</div>
<div
		style="<?php
		if ($model->pagada) {
			echo "background-color: green; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
		} else { if ($model->en_pago)
			echo "background-color: orange; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
			else echo "background-color: red; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
}
		?>" >
	<span style="color: white; font-size: 16px; font-family: monospace;"><?php if ($model->pagada) {
		echo "PAGADO";
	}
	else  { if ($model->en_pago)
	echo "PENDIENTE DE PAGO";
	else echo "SIN PAGO ASIGNADO";
	}
	?>
	</span>

</div>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'orden-pago-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_form', array (
		'model' => $model,
		'form' => $form 
) );
?>
	<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar Orden de Pago'),array('class'=>'btn btn-primary')); ?>
	</div>

	<?php $this->endWidget(); ?>
<?php
/*$this->beginWidget('LGVerticalTab', array(
			'tagIdContent' => 1,
			'tagTitle' => 'Comprobantes',
			'expandedTab' => false,
));*/
?>
<?php
echo $this->renderPartial ( 'comprobantes_plano', array (
		'model' => $model,
		'id_orden_pago' => $model->id_orden_pago 
), true );
?>
<?php //$this->endWidget(); ?>
</div>

<div class="contenedor-tabla">
<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 4,
		'tagTitle' => 'Pagos con Cheques',
		'expandedTab' => false 
) );
?>
<?php
$pago = OrdenPago::getPago($model->id_orden_pago);
echo $this->renderPartial ( '/pago/cheques', array (
		'model' => $pago,
		'id_pago' => $pago->id_pago 
), true );

?>
<?php $this->endWidget(); ?>
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 5,
		'tagTitle' => 'Pagos con Transferencias',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( '/pago/transferencias', array (
		'model' => $pago,
		'id_pago' => $pago->id_pago 
), true )?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 6,
		'tagTitle' => 'Pagos con Efectivo',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( '/pago/efectivos', array (
		'model' => $pago,
		'id_pago' => $pago->id_pago 
), true )?>
	<?php $this->endWidget(); ?>
	<?php
	$this->beginWidget ( 'LGVerticalTab', array (
			'tagIdContent' => 3,
			'tagTitle' => 'Pagos con Tarjeta',
			'expandedTab' => false 
	) );
	?>
	<?php
	echo $this->renderPartial ( '/pago/tarjetas', array (
			'model' => $pago,
			'id_pago' => $pago->id_pago 
	), true )?>
	<?php $this->endWidget(); ?>

</div>

<div class="row-center">
  <span >
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $pago->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank' 
	) );
    ?>
    </span>
    <span>
    <?php 
	echo CHtml::link ( 'Volver', $this->createUrl ( 'pago/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
</div>
<!-- form -->
