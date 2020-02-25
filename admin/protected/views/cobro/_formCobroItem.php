<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($modelItem); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
				
				<div class="contenedor-columna-20">
				<?php echo 'Fecha' ?>
				<?php
				
				$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
						'model' => '$modelItem',
						'name' => 'CobroItem[Fecha]',
						'language' => 'es',
						'value' => LGHelper::functions()->displayFecha($modelItem->Fecha != null ? $modelItem->Fecha : CTimestamp::formatDate ( 'Y-m-d' )),
						'htmlOptions' => array (
								'size' => 10,
								'style' => 'width:100px !important' 
						),
						'options' => array (
								'showButtonPanel' => true,
								'changeYear' => true,
								'changeYear' => true,
						) 
				) );
				;
				?>
			<?php echo CHtml::error($modelItem,'Fecha'); ?>
			</div>
		
			<div class="contenedor-columna-40">
			<?php echo 'Importe'; ?>
			<?php
			$this->widget('application.extensions.moneymask.MMask',array(
					'element'=>'#CobroItem_Importe',
					'currency'=>'PHP',
					'config'=>array(
							'symbolStay'=>true,
							'thousands'=>'.',
							'decimal'=>',',
							'precision'=>2,
					)
			));
			echo CHtml::activeTextField($modelItem,'Importe',['id'=>'CobroItem_Importe']); 
			?>
			<?php echo CHtml::error($modelItem,'Importe'); ?>
			</div>
			<div class="contenedor-columna-20">
					<?php echo CHtml::activeLabel($modelItem,'FechaCobro'); ?>
					<?php
						$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
										'model' => '$modelItem',
										'name' => 'CobroItem[FechaCobro]',
						'language' => 'es',
										'value' => $modelItem->FechaCobro!=null?LGHelper::functions()->displayFecha($modelItem->FechaCobro):'',
										'htmlOptions' => array (
												'size' => 10,
												'style' => 'width:100px !important' 
										),
										'options' => array (
												'showButtonPanel' => true,
												'changeYear' => true,
												'changeYear' => true,
										
										) 
								) );
								;
							?>
					<?php echo CHtml::error($modelItem,'FechaCobro'); ?>
						</div>
		</div>

		<div class="contenedor-fila">	
				
					<div class="contenedor-columna-30">
							<label for="Imputacion">Tipo de Cobro</label><?php
							$this->widget ( 'application.components.Relation', array (
									'model' => $modelItem,
									'relation' => 'imputacion',
									'fields' => 'Nombre',
									'allowEmpty' => false,
									'style' => 'dropdownlist',
									'showAddButton' => false 
							) );
							?>
							</div>
						<div class="contenedor-columna-30">
							<label for="FormaPago">Forma de Cobro</label>
								<?php echo CHtml::activeDropDownList($modelItem,'id_forma',$modelItem->getFormasPago(),array()); ?>
							</div>
						<div class="contenedor-columna-30">
						<label>Nro.OP</label>
							<?php echo CHtml::activeTextField($modelItem,'numero_orden_pago',array('size'=>20,'maxlength'=>90)); ?>
							<?php echo CHtml::error($modelItem,'numero_orden_pago'); ?>
					</div>			
		</div>		

		<div class="contenedor-fila">	
		
		<div class="contenedor-columna-30">
			<?php echo CHtml::activeLabel($modelItem,'nro_cheque_certificado'); ?>
	<?php echo CHtml::activeTextField($modelItem,'nro_cheque_certificado',array('size'=>20,'maxlength'=>110)); ?>
	<?php echo CHtml::error($modelItem,'nro_cheque_certificado'); ?>
		</div>
		<div class="contenedor-columna-30">
			<label for="Cuenta">Cuenta Cobradora</label>
			<?php
			if ($modelItem->id_cuenta != '' && $modelItem->id_cuenta!=0) {
				$value = $modelItem->cuenta->getDescripcion ();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $modelItem, 'id_cuenta' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_cuenta',
					'value' => $value,
					'model' => $modelItem,
					'source' => $this->createUrl ( 'cuenta/autoCompleteBuscarCobradora' ),
					'htmlOptions' => array (
							'size' => 35,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#CobroItem_id_cuenta").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#CobroItem_id_cuenta").val(0); }' 
					) 
			) );
			?>
		</div>
		<div class="contenedor-columna-30">
		<label for="CuentaBanco">Cuenta Banco</label><?php 
						$this->widget('application.components.Relation', array(
								'model' => $modelItem,
								'relation' => 'cuentaBanco',
								'fields' => 'descripcion',
								'allowEmpty' => false,
								'style' => 'dropdownlist',
								'showAddButton' => false,
								)
							); ?>
				</div>
		</div>
		<div class="contenedor-fila">
			<div class="contenedor-columna-90">
				<label>Detalles</label>			
					<?php		
					echo CHtml::textField ( "item", 'Agregar items', array (
							'size' => 65,
							'maxlength' => 100,
							'onkeypress' => 'copiValue(event)' 
					) );
					?>
					<?php			
					$imageUrl = Yii::app ()->theme->baseUrl . "/img/icons/add.png";
					echo CHtml::link ( '<img src="' . $imageUrl . '" alt="Agregar item de Detalle" />', "#", array (
							'class' => 'linkClass',
							'onclick' => '$("#CobroItem_Detalles").val($("#CobroItem_Detalles").val()+"\n"+$("#item").val());' 
					) );
					?>
					<br>
			<?php echo CHtml::activeTextArea($modelItem, "Detalles", array('style'=>'width: 720px; height: 100px;')); ?>
			<?php echo CHtml::error($modelItem,'Detalles'); ?>
		</div>
		</div>
		<script type="text/javascript">
				   
			function copiValue(evt){
					evt = (evt) ? evt : event;
				var charCode = (evt.charCode) ? evt.charCode :
					((evt.which) ? evt.which : evt.keyCode);
				if (charCode == 13) {
							$("#CobroItem_Detalles").val($("#CobroItem_Detalles").val()+"\n"+$("#item").val());
							$("#item").val("");
							return false;
				} 
				return true;}
			
			/*$(document).ready(function() {
				$("#cobro-form").keypress(function(e) {
					//Para deshabilitar el uso de la tecla "Enter"
					if (e.which == 13) {
						return false;
						}
					});
				});*/ 
		</script> 		
	</div>
</div>