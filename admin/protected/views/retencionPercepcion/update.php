<?php


?>

<div class="titulo"> Modificar Retencion/Percepcion</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retencion-percepcion-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row-center">
	<?php echo CHtml::submitButton(Yii::t('app', 'Guardar'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

<?php 
$valores = new RetencionPercepcionValores();
$valores->id_retencion_percepcion = $model->id_retencion_percepcion; 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'retencion-percepcion-valores-grid',
	'dataProvider'=>$valores->search(),
	'filter'=>$valores,
	'columns'=>array(
		'valor',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

</div>
<div>
<?php 
$valorForm = new RetencionPercepcionValores();
$valorForm->id_retencion_percepcion = $model->id_retencion_percepcion; 
		$this->renderPartial('createValores',array(
			'model'=>$valorForm,
		));
		?>
</div>
<!-- form -->
