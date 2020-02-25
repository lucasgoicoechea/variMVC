<div class="titulo">Movimientos Diarios entre Fechas</div>
<div id="time">
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( $this->route ),
		'method' => 'post' 
) );
?>
<div class="search-form" style="display: block">
<?php

$this->renderPartial ( '_searchFiltros', array (
		'model' => $model ,
        'form' => $form
) );
?>
</div>
<?php 
                 
echo $this->renderPartial ( '_movsDiariosFechas', array (
		'model' => $model,
) );
?>
<?php $this->endWidget(); ?>
</div>