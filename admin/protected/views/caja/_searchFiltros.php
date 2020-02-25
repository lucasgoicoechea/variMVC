<div class="wide form">




	<div class="contenedor-tabla">

		<div class="contenedor-fila">

			<div class="contenedor-columna-30">
				<label>Fecha Mov. desde</label>
                <?php
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Caja[fechaDesde]',
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
				<label>Fecha Mov. hasta</label>
                <?php
																
																$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
																		'model' => '$model',
																		'name' => 'Caja[fechaHasta]',
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

		</div>

		<div class="contenedor-fila">
			<div class="contenedor-columna-60">
				<label for="Obra">Obra</label><?php
				if ($model->id_obra != '') {
					$obra = Obra::model ()->findByPK ( $model->id_obra );
					$value = $obra->getDescripcion();
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
								'size' => 35,
								'maxlength' => 85 
						),
						// 'style' => "width:75%"
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#Caja_id_obra").val(ui.item["id"]);
jQuery("#labelObra").html(ui.item["label"]); }',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#Caja_id_obra").val(0);jQuery("#labelObra").html(""); }' 
						) 
				) )
				;
				
				?>
				</div>
				<div class="contenedor-columna-30"><label><span id="labelObra">
				<?php echo $value;?></span></label>
			</div>
		</div>

	</div>
	<div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>



</div>
<!-- search-form -->
