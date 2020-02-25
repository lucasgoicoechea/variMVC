<p class="note">
	Fields with <span class="required">*</span> are required.
</p>
<div class="contenedor-tabla">
<?php echo $form->errorSummary($model); ?>

<div class="contenedor-fila">
		<?php echo $form->labelEx($model,'mensaje'); ?>
<?php echo $form->textArea($model, "mensaje", array('style'=>'width: 720px; height: 100px;')); ?>
<?php echo $form->error($model,'mensaje'); ?>
	</div>


<div class="contenedor-fila">
				<?php echo $form->labelEx($model,'id_userslogin_destino'); ?><?php
			$this->widget ( 'application.components.Relation', array (
					'model' => $model,
					'relation' => 'destinatario',
					//'fields' => 'nombreApellidoAdmin',
					'fields' => 'username',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
					'showAddButton' => false 
			) );
			?>
			</div>
	<?php echo $form->error($model,'id_userslogin_destino'); ?>
	</div>



</div>
