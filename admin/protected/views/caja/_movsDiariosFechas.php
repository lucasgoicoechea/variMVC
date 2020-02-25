
<div class="form">
	<div class="contenedor-tabla">
<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 2,
		'tagTitle' => 'Gastos Diarios Pagados',
		'expandedTab' => false 
) );
?>
<?php

$gasto = new Gasto ();
$gasto->fechaDesde = $model->fechaDesde;
$gasto->fechaHasta = $model->fechaHasta;
$gasto->id_obra = $model->id_obra;
echo $this->renderPartial ( 'adminFiltrosGastos', array (
		'model' => $gasto 
), true );

?>
<?php $this->endWidget(); ?>
</div>
	<div class="contenedor-tabla">
<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 4,
		'tagTitle' => 'Saldos Gastos por Cuenta',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'saldosGastosPorCuentaFechas', array (
		'model' => $model 
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

echo $this->renderPartial ( 'transferenciasCuentasFechas', array (
		'model' => $model 
), true )?>
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

echo $this->renderPartial ( 'chequesEmitidosFechas', array (
		'caja' => $model 
), true )?>
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

echo $this->renderPartial ( 'transferenciaBancoEntreFechas', array (
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
	echo $this->renderPartial ( 'tarjetasFechas', array (
			'caja' => $model 
	), true ); ?>
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
	echo $this->renderPartial ( 'cobrosFechas', array (
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
	echo $this->renderPartial ( 'ingresosACuentaFechas', array (
			'caja' => $model 
	), true )?>
	<?php $this->endWidget(); ?>

</div>


	<div class="row-center">
		<span>
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimirFechas(), array (
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


<script type="text/javascript">
 
function sendImprimir()
 {
	var data = $('input[name^=Caja]').serialize();
  $.ajax({
	async: false,  
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl('caja/imprimirCierreDiarioFechas'); ?>',
   data:data,
   dataType: "application/pdf",   
   //contentType: "application/xml; charset=utf-8",
    success: function(data, textStatus, jqXHR) {
        var pdfWin= window.open("data:application/pdf;base64, " + data, '', 'height=650,width=840');
        // some actions with this win, example print...
    },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
  //dataType:'html'
  });
}
</script>