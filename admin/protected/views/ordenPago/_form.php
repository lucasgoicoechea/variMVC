
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'numero_op'); ?>
<?php echo $form->textField($model,'numero_op',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'numero_op'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
'name' => 'OrdenPago[fecha]',
				'language' => 'es',
				'value' => $model->fecha,
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:80px !important' 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
				) 
		) );
		;
		?>
<?php echo $form->error($model,'fecha'); ?>
	</div>
			<div class="contenedor-columna">
				<label for="Cuenta">Cuenta</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'cuenta',
						'fields' => 'descripcion',
						'allowEmpty' => false,
						'style' => 'dropdownlist',
						'showAddButton' => false 
				) );
				?>
			</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="Proveedor">Proveedor</label>
			<?php

			if ($model->id_proveedor != '' && $model->id_proveedor!=0) {
				$value = $model->proveedor->Nombre;
			} else {
				$value = '';
			}

			echo $form->hiddenField ( $model, 'id_proveedor' );

			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_proveedor',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'proveedor/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 100,
							'style' => "width:75%" 
							),
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenPago_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenPago_id_proveedor").val(0); }' 
                                                                                )
                                                                                ) );
                                                                                ?>
		</div>
		<div class="contenedor-columna-30">
			<label>Telefono</label>
			<?php

			if ($model->id_proveedor != ''  && $model->id_proveedor!=0) {
				echo CHtml::textField ( "telefono", $model->proveedor->Telefono );
			} else {
				echo CHtml::textField ( "telefono" );
			}
			?>

		</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'observacion'); ?>
<?php echo $form->textArea($model, "observacion", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'observacion'); ?>
	</div>
	</div>

</div>
