<div class="contenedor-tabla">
	<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('serie')); ?>:</b>
	<?php echo CHtml::encode($data->serie); ?>
	<br />
		</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Numero')); ?>:</b>
	<?php echo CHtml::encode($data->Numero); ?>
	<br />
		</div>
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_cuenta_banco')); ?>:</b>
	<?php echo $data->id_cuenta_banco!=''?$data->cuentaBanco->getDescripcion():''; ?>
	<br />
		</div>
	</div>
	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b>
   <?php echo CHtml::encode($data->getAttributeLabel('id_obra')); ?>:</b>
	<?php
	
	if ($data->id_obra != '') {
		$value = $data->obra->Nombre;
	} else {
		$value = '';
	}
	echo $value;
	?>	<br />
		</div>
	</div>

	<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php
	if ($data->id_proveedor != '' && $data->id_proveedor != null && $data->id_proveedor != 0) {
		$value = $data->proveedor->Nombre;
	} else {
		$value = '';
	}
	echo $value;
	?>
	<br />

		</div>
	</div>

	<div class="contenedor-fila">
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaEmision')); ?>:</b>
	<?php echo CHtml::encode($data->FechaEmision); ?>
	<br />
		</div>
		<div class='contenedor-columna-20'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('FechaPago')); ?>:</b>
	<?php echo CHtml::encode($data->FechaPago); ?>
	<br />
		</div>
			<div class='contenedor-columna-30'>
			<b><?php echo CHtml::encode($data->getAttributeLabel('Importe')); ?>:</b>
	<?php echo CHtml::encode($data->Importe); ?>
	<br />
		</div>
	</div>

</div>