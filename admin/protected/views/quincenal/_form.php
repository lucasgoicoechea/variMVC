<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
	<div class="contenedor-columna-10">
				<label>Año</label>
			<?php
			
echo CHtml::activeDropDownList ( $model, 'anio', LGHelper::functions ()->getYearsExistingFrom ($actual=2019), array (
					"class" => 'comboEstudios',
					//"empty" => 'Seleccione solo para buscar' 
			) );
			?>
		</div>
	
	<div class="contenedor-columna-20">
				<label>Mes</label>
			<?php
echo CHtml::activeDropDownList ( $model, 'mes', LGHelper::functions()->getMonths(),array('style'=>"width:100px",
					"class" => 'comboEstudios',
					//"empty" => 'Todos los meses' 
			) );
			?>
		</div>
	<div class="contenedor-columna-20">
				<label>Quincena</label>
			<?php
echo CHtml::activeDropDownList ( $model, 'quincena', LGHelper::functions()->getQuincenas(),array('style'=>"width:100px",
					"class" => 'comboEstudios',
					//"empty" => 'Todos los meses' 
			) );
			?>
		</div>
		
	<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>80,'readonly' => true) ); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>
	</div>
