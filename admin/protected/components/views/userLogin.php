<?php echo CHtml::beginForm(); ?>
<div class="row">
<?php echo CHtml::activeLabel($form,'Usuario'); ?>
<?php echo CHtml::activeTextField($form,'username')?>
<?php echo CHtml::error($form,'username'); ?>

<?php echo CHtml::activeLabel($form,'Contraseña'); ?>
<?php echo CHtml::activePasswordField($form,'password')?>
<?php echo CHtml::error($form,'password'); ?>


<?php echo CHtml::submitButton('Ingresar',array('class'=>'btn btn-primary')); ?>
</div>
<?php echo CHtml::endForm(); ?>
