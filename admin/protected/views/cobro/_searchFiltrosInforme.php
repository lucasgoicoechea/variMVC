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
                                                                                { jQuery("#Cobro_id_obra").val(ui.item["id"]); }',
							'search' => 'js:function(event, ui)
                                                                                { jQuery("#Cobro_id_obra").val(0); }' 
					) 
			) );
			?>
			</div>
	</div>
  		
	<div class="contenedor-fila">

		<div class="contenedor-columna-30">
               <label>Fecha Cobro desde</label>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cobro[fechaDesde]',
								 'language'=>'es',
								 'value'=>$model->fechaDesde,
								 'htmlOptions'=>array('size'=>12, 'style'=>'width:100px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,
				
									 ),
								 )
							 );
					; ?>
        </div>

		<div class="contenedor-columna-30">
               <label>Fecha Cobro hasta</label>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Cobro[fechaHasta]',
								 'language'=>'es',
								 'value'=>$model->fechaHasta,
								 'htmlOptions'=>array('size'=>12, 'style'=>'width:100px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,
									 ),
								 )
							 );
					; ?>
        </div>
        
		<div class="contenedor-columna-30">
                <?php echo $form->label($model,'Importe'); ?>
                <?php echo $form->textField($model,'Importe',array('size'=>12,'maxlength'=>12)); ?>
        </div>
    </div>
        <div class="row-center">
                <?php echo CHtml::submitButton(Yii::t('app', 'Buscar')); ?>
        </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
