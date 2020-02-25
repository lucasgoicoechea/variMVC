
<div class="titulo">Actualizar datos de Factura/Comprobante</div>

<div class="form">
<?php
$idPago = $model->getPago ()->id_pago;
// echo $idPago;
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
Yii::app ()->clientScript->registerCoreScript ( 'jquery.ui' );
?>
<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'gasto-form',
		'enableAjaxValidation' => true 
) );

?>
<div class="contenedor-tabla">
		<br>
		<div class="row-center">
			<label for="TipoComprobante" style="font-size: 20px">Tipo Comprobante</label>
				<?php
				$htmlOptionsProvincia = array (
						"ajax" => array (
								"url" => $this->createUrl ( "cambiarComprobante" ),
								"type" => "POST",
								"update" => "#formulario" 
						),
						"empty" => "Seleccione un Comprobante" 
				);
				?>
				<?php echo CHtml::activeDropDownList($model,'id_tipo_comprobante',$model->getTipoComprobante(),$htmlOptionsProvincia); ?>
				<?php echo $form->error($model,'id_tipo_comprobante'); ?>
			</div>
	</div>
	
<?php echo $form->errorSummary($model); ?>
<div
		style="<?php
		if ($model->pagada) {
			echo "background-color: green; background-repeat: repeat-x; top: 100px; width: 600px; position: absolute; left: 200px;";
		} else {
			echo "background-color: red; background-repeat: repeat-x; top: 100px; width: 600px; position: absolute; left: 200px;";
		}
		?>" >
		<span style="color: white; font-size: 16px; font-family: monospace;"><?php
		
if ($model->pagada) {
			echo "PAGADO";
		} else
			echo "PENDIENTE DE PAGO";
		?></span>

	</div>
	<div id="formulario">
<?php

if ($model->id_tipo_comprobante != null) {
	$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
	echo $this->renderPartial ( $formulario, array (
			'model' => $model,
			'sinBoton' => true,
			'modelPago' => $modelPago,
			'labelBotonSummit' => $labelBotonSummit 
	// 'form' => $form
		) );
}
?>
</div>

<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 11,
		'tagTitle' => 'Detalle items',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'detalleItems', array (
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
	<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar Pago'),array('class'=>'btn btn-primary')); ?>
	</div>
<?php
/*$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 25,
		'tagTitle' => 'Retenciones y Percepciones',
		'expandedTab' => false 
) );
?>
<?php

echo $this->renderPartial ( 'retencionesPercepciones', array (
		'model' => $model,
		'id_gasto' => $model->id_gasto 
), true );

?>
<?php $this->endWidget();*/ ?>		
<div class="contenedor-tabla" id="totalesGrales">
<?php $this->actualizarTotalesGrales($model->id_pago ); ?>
</div>


	<div class="contenedor-tabla">
<?php
/*$this->beginWidget ( 'LGVerticalTab', array (
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
<?php $this->endWidget();*/ ?>
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
		'idPago' => $model->id_pago 
), true );
?>
<?php $this->endWidget(); ?>


	<?php
	/*$this->beginWidget ( 'LGVerticalTab', array (
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
	<?php $this->endWidget(); */?>

	
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
     <span>
    <?php
				echo CHtml::link ( 'Volver', $this->createUrl ( 'gasto/createPagado' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span> <span>
	<?php
// 	if ($model->isPagada () || $model->en_orden_pago) {
// 		echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/file.gif"), $model->getUrlOP (), array (
// 				'style' => 'color: white',
// 				'class' => 'btn btn-primary',
// 				'target' => '_blank' ,
//                 'title' => 'Ver Orden Pago'
// 		) );
// 	}
	?>
    </span> <span>
	<?php
	if ($model->tienePago()) {
		echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_props.png" ), $model->getUrlPago(), array (
				'style' => 'color: white',
				'class' => 'btn btn-primary',
				'target' => '_blank'  ,
                'title' => 'Ver Pago'
		) );
	}
	?>
	</span>
	</div>
</div>
 <script type="text/javascript">
 $(document).ready(function () {
	 $('#Gasto_Monto').keyup(function () { 
	 	var subtotal = $("#Gasto_Monto").val();
	 	  $.ajax({
	 	   	  dataType : "html",
	 	   	  url: '<?php echo Gasto::model ()->getUrlTotalGastoPagado ( $model->id_gasto );?>',
	 	   	  data: {refresh:'true',id_gasto:'<?php echo $model->id_gasto; ?>',neto_tmp: subtotal},
	 	   	  success: function(dataHtml) {
	 	   	    // Do something after AJAX is completed.
	 	   		  dataInnerHtml = dataHtml;
	 	   	   window.parent.$('#totalesGrales').html(dataInnerHtml);
	 	   	  }
	 	   	});
	    });
	 }); 
</script>
<?php

//$model->monto = LGHelper::functions()->formatNumber($model->monto);
$this->widget('application.extensions.moneymask.MMask',array(
			'element'=>'#GastoItem_valor_final,#GastoItem_valor_unidad,#GastoItem_cantidad,#Gasto_Monto,#EfectivoPago_Monto2,#TarjetaPago_Monto,#Cheque_Importe,#TransferenciaPago_Monto',
			'currency'=>'PHP',
			'config'=>array(
				'symbolStay'=>true,
				'thousands'=>'.',
				'decimal'=>',',
				'precision'=>2,
			)
		));
?>