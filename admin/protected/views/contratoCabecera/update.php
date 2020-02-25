<div class="titulo"> Modificar Contrato</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contrato-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form,
		'update'=>true
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->
<?php 	echo $this->renderPartial ( '_viewPagos', array (
		'model' => $model
) ); ?>

<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 6,
		'tagTitle' => 'Agregar Item Subcontrato',
		'expandedTab' => false 
) );
?>
<div class="contenedor-tabla" >
<?php 
$contratoTmp = new Contrato();
$contratoTmp->id_contrato_cabecera = $model->id_contrato_cabecera;
$this->renderPartial ( 'createItemSubcontrato', array (	
	'model' => $contratoTmp,
	'id_contrato_cabecera'=>$model->id_contrato_cabecera,
    'grillaPosgrados' => 'id_subcontrato_list',
	'urlOperationAction'=>Contrato::model()->getUrlAgregarContrato($model->id_contrato_cabecera)) );
?>
</div>
<?php $this->endWidget(); ?>

<div class="contenedor-tabla" id="items_sub">

<?php 	echo $this->renderPartial ( '_viewContrato', array (
		'model' => $model
) ); ?>
</div>
 