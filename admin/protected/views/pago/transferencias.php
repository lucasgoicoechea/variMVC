<div class="view">
	<div class="form">
<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List TransferenciaPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('transferencia-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>
<script type="text/javascript">

function refreshTotalesGenerales()
{

 // var data=$("#gastos-form").serialize();
 var dataInnerHtml;

 $.ajax({
	async: false,  
  type: 'POST',
  //  data:data,
	  url: '<?php echo Yii::app()->createAbsoluteUrl('pago/actualizarTotalesGrales').'?refresh=true&id_pago='.$id_pago; ?>',
success: function(dataHtml) {
		   	    // Do something after AJAX is completed.
		   		  dataInnerHtml = dataHtml;
		   	   window.parent.$('#totalesGrales').html(dataInnerHtml);
		   	   window.parent.$('#cru-frame-cheque').attr('src','');
		   	   window.parent.$('#cru-dialog-cheque').dialog('close');
		   	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 });

}
</script>
<div class="titulo">Transferencias usadas para el Pago</div>

<?php $transferencia = new TransferenciaPago();
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferencia-pago-grid',
	'dataProvider'=>$transferencia->searchWithPago($id_pago),
	'filter'=>$transferencia,
	'columns'=>array(
				array (
						'name' => 'id_cuenta_banco',
						'value' => '$data->cuentaBanco->descripcion',
						'filter' => CHtml::listData ( CuentaBanco::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cuenta_banco', 'descripcion' ) 
				),
		'referencia',
		
		'cbu_destino','monto',
		array (
		'htmlOptions' => array (
				'width' => '20px'
		),
		'header' => ' ',
		'template' => '{view}{update}{borrarTransferencia}',
		'class' => 'CButtonColumn',
		'buttons' => array (
				'borrarTransferencia' => array(
										'click' => "function() {
						if(!confirm('Borrar la Transferencia?')) return false;
						$.fn.yiiGridView.update('transferencia-pago-grid', {
						type:'POST',
						url:$(this).attr('href'),
						success:function(text,status) {
							$.fn.yiiGridView.update('transferencia-pago-grid');
						 $.ajax({
						   	  dataType : 'html',
						   	  url: '".$url = Yii::app ()->createUrl ( 'pago/agregarTransferenciaPago', array (
				'refresh' => true,
						   	  		'id_pago'=>$id_pago
		) )."',
						  	  success: function(dataHtml) {
						   	    // Do something after AJAX is completed.
						   		  dataInnerHtml = dataHtml;
						   	   window.parent.$('#id_transferencia_list').html(dataInnerHtml);
						   	   refreshTotalesGenerales();
						   	  }
						   	})
						}
						});
						return false;
						}",
						'label' => 'Borrar Transferencia',
						'imageUrl' => Yii::app ()->theme->baseUrl . "/gridview/delete.png",
						'url' => '$data->getUrlDelete()',
						'visible' => 'true',
						'options' => array (
								'target' => '_blank'
						)
				)
		)
	)
))); 
$montoTotalTransferencias = Pago::model()->getTotalMontoTransfenrencia($id_pago);?>
<div id="id_transferencia_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS CON TRANSFERENCIAS</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalTransferencias); ?></b>
				</div>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
<?php
$this->renderPartial ( 'createTransferencia', array (	
	'model' => $transferencia,
	'id_pago'=>$id_pago,
'grillaPosgrados' => 'id_transferencia_list',
	'urlOperationAction'=>Pago::model()->getUrlAgregarTransferencia($id_pago)) );
?>
</div>
</div>