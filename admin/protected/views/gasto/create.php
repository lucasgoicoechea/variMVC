
<div class="titulo">Crear nuevo Comprobante</div>

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
								"url" => $this->createUrl ( "cambiarComprobante" ),
								"type" => "POST",
								"update" => "#formulario" 
						) ,
						"empty" => "Seleccione un Comprobante"
				);
				?>
				<?php echo CHtml::activeDropDownList($model,'id_tipo_comprobante',$model->getTipoComprobante(),$htmlOptionsProvincia); ?>
				<?php echo $form->error($model,'id_tipo_comprobante'); ?>
			</div>
	</div>
	
<?php echo $form->errorSummary($model); ?>
	<div id="formulario">
<?php

if ($model->id_tipo_comprobante != null){
	$formulario =  TipoComprobante::model ()->getFormularioSegunTipo($model->id_tipo_comprobante);
	echo $this->renderPartial ( $formulario, array (
					'model' => $model,
	               'labelBotonSummit' => $labelBotonSummit
			, 'update' => false
					//'form' => $form
		) );
}
?>
</div>


<?php $this->endWidget(); ?>

</div>
