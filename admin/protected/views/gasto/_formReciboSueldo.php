
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>


<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'Codigo'); ?>
<?php echo CHtml::activeTextField($model,'Codigo',array('readonly'=>true,'size'=>12,'maxlength'=>12)); ?>
<?php echo CHtml::error($model,'Codigo'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'FechaAsiento'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				// 'model'=>'$model',
				'name' => 'Gasto[FechaAsiento]',
				'language' => 'es',
				'value' => $model->FechaAsiento!=null?LGHelper::functions()->displayFecha($model->FechaAsiento):LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:80px !important' ,
						 'readonly'=>true 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true
				) 
		) );
		;
		?>
<?php echo CHtml::error($model,'FechaAsiento'); ?>
	</div>
		<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'Monto'); ?>
		<?php
		//$model->Monto = LGHelper::functions()->formatNumber($model->Monto);
	  $this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#Gasto_Monto',
                    'currency'=>'PHP',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>'.',
                        'decimal'=>',',
                        'precision'=>2,
                    )
                ));
		
		?>
<?php echo CHtml::activeTextField($model,'Monto',array('size'=>20,'maxlength'=>12,'id'=>'Gasto_Monto')); ?>
<?php echo CHtml::error($model,'Monto'); ?>
	</div>
	
	<!-- <div class="contenedor-columna-10">
		<label>Ticket</label>
<?php //echo CHtml::activeCheckBox($model,'en_blanco'); ?>
<?php //echo CHtml::error($model,'pagada'); ?>
	</div> -->
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php //echo CHtml::activeLabel($model,'NumComprobante'); ?>
		<label>Número de Comprobante</label>
<?php echo CHtml::activeTextField($model,'NumComprobante',array('size'=>40,'maxlength'=>510)); ?>
<?php echo CHtml::error($model,'NumComprobante'); ?>
	</div>
		<div class="contenedor-columna-30">
		<label>Fecha de Compra</label>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Gasto[FechaFactura]',
				'language' => 'es',
				'value' => $model->FechaFactura!=null?LGHelper::functions()->displayFecha($model->FechaFactura):LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
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
<?php echo CHtml::error($model,'FechaFactura'); ?>
	</div>
		
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
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
							'style' => "width:75%" 
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
	<div class="contenedor-fila">
			<div class="contenedor-columna">
			<label for="Obra">Obra *</label><?php
			if ($model->id_obra != '') {
				$value = $model->obra->getDescripcion();
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
                                                                                { jQuery("#Gasto_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Gasto_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>
	
	<?php if (isset($modelPago)){ ?>
	     <div class="contenedor-fila">
	         <div class="contenedor-columna-60">
			<label for="Cuenta">Cuenta</label>
			<?php
			if ($model->id_cuenta != '' && $model->id_cuenta!=0) {
				$value = Cuenta::model()->findByPk($model->id_cuenta)->getDescripcion ();
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
<div class=contenedor-columna-30">
<label>Fecha de Cobro</label><?php  

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Pago[fecha_cobro]',
				'language' => 'es',
				'value' => $model->FechaCobro!=null?LGHelper::functions()->displayFecha($model->FechaCobro):LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
				'value' => $modelPago->fecha_cobro,
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
		 echo CHtml::error($modelPago,'fecha_cobro'); ?>
</div>	    
	    </div>
<?php 	}?>
	
	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label>Detalle</label>
			<script type="text/javascript">
			   
function copiValue(evt){
		evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
     if (charCode == 13) {
    	        $("#Gasto_Detalle").val($("#Gasto_Detalle").val()+"\n"+$("#item").val());
    	        $("#item").val("");
                return false;
    } 
    return true;}

/*$(document).ready(function() {
	$("#gasto-form").keypress(function(e) {
		//Para deshabilitar el uso de la tecla "Enter"
		if (e.which == 13) {
			return false;
			}
		});
	});*/ 
</script> 			
					
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
						'onclick' => '$("#Gasto_Detalle").val($("#Gasto_Detalle").val()+"\n"+$("#item").val());' 
				) );
				?>
				<br>
<?php echo CHtml::activeTextArea($model, "Detalle", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo CHtml::error($model,'Detalle'); ?>
	</div>
	</div>
	
	<div class="row-center">
	<?php
	if (isset ( $sinBoton ) && $sinBoton) {
		echo '';
	} else {
		echo CHtml::submitButton ( Yii::t ( 'app', $labelBotonSummit ), array (
				'class' => 'btn btn-primary' 
		) );
	}
	?>
</div>
</div>