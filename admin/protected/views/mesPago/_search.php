<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'porcentage_rectorado'); ?>
                <?php echo $form->textField($model,'porcentage_rectorado'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'porcentage_facultad'); ?>
                <?php echo $form->textField($model,'porcentage_facultad'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'fecha_pago'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'MesPago[fecha_pago]',
								 //'language'=>'de',
								 'value'=>$model->fecha_pago,
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
                <?php echo $form->textField($model,'numero',array('size'=>45,'maxlength'=>45)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_conv_individual'); ?>
                <?php echo $form->textField($model,'id_conv_individual',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'pagado'); ?>
                <?php echo $form->textField($model,'pagado'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_forma_pago'); ?>
                <?php echo $form->textField($model,'id_forma_pago',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'asignacion'); ?>
                <?php echo $form->textField($model,'asignacion'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'mes_periodo'); ?>
                <?php echo $form->textField($model,'mes_periodo',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'ano_periodo'); ?>
                <?php echo $form->textField($model,'ano_periodo',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
