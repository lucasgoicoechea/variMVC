
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
			<div class="contenedor-columna-20">
		<label>Código</label>
<?php echo $form->textField($model,'id_proveedor',array('readonly'=>true,'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->error($model,'id_proveedor'); ?>
	</div>
	
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Nombre'); ?>
<?php echo $form->textField($model,'Nombre',array('size'=>60,'maxlength'=>70,
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'Nombre'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Telefono'); ?>
<?php echo $form->textField($model,'Telefono',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Telefono'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Celular'); ?>
<?php echo $form->textField($model,'Celular',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Celular'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Fax'); ?>
<?php echo $form->textField($model,'Fax',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Fax'); ?>
	</div>
	</div>
	
		<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'telefono_dos'); ?>
<?php echo $form->textField($model,'telefono_dos',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'telefono_dos'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'telefono_tres'); ?>
<?php echo $form->textField($model,'telefono_tres',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'telefono_tres'); ?>
	</div>
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'telefono_cuatro'); ?>
<?php echo $form->textField($model,'telefono_cuatro',array('size'=>25,'maxlength'=>100)); ?>
<?php echo $form->error($model,'telefono_cuatro'); ?>
	</div>
	</div>


	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'Direccion'); ?>
<?php echo $form->textField($model,'Direccion',array('size'=>45,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Direccion'); ?>
	</div>
	<div class="contenedor-columna-40">
		<?php echo $form->labelEx($model,'Contacto'); ?>
<?php echo $form->textField($model,'Contacto',array('size'=>40,'maxlength'=>100)); ?>
<?php echo $form->error($model,'Contacto'); ?>
	</div>
	</div>
<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'E_Mail'); ?>
<?php echo $form->textField($model,'E_Mail',array('size'=>60,'maxlength'=>100)); ?>
<?php echo $form->error($model,'E_Mail'); ?>
	</div>
	</div>
	

	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'Cuit'); ?>
<?php echo $form->textField($model,'Cuit',array('size'=>25,'maxlength'=>30)); ?>
<?php echo $form->error($model,'Cuit'); ?>
	</div>
	
	</div>



	<div class="contenedor-fila">


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
		<div class="contenedor-columna">
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
					</div>
					
	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="TipoGasto">Tipo de Gasto</label><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'tipoGasto',
					'fields' => 'nombre',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
				<div class="contenedor-columna-30">
		<label>Otro Tipo de Gasto</label>
<?php echo $form->textField($model,'SubTipo',array('size'=>25,'maxlength'=>60)); ?>
<?php echo $form->error($model,'SubTipo'); ?>
	</div>
	</div>
</div>
