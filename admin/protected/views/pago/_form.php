
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'numero'); ?>
		</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'fecha_emision'); ?>
		<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Pago[fecha_emision]',
				'language' => 'es',
				'value' => $model->fecha_emision!=null?LGHelper::functions()->displayFecha($model->fecha_emision):LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
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
						<?php echo $form->error($model,'fecha_emision'); ?>
		</div>

		<div class="contenedor-columna">
			<label for="Cuenta">Cuenta</label>
			<?php
			if ($model->id_cuenta != '' && $model->id_cuenta!=0) {
				$value = $model->cuenta->getDescripcion();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_cuenta' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_cuenta',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'cuenta/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 50,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#Pago_id_cuenta").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Pago_id_cuenta").val(0); }' 
					) 
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
                                                                                { jQuery("#Pago_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Pago_id_proveedor").val(0); }' 
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
		<?php if ($model->id_pago!=null){
			echo $form->labelEx($model,'pagado');
			echo $form->checkBox($model,'pagado');
			echo $form->error($model,'pagado'); }?>
		</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fecha_cobro'); ?>
		<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Pago[fecha_cobro]',
				 'language'=>'es',
				'value' => $model->fecha_cobro!=null?LGHelper::functions()->displayFecha($model->fecha_cobro):LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
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
			<?php echo $form->error($model,'fecha_cobro'); ?>
		</div>

	</div>
</div>
