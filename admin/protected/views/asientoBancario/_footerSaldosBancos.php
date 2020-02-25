<div class="wide form">
	<div class="contenedor-tabla" >
		<div class="contenedor-fila" style="float: left">
			<div class="contenedor-columna-20">
				<label>SALDO REAL</label>-->  <b>$ <?php echo $model->saldoReal; ?></b>	
			</div>
            <div class="contenedor-columna-20">
            	<label>CHEQUES A FUTURO</label>-->  <b>$ <?php echo $model->chequesAFuturo; ?></b>
			</div>
            <div class="contenedor-columna-20">
            	<label>SALDO ACTUAL</label>-->  <b>$ <?php echo $model->saldoActual; ?></b>
			</div>
        </div>
		<div class="contenedor-fila" >    
			<div class="contenedor-columna-20" style="float: right">
				<label>RESTO A PAGAR</label>-->  <b>$ 	<?php echo $model->saldoRestoApagar; ?></b>
			</div>
		</div>
	</div>
</div>