<div class="wide form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( $this->route ),
		'method' => 'get' 
) );
?>
<div class="contenedor-tabla">

		<div class="contenedor-fila">
			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo',array('value'=>'')); ?>
        </div>

			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>60)); ?>
        </div>
		</div>
		<div class="contenedor-fila">
			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Direccion'); ?>
                <?php echo $form->textField($model,'Direccion',array('size'=>60,'maxlength'=>100)); ?>
        </div>

			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Localidad'); ?>
                <?php echo $form->textField($model,'Localidad',array('value'=>'','size'=>60,'maxlength'=>100)); ?>
        </div>


		</div>
		<div class="contenedor-fila">
			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Monto'); ?>
                <?php echo $form->textField($model,'Monto',array('value'=>'','size'=>10,'maxlength'=>10)); ?>
        </div>
			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Avance'); ?>
                <?php echo $form->textField($model,'Avance',array('value'=>'')); ?>
        </div>
		</div>
		<div class="contenedor-fila">


			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'FechaInicio'); ?>
                <?php
																
$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Obra[FechaInicio]',
																		// 'language'=>'de',
																		'value' => $model->FechaInicio,
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'changeYear' => true 
																		) 
																) );
																;
																?>
        </div>

			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'FechaFin'); ?>
                <?php
																
$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Obra[FechaFin]',
																		// 'language'=>'de',
																		'value' => $model->FechaFin,
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'changeYear' => true 
																		) 
																) );
																;
																?>
        </div>

			<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Justiprecio'); ?>
                <?php echo $form->textField($model,'Justiprecio',array('value'=>'','size'=>10,'maxlength'=>10)); ?>
        </div>
		</div>

	</div>
	<div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
