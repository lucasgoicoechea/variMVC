<div class="titulo"> Buscar Tipo de Gasto</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-gasto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codigo',
			'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
