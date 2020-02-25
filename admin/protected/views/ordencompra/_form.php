
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'numero_orden'); ?>
<?php echo $form->textField($model,'numero_orden',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'numero_orden'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
'name' => 'OrdenCompra[Fecha]',
				'language' => 'es',
				'value' => $model->Fecha,
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
<?php echo $form->error($model,'Fecha'); ?>
	</div>

<?php echo $form->hiddenField($model,'Cantidad'); ?>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="Proveedor">Proveedor</label><?php
			
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
                                                                                { jQuery("#OrdenCompra_id_proveedor").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["telefono"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenCompra_id_proveedor").val(0); }' 
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
		<div class="contenedor-columna">
			<label for="Obra">Obra</label><?php
			if ($model->id_obra != ''  && $model->id_obra>0) {
				$value = $model->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo $form->hiddenField ( $model, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $model,
					'source' => isset($update) && $update? $this->createUrl ( 'obra/autoCompleteBuscarAll' ):$this->createUrl ( 'obra/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 80,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenCompra_id_obra").val(ui.item["id"]);
jQuery("#OrdenCompra_Entrega").val(ui.item["Direccion"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenCompra_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label>Detalle</label>
			<script type="text/javascript">
			   
function copiValue(evt){
		evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
     if (charCode == 13) {
    	        $("#OrdenCompra_Detalle").val($("#OrdenCompra_Detalle").val()+"\n"+$("#item").val());
    	        $("#item").val("");
    	        $("#item").focus();
                return false;
    } 
     $("#item").focus();
    return true;}

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
						'onclick' => '$("#OrdenCompra_Detalle").val($("#OrdenCompra_Detalle").val()+"\n"+$("#item").val()); $("#item").val("");$("#item").focus();' 
				) );
				?>
				<br>
<?php echo $form->textArea($model, "Detalle", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'Detalle'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Atencion'); ?>
<?php echo $form->textField($model,'Atencion',array('size'=>27,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Atencion'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Autorizo'); ?>
<?php echo $form->textField($model,'Autorizo',array('size'=>27,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Autorizo'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Solicitado'); ?>
<?php echo $form->textField($model,'Solicitado',array('size'=>27,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Solicitado'); ?>
	</div>
	</div>


	<!-- <div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php //echo $form->labelEx($model,'Impresa'); ?>
<?php //echo $form->checkBox($model,'Impresa'); ?>
<?php //echo $form->error($model,'Impresa'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php //echo $form->labelEx($model,'Pagada'); ?>
<?php //echo $form->checkBox($model,'Pagada'); ?>
<?php //echo $form->error($model,'Pagada'); ?>
	</div>
	</div>-->
	
	<div class="contenedor-fila">



		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Entrega'); ?>
<?php echo $form->textField($model,'Entrega',array('size'=>27,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Entrega'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Recibe'); ?>
<?php echo $form->textField($model,'Recibe',array('size'=>27,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Recibe'); ?>
	</div>
	</div>


</div>