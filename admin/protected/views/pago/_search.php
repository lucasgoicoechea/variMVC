<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_pago'); ?>
                <?php echo $form->textField($model,'id_pago'); ?>
        </div>
    </div>
  	
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php echo $form->textField($model,'id_proveedor'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'id_cuenta'); ?>
                <?php echo $form->textField($model,'id_cuenta'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'pagado'); ?>
                <?php echo $form->checkBox($model,'pagado'); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'fecha_cobro'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Pago[fecha_cobro]',
								 //'language'=>'de',
								 'value'=>$model->fecha_cobro,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'fecha_emision'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Pago[fecha_emision]',
								 //'language'=>'de',
								 'value'=>$model->fecha_emision,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
