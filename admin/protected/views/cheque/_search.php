<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'serie'); ?>
                <?php echo $form->textField($model,'serie'); ?>
        </div>

       
        <div class="row">
                <?php echo $form->label($model,'Numero'); ?>
                <?php echo $form->textField($model,'Numero',array('size'=>60,'maxlength'=>510)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'FechaEmision'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cheque[FechaEmision]',
								 //'language'=>'de',
								 'value'=>$model->FechaEmision,
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
                <?php echo $form->label($model,'FechaPago'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cheque[FechaPago]',
								 //'language'=>'de',
								 'value'=>$model->FechaPago,
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

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
