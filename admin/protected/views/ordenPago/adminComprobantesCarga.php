<?php
//if (isset ( $conFormulario ) && $conFormulario) {
	Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );
	$form = $this->beginWidget ( 'CActiveForm', array (
			'id' => 'gastos-form',
			'enableAjaxValidation' => false,
			'htmlOptions' => array (
					'onsubmit' => "return false;",
					'onkeypress' => " if(event.keyCode == 13){ send(); } " 
			) 
	) );
//}
?>
<div class="view">
	<div class="form">
		<?php
		if (Yii::app ()->user->hasFlash ( 'mensaje' )) {
			?>
		<h3 style="color: green;">
			<?php echo Yii::app()->user->getFlash('mensaje')?>
		</h3>
		<?php
		}
		?>

		<h4 class="titulo">Comprobantes a Pagar
<?php
$gasto = new Gasto();
$gasto->id_proveedor =  $model->id_proveedor;
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'gasto-grid',
		'dataProvider' => $gasto->searchGastosFacturasAPagar(),
		'filter' => $gasto,
		'columns' => array (
				array(
						'header'=>'',
						'value'=>'$data->id_gasto',
						'class'=>'CCheckBoxColumn',
						'selectableRows' => '10',
				),
				array (
						'name' => 'Codigo',
						'htmlOptions' => array (
								'width' => '20px' 
						) 
				),
				'FechaAsiento',
				array (
						'name' => 'id_tipo_comprobante',
						'value' => '$data->tipoComprobante->Nombre',
						'filter' => CHtml::listData ( TipoComprobante::model ()->findAll ( array (
								"condition"=>'visible=1',
								'order' => 'Nombre'
						) ), 'id_tipo_comprobante', 'Nombre' )
				),
				'NumComprobante',
				'FechaFactura',
				'Monto',
				array (
						'header' => 'Proveedor(Telefono)',
						'name' => 'id_proveedor',
						'value' => '$data->getProveedorDescripcion()',
						'filter' => CHtml::listData ( Proveedor::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_proveedor', 'descripcion' ) 
				),
				array (
						'name' => 'id_obra',
						'value' => '$data->obra!=null?$data->obra->Nombre:""',
						'filter' => CHtml::listData ( Obra::model ()->findAll ( array (
								'order' => 'Nombre' 
						) ), 'id_obra', 'descripcion' ) 
				),
				'Detalle',
				/*
				array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' )
						),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
						),
						'name' => 'pagada',
						'type' => 'raw',
						'value' => '$data->isPagada()?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
				),*/
		/*array (
						'htmlOptions' => array (
								'width' => '20px' 
						),
						'header' => ' ',
						'template' => '{view}{update}{imprimirOferta}',
						'class' => 'CButtonColumn',
						'buttons' => array (
								'imprimirOferta' => array (
										'label' => 'Imprimir Factura/Comprobante',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
										'url' => '$data->getUrlImprimir()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
										) 
								) 
						) 
				)*/ 
		) 
) );
?>
	<div class="buttons row-center"></div>
	<div class="row-center">

		<!-- form -->

			
<?php
	echo CHtml::Button ( $model->isNewRecord ? 'Agregar Comprobantes' : 'Agregar Comprobantes', array (
			'onclick' => 'send();',
			'class' => 'btn btn-primary' 
	) );
	
	?>     
    </div>
  
<?php
	
	$this->endWidget ();

?>
 </div>


<script type="text/javascript">
 
 function borrar(idgastoop){
    var dataInnerHtml;
    
    $.ajax({
	async: false,  
   type: 'GET',
   url: '<?php echo Yii::app()->homeUrl; ?>ordenPago/deleteComprobantePlano/'+idgastoop+'.html',
   success:function(data){
				dataInnerHtml = data;
				window.parent.$('#admin_comprobantes_carga').html(dataInnerHtml);
				refreshTotalesGenerales();
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
  dataType:'html'
  });
 }

function send()
 {
 
   var data=$("#gastos-form").serialize();
  var dataInnerHtml;
 
  $.ajax({
	async: false,  
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl('ordenPago/agregarComprobantePlano/' . $model->id_orden_pago); ?>',
   data:data,
success:function(data){
				dataInnerHtml = data;
				window.parent.$('#admin_comprobantes_carga').html(dataInnerHtml);
				refreshTotalesGenerales();
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
  dataType:'html'
  });

}


</script>
</h4>
		<div class="" id="list_entrevistas">
	<?php
	$resultadosEntrev = OrdenPagoGasto::model ()->searchWithOrdenPago ( $model->id_orden_pago );
	if ($resultadosEntrev != null) {
		$this->widget ( 'zii.widgets.CListView', array (
				'dataProvider' => $resultadosEntrev,
				// 'ajaxUpdate' => 'cv-id',
				'summaryText' => '<div class="header"> Cantidad de Comprobantes de la Orden: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
				// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
				'itemView' => '_viewGastoPlano',
				// 'viewData' => array( 'data' => null ),
				'ajaxUpdate' => false,
				// 'enablePagination'=>true
				'pager' => array (
						'header' => 'Ir a', // text before it
						'maxButtonCount' => 28 
				) 
		) );
		
	} else {
		echo "NO POSEE COMPROBANTES SELECCIONADOS";
	}
	?>
</div>
<div id="totalesGrales"> 
	<?php
	  echo $this->actualizarTotalesGrales ( $model->id_orden_pago );
	?>
</div>