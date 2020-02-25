<?php
if (isset ( $conFormulario ) && $conFormulario) {
	Yii::app ()->getClientScript ()->registerCoreScript ( 'jquery' );
	$form = $this->beginWidget ( 'CActiveForm', array (
			'id' => 'cheque-form',
			'enableAjaxValidation' => false,
			'htmlOptions' => array (
					'onsubmit' => "return false;",
					'onkeypress' => " if(event.keyCode == 13){ send(); } " 
			) 
	) );
}
?>
<?php
/*Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('gasto-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );*/
?>

<div class="titulo">Seleccionar Cheques</div>

<?php //echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php
echo CHtml::hiddenField('PagoCheque[id_pago]',$model->id_pago);
/*
$this->renderPartial ( '_search', array (
		'model' => $model 
) );*/
?>
</div>

<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'cheque-grid',
		'dataProvider' => $cheque->searchChequesLibres(),
		'filter' => $cheque,
		'columns' => array (
				array(
						'header'=>'',
						'value'=>'$data->id_cheque',
						'class'=>'CCheckBoxColumn',
						'selectableRows' => '10',
				),
'serie',
		'Numero',
				array (
						'name' => 'id_cuenta_banco',
						'value' => '$data->cuentaBanco->descripcion',
						'filter' => CHtml::listData ( CuentaBanco::model ()->findAll ( array (
								'order' => 'nombre' 
						) ), 'id_cuenta_banco', 'descripcion' ) 
				),
		'FechaEmision',
		'FechaPago',
		'Importe',				
						
		) 
) );
?>
	<div class="buttons row-center"></div>
	<div class="row-center">

		<!-- form -->

			
<?php
if (isset ( $conFormulario ) && $conFormulario) {
	echo CHtml::Button ( $model->isNewRecord ? 'Agregar Cheques' : 'Agregar Cheques', array (
			'onclick' => 'send();',
			'class' => 'btn btn-primary' 
	) );
	echo CHtml::button ( 'Cancel', array (
			'onclick' => "window.parent.$('#cru-dialog-cheque').dialog('close');window.parent.$('#cru-frame-cheque').attr('src','');",
			'class' => 'btn btn-primary' 
	) );
	?>     
    </div>
  
<?php
	
	$this->endWidget ();
}
?>
 </div>


<script type="text/javascript">
 
function send()
 {
 
   var data=$("#cheque-form").serialize();
  var dataInnerHtml;
 
  $.ajax({
	async: false,  
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction); ?>',
   data:data,
success:function(data){
				alert(data); 
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });
  $.ajax({
   	  dataType : "html",
   	  url: '<?php echo Yii::app()->createAbsoluteUrl($urlOperationAction).'?refresh=true&id_pago='.$id_pago; ?>',
   	  success: function(dataHtml) {
   	    // Do something after AJAX is completed.
   		  dataInnerHtml = dataHtml;
   	   window.parent.$('#<?php echo $grillaPosgrados ?>').html(dataInnerHtml);
   	   //window.parent.$('#cru-frame-cheque').attr('src','');
   	  // window.parent.$('#cru-dialog-cheque').dialog('close');
    	  refreshTotalesGenerales();
   	  }
   	});
}
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
		   	   window.parent.$('#cru-frame').attr('src','');
		   	   window.parent.$('#cru-dialog').dialog('close');
		   	  },
  error: function(data) { // if error occured
        alert("Ocurrió un error, reportelo.");
        alert(data);
   },

 dataType:'html'
 }); }
</script>