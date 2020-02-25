<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>


<div class="contenedor-tabla">

	<div class="contenedor-fila">

		<div class="contenedor-columna">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo'); ?>
        </div>

       <div class="contenedor-columna">
                <?php echo $form->label($model,'FechaAsiento'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Gasto[FechaAsiento]',
								 //'language'=>'de',
								 'value'=>$model->FechaAsiento,
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
 
       <div class="contenedor-columna">
                <label>Número de Factura o Comprobante</label>
                <?php echo $form->textField($model,'NumComprobante',array('size'=>60,'maxlength'=>510)); ?>
        </div>

       <div class="contenedor-columna">
                <?php echo $form->label($model,'Monto'); ?>
                <?php echo $form->textField($model,'Monto',array('size'=>12,'maxlength'=>12)); ?>
        </div>

       <div class="contenedor-columna">
                <label>Fecha Factura o Compra</label>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Gasto[FechaFactura]',
								 //'language'=>'de',
								 'value'=>$model->FechaFactura,
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
</div>
       <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
