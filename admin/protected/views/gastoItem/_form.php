

<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
<div class="contenedor-fila">
<div class="contenedor-columna-60">
			<label for="Material">Material *</label>
			<?php
				$value = $model->material!=null?$model->material->getDescripcionShort():'';
			
			echo CHtml::activeHiddenField ( $model, 'id_material' );

				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_material',
						'value' => $value,
						'model' => $model,
						'source' => $this->createUrl ( 'gastoItem/autoCompleteBuscarMaterial' ),
						'htmlOptions' => array (
								'size' => 55,
								'maxlength' => 100,
								'style' => "width:75%" 
						),
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_material").val(ui.item["id"]);
jQuery("#medida").val(ui.item["Medida"]);listGastoItems(); }',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#GastoItem_id_material").val(0); }' 
						) 
				) );
			
			?>
			</div>
		<div class="contenedor-columna-30">
			<label>Medida</label>
			<?php echo CHtml::textField ( "medida", $model->material->Medida ); ?>
			</div>
	
	
</div>	
	<div class="contenedor-fila">
	<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'valor_unidad'); ?>
		
<?php echo CHtml::activeTextField($model,'valor_unidad',array('size'=>20,'maxlength'=>12,'id'=>'GastoItem_valor_unidad')); ?>
<?php echo CHtml::error($model,'valor_unidad'); ?>
	</div>
	
	<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'cantidad'); ?>
	
<?php echo CHtml::activeTextField($model,'cantidad',array('size'=>20,'maxlength'=>12,'id'=>'GastoItem_cantidad')); ?>
<?php echo CHtml::error($model,'cantidad'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo CHtml::activeLabel($model,'valor_final'); ?>
		
<?php echo CHtml::activeTextField($model,'valor_final',array('size'=>20,'maxlength'=>12,'id'=>'GastoItem_valor_final')); ?>
<?php echo CHtml::error($model,'valor_final'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
	<div class="contenedor-columna-30">
		<label><b>CONSUMIDO</b></label>
		</div>
	<div class="contenedor-columna-30">
	<?php echo CHtml::activeTextField($model,'consumido',array('size'=>20,'maxlength'=>12,'id'=>'GastoItem_consumido')); ?>
		<?php echo CHtml::error($model,'consumido'); ?>
	</div>	
	</div>		
</div>
<script type="text/javascript">
 
function listGastoItems()
 {
	/* var data = $('#Gasto_id_material').val();
	$.ajax({
	   	  dataType : "html",
	   	  url: '<?php echo Yii::app()->createAbsoluteUrl('gasto/listarGastoItems').'?id='; ?>'+data,
	   	  success: function(dataHtml) {
	   	   dataInnerHtml = dataHtml;
	   	   window.parent.$('#comboSubcontratos').html(dataInnerHtml);
	   	  }
	   	})*/
}
</script>