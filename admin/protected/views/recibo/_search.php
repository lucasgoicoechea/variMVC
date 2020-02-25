<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_contrato'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Recibo[fecha]',
								 //'language'=>'de',
								 'value'=>$model->fecha,
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
                <?php echo $form->label($model,'Importe'); ?>
                <?php echo $form->textField($model,'Importe',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Detalle'); ?>
                <?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>510)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_obra'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_recibo'); ?>
                <?php echo $form->textField($model,'id_recibo'); ?>
        </div>
        <div class="row">
                <?php echo $form->label($model,'impreso'); ?>
                <?php echo $form->checkBox($model,'impreso'); ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
