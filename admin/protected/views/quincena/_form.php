<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'Indice'); ?>
		<?php echo $form->textField($model,'Indice',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'Indice'); ?>
	</div>
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'nro_secuencia_quincena'); ?>
<?php echo $form->textField($model,'nro_secuencia_quincena',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'nro_secuencia_quincena'); ?>
	</div>

		<div class="contenedor-columna">
			<label for="Quincenal">Quincena *</label><?php
			
			if ($model->id_quincenal!=null && $model->id_quincenal != '' && $model->id_quincenal != 0) {
				$value = $model->quincenal->getDescripcion();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_quincenal' );
			/*if ($model->id_quincenal != '' && $model->id_quincenal != 0) {
				echo CHtml::textField ( "Quincena", $model->quincenal->getDescripcion (), array (
						'size' => 50,
						///'readonly' => true 
				) );
			} else {*/
				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_quincenal',
						'value' => $value,
						'model' => $model,
						'source' => $this->createUrl ( 'quincenal/autoCompleteBuscar' ),
						'htmlOptions' => array (
								'size' => 55,
								'maxlength' => 100,
								'style' => "width:75%" 
						),
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                      { jQuery("#Quincena_id_quincenal").val(ui.item["id"]);
jQuery("#telefono").val(ui.item["Quincena"]); }',
								'search' => 'js:function(event, ui)
                                      { jQuery("#Quincena_id_quincenal").val(0); }' 
						) 
				) );
			//}
			?>
			Si no existe, crear <?php
	echo CHtml::link('+', $this->createUrl('quincenal/create'),array('style'=>'color: white', 'class' => 'btn btn-primary'));
	?>
		</div>	
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Fecha'); ?>
<?php
	$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => '$model',
		'name' => 'Quincena[Fecha]',
		'language' => 'es',
			//'value' => $model->Fecha!=null?LGHelper::functions()->displayFecha($model->Fecha):'',
		'value' => $model->Fecha,
		'htmlOptions' => array (
				'size' => 10,
				'style' => 'width:100px !important' 
		),
		'options' => array (
				'showButtonPanel' => true,
				'changeYear' => true 
		) 
) );

?>
<?php echo $form->error($model,'Fecha'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-50">
			<label for="Personal">Personal *</label><?php
			
			if ($model->id_proveedor != '' && $model->id_proveedor != 0) {
				$value = $model->personal->getDescripcion();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_proveedor' );
			if ($model->id_proveedor != '' && $model->id_proveedor != 0) {
				echo CHtml::textField ( "personal", $model->personal->getDescripcion (), array (
						'size' => 50,
						'readonly' => true 
				) );
			} else {
				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_proveedor',
						'value' => $value,
						'model' => $model,
						'source' => $this->createUrl ( 'personal/autoCompleteBuscar' ),
						'htmlOptions' => array (
								'size' => 55,
								'maxlength' => 100,
								'style' => "width:75%" 
						),
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_proveedor").val(ui.item["id"]);
jQuery("#categoria").val(ui.item["categoria"]);}',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_proveedor").val(0); }' 
						) 
				) );
			}
			?>
			</div>
		<div class="contenedor-columna-40">
			<label>Categoría</label>
		 <?php
			
			if ($model->id_proveedor != '' && $model->id_proveedor != 0) {
				echo CHtml::textField ( "categoria", $model->personal->getCategoria (), array('size'=>40,'maxlength'=>40));
			} else {
				echo CHtml::textField ( "categoria", '' , array('size'=>40,'maxlength'=>40)); 
			}
			
			?>
	
	</div>
	</div>
	<div class="contenedor-fila" >
		<div class="contenedor-columna">
			<label for="Obra">Obra *</label><?php
			
			if ($model->id_obra != null && $model->id_obra != '' && $model->id_obra != 0) {
				$value = $model->obra->getDescripcion ();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_obra' );
			if (isset ( $subcontrato )) {
				if ($model->id_obra != '' && $model->id_obra != 0) {
					echo CHtml::textField ( "obra", $model->obra->getDescripcion (), array (
							'size' => 60,
							'readonly' => true 
					) );
				} else {
					echo CHtml::textField ( "obra", '', array (
							'size' => 60,
							'readonly' => true 
					) );
				}
			} else {
				$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
						'name' => 'id_obra',
						'value' => $value,
						'model' => $model,
						'source' => isset ( $update ) && $update ? $this->createUrl ( 'obra/autoCompleteBuscarAll' ) : $this->createUrl ( 'obra/autoCompleteBuscar' ),
						'htmlOptions' => array (
								'size' => 60,
								'maxlength' => 65 
						),
						// 'style' => "width:75%"
						'options' => array (
								'minLength' => '1',
								'showAnim' => 'fold',
								'select' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_obra").val(ui.item["id"]); }',
								'search' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_obra").val(0); }' 
						) 
				) );
			}
			?>
			</div>
			<div class="contenedor-columna-30">
			<label for="Cuenta">Cuenta </label>
			<?php
			if ($model->id_cuenta != '' && $model->id_cuenta!=0) {
				$value = $model->cuenta->getDescripcion();
			} else {
				$value = '';
			}
			
			echo CHtml::activeHiddenField ( $model, 'id_cuenta' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_cuenta',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'cuenta/autoCompleteBuscarAdministradora' ),
					'htmlOptions' => array (
							'size' => 30,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_cuenta").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Quincena_id_cuenta").val(0); }' 
					) 
			) );
			?>
		</div>	
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'horas'); ?>
<?php echo $form->textField($model,'horas',array('size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'horas'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'horas_extras'); ?>
<?php echo $form->textField($model,'horas_extras'); ?>
<?php echo $form->error($model,'horas_extras'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'dias_trabajados'); ?>
<?php echo $form->textField($model,'dias_trabajados'); ?>
<?php echo $form->error($model,'dias_trabajados'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'efectivo'); ?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
		'element'=>'#Quincena_extras,#Quincena_viaticos,#Quincena_descuentos_adelantos,#Quincena_Final,#Quincena_subtotal,#Quincena_movilidad,#Quincena_adelantos,#Quincena_efectivo',
		'currency'=>'PHP',
		'config'=>array(
				'symbolStay'=>true,
				'thousands'=>'.',
				'decimal'=>',',
				'precision'=>2,
		)
));
echo CHtml::activeTextField($model,'efectivo',array('size'=>20,'maxlength'=>12,'id'=>'Quincena_efectivo')); 
?>
<?php echo $form->error($model,'efectivo'); ?>
	</div>

		<div class="contenedor-columna-10">

		<?php echo $form->labelEx($model,'adelantos'); ?>
<?php
echo $form->textField($model,'adelantos',['id'=>'Quincena_adelantos']); 
?>
<?php echo $form->error($model,'adelantos'); ?>
	</div>

		<div class="contenedor-columna-10">

		<?php echo $form->labelEx($model,'extras'); ?>
<?php
echo $form->textField($model,'extras',['id'=>'Quincena_extras']); 
?>
<?php echo $form->error($model,'extras'); ?>
	</div>

		<div class="contenedor-columna-10">
		<?php echo $form->labelEx($model,'viaticos'); ?>
<?php
echo $form->textField($model,'viaticos',['id'=>'Quincena_viaticos']); 
?>
<?php echo $form->error($model,'viaticos'); ?>
	</div>

		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'movilidad'); ?>
<?php
echo $form->textField($model,'movilidad',['id'=>'Quincena_movilidad']); 
?>
<?php echo $form->error($model,'movilidad'); ?>
	</div>
	<div  class="contenedor-columna-10">
	 <?php echo CHtml::button('SUMAR->', array('onclick' => 'sumar()')); ?>
	</div>
		<div  class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'subtotal'); ?>
<?php
echo $form->textField($model,'subtotal',['readonly'=>true,'id'=>'Quincena_subtotal']); 
?>
<?php echo $form->error($model,'subtotal'); ?>
	</div>
	</div>
<div class="contenedor-fila">
		<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'descuentos_adelantos'); ?>
<?php
echo $form->textField($model,'descuentos_adelantos',['id'=>'Quincena_descuentos_adelantos']); 
?>
<?php echo $form->error($model,'descuentos_adelantos'); ?>
	</div>

	<div  class="contenedor-columna-10">
	 <?php echo CHtml::button('RESTAR->', array('onclick' => 'restar()')); ?>
	</div>
	<div class="contenedor-columna-20"> <div></div><div><label></label></div></div>
		<div class="contenedor-columna-20">
		<?php echo $form->labelEx($model,'Final'); ?>
<?php
echo $form->textField($model,'Final',['readonly'=>true,'id'=>'Quincena_Final']); 
?>
<?php echo $form->error($model,'Final'); ?>
	</div>
	</div>

<script type="text/javascript">
 
 function sumar()
  {
  
	var data=$("#quincena-form").serialize();
   var dataInnerHtml;
  
   $.ajax({

	dataType:'html',
	 async: false,  
	type: 'POST',
	 url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction); ?>',
	data:data,
 success:function(data){	
	          $("#Quincena_subtotal").val(data); 
			   },
	error: function(data) { // if error occured
		  alert("Error occured.please try again");
		  alert(data);
	 },
  
   });
 }

 function restar()
  {
  
	var data=$("#quincena-form").serialize();
   var dataInnerHtml;
  
   $.ajax({

	dataType:'html',
	 async: false,  
	type: 'POST',
	 url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAFinalction); ?>',
	data:data,
 success:function(data){	
	            $("#Quincena_Final").val(data); 
			   },
	error: function(data) { // if error occured
		  alert("Error occured.please try again");
		  alert(data);
	 },
  
   });
 }
 
</script>	
</div>


