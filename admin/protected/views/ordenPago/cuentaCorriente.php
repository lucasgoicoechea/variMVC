<div class="titulo">Cuenta Corriente Proveedor por Cuenta</div>
<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'orden-pago-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_formCuentaCorriente', array (
		'model' => $model,
		'form' => $form 
) );
?>
	<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Buscar'),array('class'=>'btn btn-primary')); ?>
	</div>

	<?php $this->endWidget(); ?>
	</div>
<!-- form -->
<?php
if ($model->id_proveedor > 0) {
?>
<div class="form">
   
</div>
<?php
 echo $this->renderPartial('aPagarYPagado', array('id_cuenta'=>$model->id_cuenta , 'id_proveedor'=>$model->id_proveedor ));

}
?>