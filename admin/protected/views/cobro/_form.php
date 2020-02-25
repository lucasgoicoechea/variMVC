
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label for="TipoComprobante">Tipo Factura</label>
				<?php
				$htmlOptionsProvincia = array (
						"ajax" => array (
								"url" => $this->createUrl ( "cambiarFactura" ),
								"type" => "POST",
								"update" => "#id_nro_factura" 
						) 
				// "empty" => "Seleccione un Comprobante"
								);
				?>
				<?php echo CHtml::activeDropDownList($model,'id_tipo_factura',$model->getTipoFactura(),$htmlOptionsProvincia); ?>
			</div>

		<div class="contenedor-columna-30">
			<label>Nro.Factura *</label>
			<div id="id_nro_factura">
<?php echo $form->textField($model,'NumFactura',array('size'=>10,'maxlength'=>20,'readonly'=>false)); ?>
</div>	
<?php echo $form->error($model,'NumFactura'); ?>
	</div>
			<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php
		
		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Cobro[Fecha]',
				'language' => 'es',
				'value' => LGHelper::functions ()->displayFecha ( $model->Fecha != null ? $model->Fecha : CTimestamp::formatDate ( 'Y-m-d' ) ),
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:100px !important' 
				),
				'options' => array (
						'showButtonPanel' => true,
						'changeYear' => true,
						'changeYear' => true 
				) 
		) );
		;
		?>
<?php echo $form->error($model,'Fecha'); ?>
	</div>
	
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'Importe'); ?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
		'element'=>'#Cobro_Importe',
		'currency'=>'PHP',
		'config'=>array(
				'symbolStay'=>true,
				'thousands'=>'.',
				'decimal'=>',',
				'precision'=>2,
		)
));
echo $form->textField($model,'Importe',['id'=>'Cobro_Importe']); 
?>
<?php echo $form->error($model,'Importe'); ?>
	</div>
		<div class="contenedor-columna-10">
			<label>Cobrado</label>
<?php echo CHtml::activeCheckBox($model,'cobrado'); ?>
	</div>
	<div class="contenedor-columna-20">
			<label>Expediente</label>
		<?php echo $form->textField($model,'expediente',array('size'=>40,'maxlength'=>90)); ?>
		<?php echo $form->error($model,'expediente'); ?>
	</div>
	
	</div>
	<div class="contenedor-fila">

		<div class="contenedor-columna-90">
			<label for="Obra">Cliente *</label><?php
			if ($model->id_cliente != '') {
				$value = $model->cliente->descripcion;
			} else {
				$value = '';
			}
			
			echo $form->hiddenField ( $model, 'id_cliente' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_cliente',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'cliente/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#Cobro_id_cliente").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Cobro_id_cliente").val(0); }' 
					) 
			) );
			?>
			</div>
		<div class="contenedor-columna">
			<label for="Obra">Obra *</label><?php
			if ($model->id_obra != '') {
				$value = $model->obra->Codigo . ' - ' . $model->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo $form->hiddenField ( $model, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $model,
					'source' => isset($update) && $update? $this->createUrl  ( 'obra/autoCompleteBuscarAll' ):$this->createUrl ( 'obra/autoCompleteBuscar' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#Cobro_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Cobro_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label>Detalles</label>
			<script type="text/javascript">
			   
function copiValue(evt){
		evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
     if (charCode == 13) {
    	        $("#Cobro_Detalles").val($("#Cobro_Detalles").val()+"\n"+$("#item").val());
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
						'onclick' => '$("#Cobro_Detalles").val($("#Cobro_Detalles").val()+"\n"+$("#item").val());' 
				) );
				?>
				<br>
<?php echo $form->textArea($model, "Detalles", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'Detalles'); ?>
	</div>
	</div>
</div>
