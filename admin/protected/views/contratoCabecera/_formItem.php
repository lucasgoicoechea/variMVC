
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		<div class="contenedor-columna-20">
		<label>Fecha</label>
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
						<?php echo CHtml::error($model,'Fecha'); ?>
		</div>
		<div class="contenedor-columna-30">
		<label>Precio (Formato: xxxx,dd)</label>
<?php echo CHtml::activeTextField($model,'Precio',array('size'=>20,'maxlength'=>12)); ?>
<?php echo CHtml::error($model,'Precio'); ?>
	</div>

		<div class="contenedor-columna-30">
		<label>Plazo</label>
<?php echo CHtml::activeTextField($model,'Plazo',array('size'=>15,'maxlength'=>20)); ?>
<?php echo CHtml::error($model,'Plazo'); ?>
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
<?php echo CHtml::activeTextArea($model, "Detalle", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo CHtml::error($model,'Detalle'); ?>
	</div>
	</div>
</div>
