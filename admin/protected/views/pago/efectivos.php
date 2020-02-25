<div class="view">
	<div class="form">
	<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List EfectivoPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('efectivo-pago-grid', {
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
<div class="titulo"> Administrar&nbsp;Pagos en Efectivo</div>

<?php $efectivo = new EfectivoPago();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'efectivo-pago-grid',
	'dataProvider'=>$efectivo->searchWithPago($id_pago),
	'filter'=>$efectivo,
	'columns'=>array(
		//'id_efectivo_pago',
		'monto',
		'detalle',
		array (
		'htmlOptions' => array (
				'width' => '20px'
		),
		'header' => ' ',
		'template' => '{view}{update}{borrarEfectivo}',
		'class' => 'CButtonColumn',
		'buttons' => array (
				'borrarEfectivo' => array(
										'click' => "function() {
						if(!confirm('Borrar el Pago en Efectivo?')) return false;
						$.fn.yiiGridView.update('efectivo-pago-grid', {
						type:'POST',
						url:$(this).attr('href'),
						success:function(text,status) {
							$.fn.yiiGridView.update('efectivo-pago-grid');
						 $.ajax({
						   	  dataType : 'html',
						   	  url: '".$url = Yii::app ()->createUrl ( 'pago/agregarEfectivoPago', array (
				'refresh' => true,
						   	  		'id_pago'=>$id_pago
		) )."',
						  	  success: function(dataHtml) {
						   	    // Do something after AJAX is completed.
						   		  dataInnerHtml = dataHtml;
						   	   window.parent.$('#id_efectivo_list').html(dataInnerHtml);
						   	   refreshTotalesGenerales();
						   	  }
						   	})
						}
						});
						return false;
						}",
						'label' => 'Borrar Efectivo',
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
$montoTotalEfectivo = Pago::model()->getTotalMontoEfectivo($id_pago);?>
<div id="id_efectivo_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS EN EFECTIVO</label></b> <b>$ <?php echo " ".LGHelper::functions()->formatNumber($montoTotalEfectivo); ?></b>
				</div>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
<?php
$this->renderPartial ( 'createEfectivo', array (	
	'model' => $efectivo,
	'id_pago'=>$id_pago,
'grillaPosgrados' => 'id_efectivo_list',
	'urlOperationAction'=>Pago::model()->getUrlAgregarEfectivo($id_pago)) );
?>
</div>
</div>