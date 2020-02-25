<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id_quincena'); ?>
                <?php echo $form->textField($model,'id_quincena'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php echo $form->textField($model,'id_proveedor'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'horas'); ?>
                <?php echo $form->textField($model,'horas',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'efectivo'); ?>
                <?php echo $form->textField($model,'efectivo',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'adelantos'); ?>
                <?php echo $form->textField($model,'adelantos',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_obra'); ?>
                <?php echo $form->textField($model,'id_obra'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'extras'); ?>
                <?php echo $form->textField($model,'extras',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'horas_extras'); ?>
                <?php echo $form->textField($model,'horas_extras'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'dias_trabajados'); ?>
                <?php echo $form->textField($model,'dias_trabajados'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Final'); ?>
                <?php echo $form->textField($model,'Final',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'subtotal'); ?>
                <?php echo $form->textField($model,'subtotal',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'viaticos'); ?>
                <?php echo $form->textField($model,'viaticos',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'movilidad'); ?>
                <?php echo $form->textField($model,'movilidad',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'descuentos_adelantos'); ?>
                <?php echo $form->textField($model,'descuentos_adelantos',array('size'=>10,'maxlength'=>10)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'nro_secuencia_quincena'); ?>
                <?php echo $form->textField($model,'nro_secuencia_quincena'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Quincena'); ?>
                <?php echo $form->textField($model,'Quincena',array('size'=>60,'maxlength'=>110)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_quincenal'); ?>
                <?php echo $form->textField($model,'id_quincenal'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Indice'); ?>
                <?php echo $form->textField($model,'Indice'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Quincena[Fecha]',
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
                <?php echo $form->label($model,'id_empresa'); ?>
                <?php echo $form->textField($model,'id_empresa'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
