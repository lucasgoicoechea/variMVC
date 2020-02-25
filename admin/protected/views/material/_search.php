<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_material'); ?>
                <?php echo $form->textField($model,'id_material'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Costo'); ?>
                <?php echo $form->textField($model,'Costo',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_rubro'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_subrubro'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Observaciones'); ?>
                <?php echo $form->textField($model,'Observaciones',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Medida'); ?>
                <?php echo $form->textField($model,'Medida',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Material[Fecha]',
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

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
