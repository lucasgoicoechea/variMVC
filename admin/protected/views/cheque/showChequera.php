
<div class="titulo">Detalles de la nueva Chequera</div>

<div class="form">

	<div class="contenedor-tabla">

		<div class="contenedor-fila">
			<div class='contenedor-columna'>
				<b><label>Cuenta Banco</label></b>
	<?php echo CHtml::encode($model->cuentaBanco->descripcion); ?>
	<br />
		</div>
</div>
		<div class="contenedor-fila">
		<div class='contenedor-columna-30'>
				<b><label>Serie</label> </b>
	<?php echo CHtml::encode($model->serie); ?>
	<br />

			</div>
			<div class='contenedor-columna-30'>
				<b><label>Número desde</label> </b>
	<?php echo CHtml::encode($model->Numero); ?>
	<br />

			</div>
					<div class='contenedor-columna-30'>
				<b><label>Número hasta</label> </b>
	<?php echo CHtml::encode($model->chequeNroHasta); ?>
	<br />

			</div>
		</div>

	</div>

</div>
