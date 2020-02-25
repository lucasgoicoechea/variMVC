<div class="view">
	<div class="form">
<?php     $this->menu=array(
		array('label'=>Yii::t('app',
				'List TarjetaPago'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Crear nuevo '),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('tarjeta-pago-grid', {
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
		   	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 });

}
</script>
<div class="titulo"> Pagos con Tarjeta</div>

<?php $tarjeta = new TarjetaPago();
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tarjeta-pago-grid',
	'dataProvider'=>$tarjeta->searchWithPago($id_pago),
	'filter'=>$tarjeta,
	'columns'=>array(
				array (
						'name' => 'id_tarjeta',
						'value' => '$data->tarjeta->descripcion',
						'filter' => CHtml::listData ( Tarjeta::model ()->findAll ( array (
								'order' => 'numero' 
						) ), 'id_tarjeta', 'descripcion' ) 
				),
		'monto',
		'fecha_pago',
		'detalle',
		array (
		'htmlOptions' => array (
				'width' => '20px'
		),
		'header' => ' ',
		'template' => '{view}{update}{borrarTarjeta}',
		'class' => 'CButtonColumn',
		'buttons' => array (
				'borrarTarjeta' => array(
										'click' => "function() {
						if(!confirm('Borrar el Pago con Tarjeta?')) return false;
						$.fn.yiiGridView.update('tarjeta-pago-grid', {
						type:'POST',
						url:$(this).attr('href'),
						success:function(text,status) {
							$.fn.yiiGridView.update('tarjeta-pago-grid');
						 $.ajax({
						   	  dataType : 'html',
						   	  url: '".$url = Yii::app ()->createUrl ( 'pago/agregarTarjetaPago', array (
				'refresh' => true,
						   	  		'id_pago'=>$id_pago
		) )."',
						  	  success: function(dataHtml) {
						   	    // Do something after AJAX is completed.
						   		  dataInnerHtml = dataHtml;
						   	   window.parent.$('#id_tarjeta_list').html(dataInnerHtml);
						   	   refreshTotalesGenerales();
						   	  }
						   	})
						}
						});
						return false;
						}",
						'label' => 'Borrar Tarjeta',
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
$montoTotalTarjeta = Pago::model()->getTotalMontoTarjeta($id_pago);?>
<div id="id_tarjeta_list">
			<div class="contenedor-fila">
				<div
					style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
					class="contenedor-columna-90">
					<b><label>MONTO TOTAL - PAGOS CON TARJETA</label></b> <b>$ <?php echo " ".CHtml::encode($montoTotalTarjeta); ?></b>
				</div>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
<?php
$this->renderPartial ( 'createTarjeta', array (	
	'model' => $tarjeta,
	'id_pago'=>$id_pago,
'grillaPosgrados' => 'id_tarjeta_list',
	'urlOperationAction'=>Pago::model()->getUrlAgregarTarjeta($id_pago)) );
?>
</div>
</div>