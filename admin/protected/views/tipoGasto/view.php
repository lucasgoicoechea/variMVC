<div  class="titulo">Detalle datos del Tipo de Gasto</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'nombre',
	),
)); ?>


