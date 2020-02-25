<div class="titulo">Detalle de Cuenta</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'Codigo',
		'Nombre',
			'cerrada'
	),
)); ?>

<div class="row-center">
	<?php
	echo CHtml::link ( 'Volver', $this->createUrl ( 'cuenta/admin' ), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary' 
	) );
	
	?>
</div>