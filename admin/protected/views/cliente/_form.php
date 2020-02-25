
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna-10">
	
			<label> Código</label>
<?php echo $form->textField($model,'codigo',array('readonly'=>true,'size'=>5,'maxlength'=>10)); ?>
<?php echo $form->error($model,'codigo'); ?>
	</div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>40,'maxlength'=>62,
			'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'nombre'); ?>
	</div>
		<div class="contenedor-columna-30">
		<label>CUIT/CUIL</label>
<?php echo $form->textField($model,'cuit',array('size'=>18,'maxlength'=>18)); ?>
<?php echo $form->error($model,'cuit'); ?>
	</div>
	
	</div>

	<div class="contenedor-fila">
	<div class="contenedor-columna-60">
		<?php echo $form->labelEx($model,'direccion'); ?>
<?php echo $form->textField($model,'direccion',array('size'=>40,'maxlength'=>100)); ?>
<?php echo $form->error($model,'direccion'); ?>
	</div>

		<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'responsable'); ?>
<?php echo $form->textField($model,'responsable',array('size'=>30,'maxlength'=>100)); ?>
<?php echo $form->error($model,'responsable'); ?>
	</div>
	
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'telefono'); ?>
<?php echo $form->textField($model,'telefono',array('size'=>20,'maxlength'=>100)); ?>
<?php echo $form->error($model,'telefono'); ?>
	</div>

		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'fax'); ?>
<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>100)); ?>
<?php echo $form->error($model,'fax'); ?>
	</div>

	</div>



	<div class="contenedor-fila">
		<div class="contenedor-columna-25">
					<?php
					$htmlOptionsProvincia = array (
							"ajax" => array (
									"url" => $this->createUrl ( "partidosByProvincia" ),
									"type" => "POST",
									"update" => "#Cliente_id_partido" 
							) 
					);
					?>
				<label>Provincia</label>
				<?php echo CHtml::activeDropDownList($model,'id_provincia',$model->getProvincias(),$htmlOptionsProvincia); ?>
				<?php echo $form->error($model,'id_provincia'); ?>
			</div>
		<div class="contenedor-columna-25">
					<?php
					$htmlOptions = array (
							"ajax" => array (
									"url" => $this->createUrl ( "ciudadByPartido" ),
									"type" => "POST",
									"update" => "#Cliente_id_localidad" 
							) 
					);
					?>
				<label>Partido</label>
				<?php echo CHtml::activeDropDownList($model,'id_partido',$model->getPartidos(),$htmlOptions); ?>
				<?php echo $form->error($model,'id_partido'); ?>
			</div>
		<div class="contenedor-columna-30">
			<label>Localidad</label>
		<?php echo CHtml::activeDropDownList($model,'id_localidad',$model->getCiudades()); ?>
		<?php echo $form->error($model,'id_localidad'); ?>
	</div>
	</div>
	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
			<label for="Moneda">Moneda</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'moneda',
					'fields' => 'nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
					<div class="contenedor-columna">
			<label for="CategoriaIVA">Categoria IVA</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'categoriaIVA',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false ,
			) );
			?>
			</div>
			
	</div>
</div>
