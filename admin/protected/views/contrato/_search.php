<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_contrato'); ?>
                <?php echo $form->textField($model,'id_contrato'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Contrato[Fecha]',
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
                <?php echo $form->label($model,'Detalle'); ?>
                <?php echo $form->textField($model,'Detalle',array('size'=>60,'maxlength'=>510)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Precio'); ?>
                <?php echo $form->textField($model,'Precio',array('size'=>12,'maxlength'=>12)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Plazo'); ?>
                <?php echo $form->textField($model,'Plazo',array('size'=>20,'maxlength'=>20)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Acuerdo'); ?>
                <?php echo $form->textField($model,'Acuerdo',array('size'=>60,'maxlength'=>510)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_obra'); ?>
                <?php ; ?>
        </div>

       
        <div class="row">
                <?php echo $form->label($model,'id_usuario_autorizo'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_usuario_solicito'); ?>
                <?php ; ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
