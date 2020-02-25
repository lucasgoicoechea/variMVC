<?php echo isset($title)?"<h4 class='titulo'>".$title."</h4>":""; ?>
<?php echo isset($subtitle)?"<h4 class='note'>".$subtitle."</h5>":""; ?>
<div class="contenedor-tabla">
        <?php
								
echo CHtml::activeCheckBoxList ( $model, $atributeModel, CHtml::listData ( $list, $key, $value ), array (
										'separator' => '',
										'template' => '<div class="contenedor-columna-30 contenedor-fila">{input}&nbsp;{label}</div>' 
								) );
								?>
        <?php echo $form->error($model, 'accesos'); ?>
</div>
