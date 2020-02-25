<div class="contenedor-fila" style="border:  1px">
	<div class="contenedor-columna-10">
		<span style="font-size: 9 px">	<?php echo CHtml::encode($data->id_transferencia); ?>
</span>
	</div>
	<div class="contenedor-columna-20">
		<span style="font-size: 9 px"><?php echo CHtml::encode($data->cuenta->getDescripcion()); ?>
	</span>
	</div>

	<div class="contenedor-columna-30">
		<span style="font-size: 9 px">
			<?php echo CHtml::encode($data->descripcion); ?></span>
	</div>

	<div class="contenedor-columna-20">
		<span style="font-size: 9 px">
			<?php echo CHtml::encode($data->importe); ?></span>
	</div>
	<div class="contenedor-columna-10">
		<span style="font-size: 9 px">
			<?php echo CHtml::encode ( LGHelper::functions ()->displayFecha ( $data->fecha ) );
			?></span>
	</div>
</div>
