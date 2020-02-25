
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo CHtml::errorSummary($model); ?>

<div class="contenedor-tabla">
		
	<div class="contenedor-fila">
<div class="contenedor-columna-30">
			<label for="FormaPago">Detalle Item</label><?php

			$htmlOptions = array (
					"ajax" => array (
							"url" => $this->createUrl ( "valoresByRetPercep" ),
							"type" => "POST",
							"update" => "#GastoRetencionPercepcion_valor"
					)
			);
			
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'retencionPercepcion',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false ,
					'htmlOptions'=> $htmlOptions
			) );
			/*echo CHtml::link ( '>>> Crear Nueva Retencion-Percepción <<<' , '', array (
					'onclick' => 'habilitar();'
			) );*/
			?>
			
			</div>
	
		<div class="contenedor-columna-25">
				<label>Valores</label>
				<?php echo CHtml::activeDropDownList($model,'valor',$model->getValores()); ?>
			</div>
			<div class="contenedor-columna-20">
	<label>Otro valor</label>
<?php echo CHtml::activeTextField($model,'otroValor',array('size'=>12,'maxlength'=>12)); ?>
	</div>
	</div>

</div>
