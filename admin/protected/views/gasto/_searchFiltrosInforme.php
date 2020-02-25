<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>
<div class="contenedor-tabla">

 <div class="contenedor-fila">


        <div class="contenedor-columna-30">
				<label>Año</label>
			<?php
			
echo CHtml::activeDropDownList ( $model, 'anio', LGHelper::functions ()->getYearsExistingFrom ($actual=2016), array (
					"class" => 'comboEstudios',
					//"empty" => 'Seleccione solo para buscar' 
			) );
			?>
		</div>
        <div class="contenedor-columna">
				<label>Mes</label>
			<?php
echo CHtml::activeDropDownList ( $model, 'mes', LGHelper::functions()->getMonths(),array('style'=>"width:300px",
					"class" => 'comboEstudios',
					"empty" => 'Todos los meses' 
			) );
			?>
		</div>
    </div>

<?php $this->endWidget(); ?>
</div>
</div>
<!-- search-form -->
