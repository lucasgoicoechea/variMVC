<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">


  
  	
 <div class="contenedor-fila">

		<div class="contenedor-columna-90">
			<label for="Obra">Cliente</label><?php
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
			<label for="Obra">Obra</label><?php
			if ($model->id_obra != '') {
				$value = $model->obra->Nombre;
			} else {
				$value = '';
			}
			
			echo $form->hiddenField ( $model, 'id_obra' );
			
			$this->widget ( 'zii.widgets.jui.CJuiAutoComplete', array (
					'name' => 'id_obra',
					'value' => $value,
					'model' => $model,
					'source' => $this->createUrl ( 'obra/autoCompleteBuscarAll' ),
					'htmlOptions' => array (
							'size' => 55,
							'maxlength' => 85 
					),
					// 'style' => "width:75%"
					'options' => array (
							'minLength' => '1',
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenCompra_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#OrdenCompra_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Importe'); ?>
                <?php echo $form->textField($model,'Importe',array('size'=>12,'maxlength'=>12)); ?>
        </div>
    </div>
  	<div class="contenedor-fila">
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cobro[Fecha]',
								 //'language'=>'de',
								 'value'=>$model->Fecha,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
        </div>
    </div>
  		
	<div class="contenedor-fila">
	
	<div class="contenedor-columna-30">
		<?php echo $form->labelEx($model,'nro_cheque_certificado'); ?>
<?php echo $form->textField($model,'nro_cheque_certificado',array('size'=>20,'maxlength'=>110)); ?>
<?php echo $form->error($model,'nro_cheque_certificado'); ?>
	</div>
	<div class="contenedor-columna">
<label for="CuentaBanco">Cuenta Banco</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'cuentaBanco',
							'fields' => 'descripcion',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'showAddButton' => false,
							)
						); ?>
			</div>

		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'FechaCobro'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cobro[FechaCobro]',
								 //'language'=>'de',
								 'value'=>$model->FechaCobro,
								 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
        </div>
    </div>
  	<div class="contenedor-fila">

		<div class="contenedor-columna-90">
                <?php echo $form->label($model,'Detalles'); ?>
                <?php echo $form->textField($model,'Detalles',array('size'=>80,'maxlength'=>200)); ?>
        </div>
    </div>


        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
