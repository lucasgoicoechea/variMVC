<?php
$this->menu = array (
		array (
				'label' => Yii::t ( 'app', 'List Proveedor' ),
				'url' => array (
						'index' 
				) 
		),
		array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
				'url' => array (
						'create' 
				) 
		) 
);

Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('proveedor-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
?>
<script type="text/javascript">
function sendDelete(){
      $('#boton-borrado').attr("disabled",true).value("Borrando...");
	 $.ajax({
			async: false,  
		  type: 'GET',
		  //  data:data,
			  url: '<?php echo CController::createUrl('proveedor/borrarMultiples'); ?>?'+$('[name="proveedor-grid_c0[]"]' ).serialize(),
		success: function(dataHtml) {
				   	    // Do something after AJAX is completed.
			 /*$.fn.yiiGridView.update('proveedor-grid',{ 
			       success: function() {
			           $('#proveedor-grid').removeClass('grid-view-loading');
			       },
			       data: $('.search-form form').serialize() + '&export=true'
			   });*/
			location.reload();
				   	  },
		  error: function(data) { // if error occured
		        alert("Ocurrió un error, reportelo.");
		        alert(data);
		   },
		 dataType:'html'
		 });
	 
}
</script>
<div class="titulo">Administrar&nbsp;Proveedores</div>

<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'proveedor-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (
				array(
						'header'=>'',
						'value'=>'$data->id_proveedor',
						'class'=>'CCheckBoxColumn',
						'selectableRows' => '20',
				),
				array (
						'name' => 'id_proveedor',
						'htmlOptions' => array (
								'width' => '5' 
						),
						'headerHtmlOptions' => array (
								'style' => 'width: 5' 
						) 
				),
				'Nombre',
				'Cuit',
				'E_Mail',
				'Telefono',
				'telefono_dos',
				'telefono_tres',
				'telefono_cuatro',
				array (
						'name' => 'id_tipo_gasto',
						'header' => 'Tipo Gasto',
						'value' => '$data->tipoGasto!=null?$data->tipoGasto->nombre:""',
						'htmlOptions' => array (
								'width' => '10' 
						) 
				),
				// 'Celular',
				// 'Fax',
				// 'Direccion',
				/*
				 * 'Contacto', 'Cuit', 'E_Mail', 'SubTipo', 'id_tipo_gasto', 'id_categoria_iva', 'id_moneda',
				 */
				array (
						'class' => 'CButtonColumn' 
				) 
		) 
) );
echo CHtml::Button ( 'Borrar seleccionados', array (
		'onclick' => 'sendDelete();',
		'class' => 'btn btn-primary',
		'id'  => 'boton-borrado'
) );
?>
