<?php
?>

<div class="titulo">Modificar Orden de Pago</div>
<div
		style="<?php
		if ($model->pagado) {
			echo "background-color: green; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
		} else {
			echo "background-color: red; background-repeat: repeat-x; width: 600px; position: absolute; left: 200px;";
		}
		?>" >
	<span style="color: white; font-size: 16px; font-family: monospace;"><?php
	
if ($model->pagado) {
		echo "PAGADO";
	} else
		echo "PENDIENTE DE PAGO";
	?>
	</span>

</div>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'pago-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_form', array (
		'model' => $model,
		'form' => $form 
) );
?>



	<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar Pago'),array('class'=>'btn btn-primary')); ?>
	</div>
	<?php
$this->endWidget ();
?>
</div>
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 2,
		'tagTitle' => 'Comprobantes/Gastos',
		'expandedTab' => false 
) );
?>
<?php

/*echo $this->renderPartial ( 'ordenesDePago', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
), true );*/
$op = $model->getOrdenPago();
//echo $op->id_orden_pago;
echo $this->renderPartial ( 'comprobantes', array (
		'model' => $op->ordenPago,
		'id_orden_pago' => $op->id_orden_pago
), true );

?>
<?php $this->endWidget(); ?>
<div class="contenedor-tabla" id="totalesGrales">
<?php $this->actualizarTotalesGrales($model->id_pago ); ?>
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

echo $this->renderPartial ( 'cheques', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
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

echo $this->renderPartial ( 'transferencias', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
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

echo $this->renderPartial ( 'efectivos', array (
		'model' => $model,
		'id_pago' => $model->id_pago 
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
	echo $this->renderPartial ( 'tarjetas', array (
			'model' => $model,
			'id_pago' => $model->id_pago 
	), true )?>
	<?php $this->endWidget(); ?>

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
	echo CHtml::link ( 'Volver', $this->createUrl ( 'pago/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	?>
	</span>
</div>
