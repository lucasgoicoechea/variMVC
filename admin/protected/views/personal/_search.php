<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Apellido'); ?>
                <?php echo $form->textField($model,'Apellido',array('size'=>43,'maxlength'=>43)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>43,'maxlength'=>43)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'TipoDoc'); ?>
                <?php echo $form->textField($model,'TipoDoc',array('size'=>18,'maxlength'=>18)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'NumDoc'); ?>
                <?php echo $form->textField($model,'NumDoc',array('size'=>17,'maxlength'=>17)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'CUIL'); ?>
                <?php echo $form->textField($model,'CUIL',array('size'=>34,'maxlength'=>34)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Domicilio'); ?>
                <?php echo $form->textField($model,'Domicilio',array('size'=>30,'maxlength'=>30)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Nro'); ?>
                <?php echo $form->textField($model,'Nro',array('size'=>13,'maxlength'=>13)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Piso'); ?>
                <?php echo $form->textField($model,'Piso',array('size'=>30,'maxlength'=>30)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Dpto'); ?>
                <?php echo $form->textField($model,'Dpto',array('size'=>16,'maxlength'=>16)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Localidad'); ?>
                <?php echo $form->textField($model,'Localidad',array('size'=>28,'maxlength'=>28)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'codigo_postal'); ?>
                <?php echo $form->textField($model,'codigo_postal',array('size'=>4,'maxlength'=>4)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'provincia'); ?>
                <?php echo $form->textField($model,'provincia',array('size'=>18,'maxlength'=>18)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Nacion'); ?>
                <?php echo $form->textField($model,'Nacion',array('size'=>9,'maxlength'=>9)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_categoria_mano_obra'); ?>
                <?php echo $form->textField($model,'id_categoria_mano_obra'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'estado_civil'); ?>
                <?php echo $form->textField($model,'estado_civil',array('size'=>12,'maxlength'=>12)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'codigo_area'); ?>
                <?php echo $form->textField($model,'codigo_area',array('size'=>7,'maxlength'=>7)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Telefono'); ?>
                <?php echo $form->textField($model,'Telefono',array('size'=>32,'maxlength'=>32)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_empresa'); ?>
                <?php echo $form->textField($model,'id_empresa'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Numero_Libreta'); ?>
                <?php echo $form->textField($model,'Numero_Libreta',array('size'=>35,'maxlength'=>35)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Banco_Fondo_Desempleo'); ?>
                <?php echo $form->textField($model,'Banco_Fondo_Desempleo',array('size'=>16,'maxlength'=>16)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Numero_Fondo_Desempleo'); ?>
                <?php echo $form->textField($model,'Numero_Fondo_Desempleo',array('size'=>11,'maxlength'=>11)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Asignacion_Familiar'); ?>
                <?php echo $form->textField($model,'Asignacion_Familiar',array('size'=>3,'maxlength'=>3)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'ObraSocial'); ?>
                <?php echo $form->textField($model,'ObraSocial',array('size'=>28,'maxlength'=>28)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Pantalon'); ?>
                <?php echo $form->textField($model,'Pantalon'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Camisa'); ?>
                <?php echo $form->textField($model,'Camisa'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Botin'); ?>
                <?php echo $form->textField($model,'Botin'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_obra'); ?>
                <?php echo $form->textField($model,'id_obra'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php echo $form->textField($model,'id_proveedor'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'Fecha_Ingreso'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Personal[Fecha_Ingreso]',
								 //'language'=>'de',
								 'value'=>$model->Fecha_Ingreso,
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
                <?php echo $form->label($model,'Fecha_Nacimiento'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Personal[Fecha_Nacimiento]',
								 //'language'=>'de',
								 'value'=>$model->Fecha_Nacimiento,
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
                <?php echo $form->label($model,'Fecha_ropa'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Personal[Fecha_ropa]',
								 //'language'=>'de',
								 'value'=>$model->Fecha_ropa,
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
                <?php echo $form->label($model,'Fecha_Baja'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Personal[Fecha_Baja]',
								 //'language'=>'de',
								 'value'=>$model->Fecha_Baja,
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

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
