
<div class="titulo">Actualizar datos de Factura/Comprobante</div>
<?php $idPago = $model->getPago()->id_pago;?>
<div class="form">
<?php
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
								"url" => $this->createUrl ( "cambiarComprobanteSinBoton" ),
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
		<span style="color: white; font-size: 16px; font-family: monospace;"><?php if ($model->pagada) {
			echo "PAGADO";
		}
		else echo "PENDIENTE DE PAGO";
			?></span>
		
	</div>
	<div id="formulario">
<?php

if ($model->id_tipo_comprobante != null) {
	$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
	echo $this->renderPartial ( $formulario, array (
			'model' => $model,
'labelBotonSummit'=>$labelBotonSummit ,
'sinBoton' => true,
			'update' => true
	// 'form' => $form
		) );
}
?>
</div>
<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 25,
		'tagTitle' => 'Retenciones y Percepciones',
		'expandedTab' => false 
) );
?>
<?php
echo $this->renderPartial ( 'retencionesPercepciones', array (
		'model' => $model,
		'id_gasto' => $model->id_gasto ,
		'idPago' =>$idPago
), true );

?>
<?php $this->endWidget(); ?>
<div class="row-center">
	<?php 		echo CHtml::submitButton ( Yii::t ( 'app', $labelBotonSummit ), array (
				'class' => 'btn btn-primary' 
		) );
	?>
</div>
<div class="row-center" id="totalGastoID">
<div
		style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 750px; text-align: center; padding: 5px;"
		class="contenedor-columna">
		<b><label>TOTAL</label></b> <b>$ <?php
		$montoTotalPAGADO = $model->getMontoTotal();
		echo LGHelper::functions ()->formatNumber ( $montoTotalPAGADO );
?></b>
	</div>
</div>		


<?php $this->endWidget(); ?>
 </div>	
 <script type="text/javascript">
 $(document).ready(function () {
	 $('#Gasto_Monto').keyup(function () { 
	 	var subtotal = $("#Gasto_Monto").val();
	 	  $.ajax({
	 	   	  dataType : "html",
	 	   	  url: '<?php echo Gasto::model ()->getUrlTotalGasto ( $model->id_gasto );?>',
	 	   	  data: {refresh:'true',id_gasto:'<?php echo $model->id_gasto; ?>',neto_tmp: subtotal},
	 	   	  success: function(dataHtml) {
	 	   	    // Do something after AJAX is completed.
	 	   		  dataInnerHtml = dataHtml;
	 	   	   window.parent.$('#totalGastoID').html(dataInnerHtml);
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
