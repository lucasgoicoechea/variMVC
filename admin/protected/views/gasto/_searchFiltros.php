<div class="wide form">

<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( $this->route ),
		'method' => 'get' 
) );
?>


<div class="contenedor-tabla">

		<div class="contenedor-fila">

			<div class="contenedor-columna-20">
                <?php echo $form->label($model,'Codigo'); ?>
                <?php echo $form->textField($model,'Codigo',array('size'=>10,'maxlength'=>510)); ?>
        </div>

			<div class="contenedor-columna-20">
                <?php echo $form->label($model,'FechaAsiento'); ?>
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Gasto[FechaAsiento]',
																		'value' => $model->FechaAsiento,
																		'htmlOptions' => array (
																				'size' => 10,
																				'style' => 'width:80px !important' 
																		),
																		'language' => 'es',
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>

			<div class="contenedor-columna-30">
				<label>Número de Factura o Comprobante</label>
                <?php echo $form->textField($model,'NumComprobante',array('size'=>20,'maxlength'=>510)); ?>
        </div>

			<div class="contenedor-columna-20">
                <?php echo $form->label($model,'Monto'); ?>
                <?php echo $form->textField($model,'Monto',array('size'=>12,'maxlength'=>12)); ?>
        </div>
		</div>

		<div class="contenedor-fila">

			<div class="contenedor-columna-30">
				<label>Fecha Factura/Compra desde</label>
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Gasto[fechaDesde]',
																		// 'language'=>'de',
																		'value' => $model->fechaDesde,
																		'language' => 'es',
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'changeMonth' => true,
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>

			<div class="contenedor-columna-30">
				<label>Fecha Factura/Compra hasta</label>
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Gasto[fechaHasta]',
																		'value' => $model->fechaHasta,
																		'language' => 'es',
																		'flat' => false,
																		'options' => array (
																				'showButtonPanel' => true,
																				'changeYear' => true,
																				'firstDay' => 1,
																				// 'showOn' => "both",
																				'constrainInput' => true,
																				'currentText' => 'Now' 
																		) 
																) );
																;
																?>
        </div>
			<div class="contenedor-columna-30">
				<label>Medio de Pago</label>
			<?php echo $form->dropDownList($model, 'id_medio_pago', CHtml::listData(MedioPago::model()->findAll(), 'id_medios_pago','nombre'), array('empty'=>'Seleccionar..')); ?>
	
	</div>

		</div>

		<div class="contenedor-fila">
			<div class="contenedor-columna-80">
				<label for="Obra">Obra</label><?php
				if ($model->id_obra != '') {
					$value = $model->obra->Nombre;
				} else {
					$value = '';
				}
				
				echo $form->hiddenField ( $model, 'id_obra' );
				
				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_obra',
						'value' => $value,
						'model' => $model,
						'source' => $this->createUrl ( 'obra/autoCompleteBuscarAll' ),
						'htmlOptions' => array (
								'size' => 55,
								'maxlength' => 85 
						),
						// 'style' => "width:75%"
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_obra").val(ui.item["id"]); }',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_obra").val(0); }' 
						) 
				) );
				?>
			</div>
		</div>


		<div class="contenedor-fila">
			<div class="contenedor-columna-60">
				<label for="Proveedor">Proveedor</label><?php
				
				if ($model->id_proveedor != ''  && $model->id_proveedor!=0) {
					$value = $model->proveedor->Nombre;
				} else {
					$value = '';
				}
				
				echo CHtml::activeHiddenField ( $model, 'id_proveedor' );
				
				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_proveedor',
						'value' => $value,
						'model' => $model,
						'source' => $this->createUrl ( 'proveedor/autoCompleteBuscar' ),
						'htmlOptions' => array (
								'size' => 55,
								'maxlength' => 100,
								'style' => "width:95%" 
						),
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_proveedor").val(0); }' 
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
				echo CHtml::textField ( "telefono", '' );
			}
			?>
	
	</div>
		</div>
	</div>
	<div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
