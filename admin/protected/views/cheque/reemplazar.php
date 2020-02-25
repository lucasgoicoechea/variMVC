<div class="titulo">Reemplazo de Cheque</div>

<div class="form">

<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'cheque-form',
		'enableAjaxValidation' => true 
) );
echo $this->renderPartial ( '_view', array (
		'data' => $model 
) );
?>
	<div class="row-center">
		<div class="subtitulo btn"> <?php
		$imageUrl2 = Yii::app ()->theme->baseUrl . '/img/icons/window_new.png';
		echo CHtml::link ( '<img src="' . $imageUrl2 . '"
				alt="Quitar Cheque" />Buscar Reemplazo', array (
				'cheque/reemplazarChequePopUp',
				"id_cheque" => $model->id_cheque 
		), 		// ajax options
		array (
				// 'onclick' => '$("#cru-dialog").dialog("open"); $("#cru-frame").attr("src",$(this).attr("href")); $("#grid-user-observaciones").yiiGridView.update("grid-user-observaciones"); return false;',
				'onclick' => '$("#cru-dialog-cheque").dialog("open"); $("#cru-frame-cheque").attr("src",$(this).attr("href")); return false;',
				'update' => '#list_cheque',
				'title' => 'Reemplazar Cheque' 
		), 
				// htmloptions
				array (
						'target' => '_blank',
						'class' => 'linkClass',
						'id' => 'reemplazarCheque' 
				) );
		
		?>
		 </div>
	</div>
</div>
<div class="row-center">
	<?php //echo CHtml::submitButton(Yii::t('app', 'Guardar'),array('class'=>'btn btn-primary')); ?>
</div>

<?php

$this->endWidget ();
?> 
<div id="list_cheques">
<?php 
echo $this->renderPartial ( 'chequesReemplazantes', array (
		'model' => $model 
) );
?>
</div>
<?php 
// --------------------- begin new code --------------------------
// add the (closed) dialog for the iframe
$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
		'id' => 'cru-dialog-cheque',
		'options' => array (
				'title' => 'Actualizar datos',
				'autoOpen' => false,
				'modal' => true,
				'width' => 900,
				'height' => 400 
		) 
) );
?>
<iframe id="cru-frame-cheque" width="100%" height="100%"> </iframe>
<?php

$this->endWidget ();
// --------------------- end new code --------------------------
?>
</div>
<!-- form -->
