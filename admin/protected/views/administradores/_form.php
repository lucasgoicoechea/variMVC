
<p class="error">
	Campos con <span class="required">*</span> son obligatorios.
</p>

<?php echo $form->errorSummary($model); ?>

<div class="contenedor-tabla">

	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'usuario'); ?>
<?php echo $form->textField($model,'usuario',array('size'=>20,'maxlength'=>20)); ?>
<?php echo $form->error($model,'usuario'); ?>
	</div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'clave'); ?>
<?php echo $form->textField($model,'clave',array('size'=>20,'maxlength'=>20)); ?>
<?php echo $form->error($model,'clave'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $form->textField($model,'nombre',array('size'=>28,'maxlength'=>35,
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'nombre'); ?>
	</div>
		<div class="contenedor-columna">
		<?php echo $form->labelEx($model,'apellido'); ?>
<?php echo $form->textField($model,'apellido',array('size'=>35,'maxlength'=>35,
		'onkeyup'=>'javascript:this.value=this.value.toUpperCase();',
		'style'=>'text-transform:uppercase;')); ?>
<?php echo $form->error($model,'apellido'); ?>
	</div>
	</div>

	<div class="contenedor-fila">
		<div class="contenedor-columna">
			<label for="TipoAdministradores">Tipo administrador</label><?php
			$htmlOptions = array (
					"disabled"=>$usuario->getTipoAdmin()->isEditaPerfiles()?"":"disabled"
			);
			
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'tipoAdmin',
					'fields' => 'descripcion',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false,
					'htmlOptions' => $htmlOptions 
			) );
			?>
				</div>
		<div class="contenedor-columna">
		
	</div>
	</div>
</div>

<?php
if ($usuario->getTipoAdmin()->isEditaPerfiles ()) {
	$this->renderPartial ( "_grillaCheckBoxsColumnas", array (
			"list" => Accesos::model ()->findAll (),
			"form" => $form,
			"model" => $model,
			"atributeModel" => 'accesos_IDs',
			"key" => 'id',
			"value" => 'descripcion',
			// "title"=>'Permisos accesos',
			"subtitle" => 'Seleccione los permisos de acceso' 
	) );
}
?>    			