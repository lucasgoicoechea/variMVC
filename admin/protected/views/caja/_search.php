<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_caja'); ?>
                <?php echo $form->textField($model,'id_caja'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'codigo'); ?>
                <?php echo $form->textField($model,'codigo'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Caja[fecha]',
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
                <?php echo $form->label($model,'numero'); ?>
                <?php echo $form->textField($model,'numero',array('size'=>40,'maxlength'=>40)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'importe'); ?>
                <?php echo $form->textField($model,'importe',array('size'=>12,'maxlength'=>12)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_cuenta'); ?>
                <?php echo $form->textField($model,'id_cuenta'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'cerrada'); ?>
                <?php echo $form->checkBox($model,'cerrada'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
