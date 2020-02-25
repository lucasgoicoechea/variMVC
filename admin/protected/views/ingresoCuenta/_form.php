
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'fecha'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				// 'model'=>'$model',
				'name' => 'IngresoCuenta[fecha]',
				'language' => 'es',
				'value' => $model->fecha != null ? LGHelper::functions()->displayFecha($model->fecha) : LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:95px !important' 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
				) 
		) );
		;
		?>
<?php echo CHtml::error($model,'fecha'); ?>
	</div>
	
			<div class="contenedor-columna-30">
			<label for="Cuenta">Cuenta Cobradora</label>
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
					'source' => $this->createUrl ( 'cuenta/autoCompleteBuscarAdministradora' ),
					'htmlOptions' => array (
							'size' => 30,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#IngresoCuenta_id_cuenta").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#IngresoCuenta_id_cuenta").val(0); }' 
					) 
			) );
			?>
		</div>	
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'importe'); ?>
<?php echo $form->textField($model,'importe'); ?>
<?php echo $form->error($model,'importe'); ?>
	</div>
		<div class="contenedor-columna-30">
			<label for="FormaPago">Forma de Pago</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'formaPago',
					'fields' => 'Nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
			</div>
	<div class="contenedor-fila">
			<div class="contenedor-columna">
			<label for="Obra">Obra</label><?php
			if ($model->id_obra != '') {
				$value = $model->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $model,
					'source' => isset($update) && $update? $this->createUrl  ( 'obra/autoCompleteBuscarAll' ):$this->createUrl ( 'obra/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 80,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#IngresoCuenta_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#IngresoCuenta_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'descripcion'); ?>
<?php echo $form->textArea($model,'descripcion',array( 'style'=>'width: 752px; height: 87px;','size'=>140,'maxlength'=>250)); ?>
<?php echo $form->error($model,'descripcion'); ?>
	</div>
	</div>

</div>
