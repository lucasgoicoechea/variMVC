
<div class="titulo">Crear nuevo Comprobante Pagado</div>

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
								"url" => $this->createUrl ( "cambiarComprobantePagado" ),
								"type" => "POST",
								"update" => "#formulario",
								"readOnly" => isset ( $readOnlyContrato ) 
						),
						"empty" => "Seleccione un Comprobante" 
				);
				?>
				<?php echo CHtml::activeDropDownList($model,'id_tipo_comprobante',$model->getTipoComprobante(),$htmlOptionsProvincia); ?>
				<?php echo $form->error($model,'id_tipo_comprobante'); ?>
			</div>
	</div>
<?php

if (isset ( $errores )) {
	echo "<div style='color:red'>" . $errores . "</div>";
}
if ($id_exito != null) {
	$exito = Gasto::model ()->findByPk ($id_exito);
	echo "<div style='color:green'> GASTO REGISTRADO CON EXITO, ID:" . $id_exito. "</div>";
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $exito->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank'
	) );
	if ($exito->id_contrato_cabecera != null && $exito->id_contrato_cabecera>0) {
		echo CHtml::link ( 'Pago Subcontrato: '.CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $exito->getUrlImprimirContrato (), array (
				'style' => 'color: white',
				'class' => 'btn btn-primary',
				'target' => '_blank'
		) );
	}
}
?>	
<?php echo $form->errorSummary($model); ?>
	<div id="formulario">
<?php

if ($model->id_tipo_comprobante != null) {
	$formulario = TipoComprobante::model ()->getFormularioSegunTipo ( $model->id_tipo_comprobante );
	echo $this->renderPartial ( $formulario, array (
			'model' => $model,
			'modelPago' => $modelPago,
			'labelBotonSummit' => $labelBotonSummit,
			'readOnlyContrato' => isset ( $readOnlyContrato ) 
	)
	// 'form' => $form
	 );
}
?>
</div>


<?php $this->endWidget(); ?>

</div>
