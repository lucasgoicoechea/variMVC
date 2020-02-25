<div class="titulo">Cheques Reemplazantes </div>
<?php 
$dataProvider = $model->getReemplazantes();
 $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
