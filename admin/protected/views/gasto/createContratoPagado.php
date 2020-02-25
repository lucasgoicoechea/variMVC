
<div class="titulo">Agregar Pago a Subcontrato</div>

<div class="form">
<?php 
Yii::app()->clientScript->registerCoreScript('jquery');     
Yii::app()->clientScript->registerCoreScript('jquery.ui');
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
								"url" => $this->createUrl ( "cambiarComprobanteContratoPagado" ),
								"type" => "POST",
								"update" => "#formulario" ,
                                "readOnly" => isset($readOnlyContrato)
						) ,
						"empty" => "Seleccione un Comprobante"
				);
				?>
				<?php echo CHtml::activeDropDownList($model,'id_tipo_comprobante',$model->getTipoComprobanteSubcontrato(),$htmlOptionsProvincia); ?>
				<?php echo $form->error($model,'id_tipo_comprobante'); ?>
			</div>
	</div>
<?php if(isset($errores)){
echo "<div style='color:red'>".$errores."</div>";
}?>	
<?php echo $form->errorSummary($model); ?>
	<div id="formulario">
<?php

if ($model->id_tipo_comprobante != null){
	$formulario =  TipoComprobante::model ()->getFormularioSegunTipo($model->id_tipo_comprobante);
	echo $this->renderPartial ( $formulario, array (
					'model' => $model,
					'modelPago' => $modelPago,
			         'subcontrato' => true,
	               'labelBotonSummit' => $labelBotonSummit,
                   'readOnlyContrato' => isset($readOnlyContrato)
					//'form' => $form
		) );
}
?>
</div>


<?php $this->endWidget(); ?>

</div>
