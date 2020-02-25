
<?php echo $form->errorSummary($model); ?>

		<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'fecha'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Caja[fecha]',
								 'language'=>'es',
						 		'value' => $model->fecha != null ? LGHelper::functions()->displayFecha($model->fecha) : '',
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,
							 		/*'onChange'=>CHtml::ajax(
									 				array(
									 						'type'=>'POST',
									 						'url'=>CController::createUrl('caja/listarMovsDiarios'),
									 						'update'=>'#time',
									 				)
									 		)*/
									 		),
									 		'htmlOptions' => array(
									 				'size'=>10,
									 				'style' => 'height:20px;'
									 		),
								 )
							 );
					; ?>
					<?php echo CHtml::submitButton(Yii::t('app', 'Ir a Fecha'),array('class'=>'btn btn-primary')); ?>
					
	</div>
	<div class="contenedor-columna-60">
					<span class="left" style="float: right;">
					<?php     
				echo CHtml::link ( 'Volver', $this->createUrl ( '/' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?></span></div>
</div>