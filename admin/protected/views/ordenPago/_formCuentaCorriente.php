
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
			<div class="contenedor-columna">
				<label for="Cuenta">Cuenta</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'cuenta',
						'fields' => 'descripcion',
						'allowEmpty' => true,
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
</div>
