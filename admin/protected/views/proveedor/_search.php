<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'id_proveedor'); ?>
                <?php echo $form->textField($model,'id_proveedor'); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Nombre'); ?>
                <?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>70)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Telefono'); ?>
                <?php echo $form->textField($model,'Telefono',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Celular'); ?>
                <?php echo $form->textField($model,'Celular',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Fax'); ?>
                <?php echo $form->textField($model,'Fax',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Direccion'); ?>
                <?php echo $form->textField($model,'Direccion',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Contacto'); ?>
                <?php echo $form->textField($model,'Contacto',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'Cuit'); ?>
                <?php echo $form->textField($model,'Cuit',array('size'=>30,'maxlength'=>30)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'E_Mail'); ?>
                <?php echo $form->textField($model,'E_Mail',array('size'=>60,'maxlength'=>100)); ?>
        </div>

        <div class="contenedor-fila">
                <?php echo $form->label($model,'SubTipo'); ?>
                <?php echo $form->textField($model,'SubTipo',array('size'=>60,'maxlength'=>60)); ?>
        </div>

        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
