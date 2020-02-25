<?php
$model = new Cobro ();
// $model->pagada = $pagados?1:0;
$model->FechaCobro = $caja->fecha;
$model->Indice = null;
$model->Importe = null;
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'cobro-grid',
		'dataProvider' => $model->search (),
		'enableSorting' => false,
		//'filter' => $model,
		'columns' => array (
				// 'id_cobro',
				array (
						'name' => 'Indice',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				array (
						'name' => 'Fecha',
						'filter' => $this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
								'model' => $model,
								'attribute' => 'Fecha',
								'language' => 'es',
								// 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
								'htmlOptions' => array (
										'id' => 'datepicker_for_Fecha',
										'size' => '10' 
								),
								'defaultOptions' => array ( // (#3)
										'showOn' => 'focus',
										'showOtherMonths' => true,
										'selectOtherMonths' => true,
										'changeMonth' => true,
										'changeYear' => true,
										'showButtonPanel' => true 
								)
								 
						), true )  // (#4)
								),
				'NumFactura',
				'Importe',
				array (
						'name' => 'id_cliente',
						'value' => '$data->cliente->nombre',
						'filter' => CHtml::listData ( Cliente::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cliente', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra->Nombre',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				array (
						'name' => 'id_imputacion',
						'value' => '$data->imputacion->Nombre',
						'filter' => CHtml::listData ( Imputacion::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_imputacion', 'Nombre' ) 
				),
				array (
						'name' => 'id_forma',
						'value' => '$data->formaPago->Nombre',
						'filter' => CHtml::listData ( FormaPago::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_forma', 'Nombre' ) 
				),
				array (
						'header' => 'Fecha Cobro',
						'value' => 'LGHelper::functions()->displayFecha ( $data->FechaCobro )' 
				),
		) 
) );
?>