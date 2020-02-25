
<div class="form">
	<div class="row-center" 
		style="<?php
		if (! $model->cerrada) {
			echo "background-color: green; width: 99%;";
		} else {
			echo "background-color: red;  width: 99%;";
		}
		?>" >
		<span style="color: white; font-size: 16px; font-family: monospace;"><?php
		
		if (! $model->cerrada) {
			echo "PERMITE CIERRE DE CAJA" . '  <--- ' . LGHelper::functions ()->displayFecha ( $model->fecha ) . ' --->';
		} else
			echo "CIERRE DE CAJA REALIZADO" . '  <--- ' . LGHelper::functions ()->displayFecha ( $model->fecha ) . ' --->';
		?>
	</span>
	</div>
	<?php
		if (strlen ( $errorFechaCaja ) > 0) { ?>
	<div class="row-center" 
		style="background-color: orange;  width: 99%;"
		 >
		<span style="color: white; font-size: 16px; font-family: monospace;"><?php
				echo $errorFechaCaja;
		?>
	</span>
	</div>
	<?php } ?>
	<div class="row-center" 
		style="<?php
		if (strlen ( $facturasPendientes ) > 2) {
			echo "background-color: orange;   width: 99%;";
		}
		?>"><?php ECHO "EXISTEN FACTURAS A COBRAR: ".$facturasPendientes;?>
	</div>
	<div class="contenedor-tabla">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'caja-cierre-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_cabeceraCierre', array (
		'model' => $model,
		'form' => $form 
) );
?>
	
</div>

	<div class="row-center" id="permite_cierre">
	<?php
	if (! $model->cerrada) {
		echo CHtml::link ( 'CERRAR CAJA', Yii::app ()->createUrl ( 'caja/cerrarCaja', array (
				"id_caja" => $model->id_caja 
		) ), array (
				'update' => '#time',
				'title' => 'Cerrar Caja Diaria',
				'class' => 'btn button',
				'id' => 'cerrarCaja' 
		) );
	}
	?>
	</div>
<div class="contenedor-tabla">
<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 1,
		'tagTitle' => 'Saldos Gastos por Cuenta',
		'expandedTab' => true 
) );
?>
<?php

echo $this->renderPartial ( 'saldosGastosPorCuenta', array (
		'id_caja' => $model->id_caja 
), true );

?>
<?php $this->endWidget(); ?>
</div>
	<div class="contenedor-tabla">
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 2,
		'tagTitle' => 'Gastos Diarios Pagados',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'gastos', array (
		'caja' => $model,
		'pagados' => true,
		'id_caja' => $model->id_caja 
), true );

?>
<?php $this->endWidget(); ?>
</div>
	<div class="contenedor-tabla">
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 22,
		'tagTitle' => 'Gastos Diarios Pendientes de Pago',
		'expandedTab' => false 
) );
?>

<?php

echo $this->renderPartial ( 'gastos', array (
		'caja' => $model,
		'pagados' => false,
		'enOP'  => true,
		'id_caja' => $model->id_caja 
), true );

?>
<?php $this->endWidget(); ?>
</div>
	<div class="contenedor-tabla">
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 43,
		'tagTitle' => 'Gastos Diarios NO Pagados - SIN Orden de Pago',
		'expandedTab' => false 
) );
?>

<?php

echo $this->renderPartial ( 'gastos', array (
		'caja' => $model,
		'pagados' => false,
		'enOP'  => false,
		'id_caja' => $model->id_caja 
), true );

?>
<?php $this->endWidget(); ?>
</div>
	
	<div class="contenedor-tabla">
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 5,
		'tagTitle' => 'Transferencias entre Cuentas',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'transferenciasCuentas', array (
		'model' => $model 
), true );
?>
<?php $this->endWidget(); ?>
</div>
	<div class="contenedor-tabla">

<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 6,
		'tagTitle' => 'Cheques Emitidos',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'chequesEmitidos', array (
		'caja' => $model 
), true );
?>
	<?php $this->endWidget(); ?>
	</div>
	<div class="contenedor-tabla">
<?php

$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 11,
		'tagTitle' => 'Transferencias Banco',
		'expandedTab' => false 
) );
?>
<?php

$model->fechaDesde = $model->fecha;
$model->fechaHasta = $model->fecha;
echo $this->renderPartial ( 'transferenciaBanco', array (
		'caja' => $model 
), true );

$this->endWidget ();
?>
</div>
	<div class="contenedor-tabla">
	<?php
	$this->beginWidget ( 'LGVerticalTab', array (
			'tagIdContent' => 13,
			'tagTitle' => 'Pagos con Tarjeta',
			'expandedTab' => false 
	) );
	?>
	<?php
echo $this->renderPartial ( 'tarjetas', array (
			'caja' => $model 
	), true );
	?>
	<?php $this->endWidget(); ?>

</div>

	<div class="contenedor-tabla">
	<?php
	$this->beginWidget ( 'LGVerticalTab', array (
			'tagIdContent' => 23,
			'tagTitle' => 'Cobros',
			'expandedTab' => false 
	) );
	?>
	<?php
	echo $this->renderPartial ( 'cobros', array (
			'caja' => $model 
	), true )?>
	<?php $this->endWidget(); ?>

</div>
	<div class="contenedor-tabla">
	<?php
	$this->beginWidget ( 'LGVerticalTab', array (
			'tagIdContent' => 3,
			'tagTitle' => 'Ingresos a Cuenta',
			'expandedTab' => false 
	) );
	?>
	<?php
	echo $this->renderPartial ( 'ingresosACuenta', array (
			'caja' => $model 
	), true )?>
	<?php $this->endWidget(); ?>

</div>
	<div class="contenedor-tabla">
	<?php
	$this->beginWidget ( 'LGVerticalTab', array (
			'tagIdContent' => 7,
			'tagTitle' => 'Contra Asientos',
			'expandedTab' => false 
	) );
	?>
	<?php
	echo $this->renderPartial ( 'contraAsientos', array (
			'caja' => $model 
	), true )?>
	<?php $this->endWidget(); ?>

</div>
<?php
$this->endWidget ();
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
				echo CHtml::link ( 'Volver', $this->createUrl ( 'pago/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>

	</div>
</div>