
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">
	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<label>Nro. Contrato</label>
<?php echo $form->textField($model,'id_contrato',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'id_contrato'); ?>
	</div>
	
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php
		
		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Contrato[Fecha]',
				'language' => 'es',
				'value' => $model->Fecha != null ? LGHelper::functions()->displayFecha($model->Fecha) : LGHelper::functions()->displayFecha(CTimestamp::formatDate ( 'Y-m-d' )),
				'htmlOptions' => array (
						'size' => 18,
						'style' => 'width:100px !important' 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
					
				) 
		) );
		;
		?>
						<?php echo $form->error($model,'Fecha'); ?>
		</div>
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Precio'); ?>
<?php echo $form->textField($model,'Precio',array('size'=>20,'maxlength'=>12)); ?>
<?php echo $form->error($model,'Precio'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Plazo'); ?>
<?php echo $form->textField($model,'Plazo',array('size'=>15,'maxlength'=>20)); ?>
<?php echo $form->error($model,'Plazo'); ?>
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
							'size' => 35,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#Contrato_id_obra").val(ui.item["id"]); 
jQuery("#direccion").val(ui.item["Direccion"])}',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Contrato_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
		<div class="contenedor-columna-30">
			<label>Dirección</label>
			<?php
			if ($model->id_obra != '') {
				echo CHtml::textField ( "direccion", $model->obra->Direccion, array (
						'size' => 40 
				) );
			} else {
				echo CHtml::textField ( "direccion", '', array (
						'size' => 40 
				) );
			}
			?>
		</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="Proveedor">Proveedor</label>
			<?php
			if ($model->id_proveedor != ''  && $model->id_proveedor!=0) {
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
                                                                                { jQuery("#Contrato_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Contrato_id_proveedor").val(0); }' 
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
	</div>	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label>Detalle</label>
			<script type="text/javascript">
			   
function copiValue(evt){
		evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
     if (charCode == 13) {
    	        $("#Contrato_Detalle").val($("#Contrato_Detalle").val()+"\n"+$("#item").val());
    	        $("#item").val("");
                return false;
    } 
    return true;}

$(document).ready(function() {
	$("#contrato-form").keypress(function(e) {
		//Para deshabilitar el uso de la tecla "Enter"
		if (e.which == 13) {
			return false;
			}
		});
	}); 
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
						'onclick' => '$("#Contrato_Detalle").val($("#Contrato_Detalle").val()+"\n"+$("#item").val());' 
				) );
				?>
				<br>
<?php echo $form->textArea($model, "Detalle", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'Detalle'); ?>
	</div>
	</div>
	
	
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Acuerdo'); ?>
<?php echo $form->textArea($model,'Acuerdo', array('style'=>'width: 720px; height: 100px;'));  ?>
<?php echo $form->error($model,'Acuerdo'); ?>
	</div>
	</div>
	
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="UsersLogin">Solicita:</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'usuarioSolicito',
					'fields' => 'username',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
		<div class="contenedor-columna">
			<label for="UsersLogin">Autoriza:</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'usuarioAutorizo',
					'fields' => 'username',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
	</div>
</div>
