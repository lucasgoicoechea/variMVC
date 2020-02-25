<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/themes/prolab_old/js/moment.js');

?>
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label>Código/Número de Obra</label>
<?php echo $form->textField($model,'Codigo',array('readonly'=>true)); ?>
<?php echo $form->error($model,'Codigo'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php echo $form->textField($model,'Nombre',array('size'=>70,'maxlength'=>120,
		'class'=>'upper',
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-70">
		<?php echo $form->labelEx($model,'Direccion'); ?>
<?php echo $form->textField($model,'Direccion',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Direccion'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Localidad'); ?>
<?php echo $form->textField($model,'Localidad',array('size'=>28,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Localidad'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-90">
			<label for="Obra">Cliente Contratante</label><?php
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
                                                                                { jQuery("#Obra_id_cliente").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Obra_id_cliente").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label>Monto de Contrato</label>
<?php echo $form->textField($model,'Monto',array('size'=>18,'maxlength'=>18)); ?>
<?php echo $form->error($model,'Monto'); ?>
	</div>
		<div class="contenedor-columna-30">
			<label>Valor de Justiprecio</label>
<?php echo $form->textField($model,'Justiprecio',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Justiprecio'); ?>
	</div>
	</div>
	<div class="contenedor-fila">

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'FechaInicio'); ?>
<?php

		$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => '$model',
				'name' => 'Obra[FechaInicio]',
				// 'change' => 'calcularFechas()',
				'language' => 'es',
				'value' => $model->FechaInicio != null ? LGHelper::functions ()->displayFecha ( $model->FechaInicio ) : '',
				'htmlOptions' => array (
						'size' => 10,
						'style' => 'width:80px !important' 
				),
				'options' => array (
						'onSelect' => 'js:function(event, ui){
						console.log("desde");
				        var dateText = $("#Obra_FechaFin").val();
						var aFecha1 = dateText.split("/"); 
						var f2 = $("#Obra_FechaInicio").val();
						var aFecha2 = f2.split("/");
				        aFecha1[1] = aFecha1[1]-1;
						aFecha2[1] = aFecha2[1]-1; 
						var fec1 = aFecha1[2]+"-"+aFecha1[1]+"-"+aFecha1[0];
						var fec2 = aFecha2[2]+"-"+aFecha2[1]+"-"+aFecha2[0];
						var fecha1 = moment(new Date(fec1));
						var fecha2 = moment(new Date(fec2));
						var dias = fecha1.diff(fecha2, "days");
						if(isNaN(dias))
							$("#Obra_Avance").val("Sin estimar");
				        else	{
						    dias = Math.round((dias/7)*5);
							$("#Obra_Avance").val(dias);
						dias = dias+1;
						}
}',
						'showButtonPanel' => true,
						'changeYear' => true,
						'changeYear' => true 
				) 
		) );
		;
		?>
<?php echo $form->error($model,'FechaInicio'); ?>
	</div>

		<div class="contenedor-columna-20">
			<label>Fecha de Entrega</label>
<?php

$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Obra[FechaFin]',
		'language' => 'es',
		'value' => $model->FechaFin != null ? LGHelper::functions ()->displayFecha ( $model->FechaFin ) : '',
		'htmlOptions' => array (
				'size' => 10,
				'style' => 'width:80px !important' 
		),
		'options' => array (
				'onSelect' => 'js:function(event, ui){
						console.log("hasta");
					    var dateText = $("#Obra_FechaFin").val();
						var aFecha1 = dateText.split("/"); 
						var f2 = $("#Obra_FechaInicio").val();
						var aFecha2 = f2.split("/");
				        aFecha1[1] = aFecha1[1]-1;
						aFecha2[1] = aFecha2[1]-1; 
						var fec1 = aFecha1[2]+"-"+aFecha1[1]+"-"+aFecha1[0];
						var fec2 = aFecha2[2]+"-"+aFecha2[1]+"-"+aFecha2[0];
				console.log(fec1);console.log(fec2);		
						var fecha1 = moment(new Date(fec1));
						var fecha2 = moment(new Date(fec2));
				console.log(fecha1);console.log(fecha2);
						var dias = fecha1.diff(fecha2, "days");
				        if(isNaN(dias))
							$("#Obra_Avance").val("Sin estimar");
				        else	{
						    dias = Math.round((dias/7)*5);
				dias = dias+1;
							$("#Obra_Avance").val(dias);
				}
				
}',
				'showButtonPanel' => true,
				'changeYear' => true 
		) 
) );
;
?>
<?php echo $form->error($model,'FechaFin'); ?>
	</div>
		<div class="contenedor-columna-20">
			<label>Días hábiles Obra</label>
<?php echo $form->textField($model,'Avance',array('size'=>8,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Avance'); ?>
	</div>
		<div class="contenedor-columna-20">
                <?php echo $form->labelEx($model,'terminada'); ?>
                <?php echo $form->checkBox($model,'terminada'); ?>
                <?php echo $form->error($model,'terminada'); ?>
        </div>
		<div class="contenedor-columna-20">
                <label>Muestra Saldos</label>
                <?php echo $form->checkBox($model,'muestra_saldos'); ?>
        </div>
        
		<!--  <div class="contenedor-columna-40">
			<label for="Empresas">Empresa ejecutante</label><?php
			/*
			 * $this->widget ( 'application.components.Relation', array (
			 * 'model' => $model,
			 * 'relation' => 'empresa',
			 * 'fields' => 'nombre',
			 * 'allowEmpty' => false,
			 * 'style' => 'dropdownlist',
			 * 'showAddButton' => false
			 * ) );
			 */
			?>
			</div>
		<div class="contenedor-columna-30">
			<label for="TipoObra">Tipo de Contratación</label><?php
			/*
			 * $this->widget ( 'application.components.Relation', array (
			 * 'model' => $model,
			 * 'relation' => 'tipoObra',
			 * 'fields' => 'nombre',
			 * 'allowEmpty' => false,
			 * 'style' => 'dropdownlist',
			 * 'showAddButton' => false
			 * ) );
			 */
			?>
			</div>-->
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label>Acuerdos Especiales</label>
<?php echo $form->textArea($model, "Detalles", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'Detalles'); ?>
	</div>
	</div>


</div>

<script type="text/javascript">
	$('input[type=text]').val (function () {
	    return this.value.toUpperCase();
	})
</script>