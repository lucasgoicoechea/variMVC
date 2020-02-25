<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

     <div class="row">
                <?php echo $form->label($model,'numero_orden'); ?>
                <?php echo $form->textField($model,'numero_orden'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'OrdenCompra[Fecha]',
								 //'language'=>'de',
								 'value'=>$model->Fecha,
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

       

        <div class="row">
                <?php echo $form->label($model,'Cantidad'); ?>
                <?php echo $form->textField($model,'Cantidad',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Detalle'); ?>
                <?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>120)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Atencion'); ?>
                <?php echo $form->textField($model,'Atencion',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Autorizo'); ?>
                <?php echo $form->textField($model,'Autorizo',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Solicitado'); ?>
                <?php echo $form->textField($model,'Solicitado',array('size'=>60,'maxlength'=>100)); ?>
        </div>

     
        <div class="row">
                <?php echo $form->label($model,'Entrega'); ?>
                <?php echo $form->textField($model,'Entrega',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Recibe'); ?>
                <?php echo $form->textField($model,'Recibe',array('size'=>40,'maxlength'=>40)); ?>
        </div>

      
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
