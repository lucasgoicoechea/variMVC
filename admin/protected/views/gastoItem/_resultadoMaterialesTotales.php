<div class="wide form">

	<div class="contenedor-tabla" style="text-align: center">

<?php
$visible_log=UsersLogin::isMiguelAlba ( Yii::app ()->user->id ); 
$materiales = Material::model()->findAll();
?>
<div class="subtitulo">
<?php
if ($model->obra!=null)
	echo "OBRA: ".$model->obra->getDescripcion();
else 	echo "TODAS LAS OBRAS";
?>
</div>
<?php
foreach($materiales as $material){
	$valor_unidad_promedio = 0.00;
	$cantidadtotal = 0.00;
	$consumidototal =0.00;
	$valor_final_total = 0.00;
	$gastoitems = $model->searchWithObraByMaterial($material->id_material);
	foreach ($gastoitems as $gastoitem)
	{
		$valor_unidad_promedio += LGHelper::functions ()->unformatNumber($gastoitem->valor_unidad);
		$cantidadtotal += LGHelper::functions ()->unformatNumber($gastoitem->cantidad);
		$consumidototal += LGHelper::functions ()->unformatNumber($gastoitem->consumido);
		$valor_final_total += LGHelper::functions ()->unformatNumber($gastoitem->valor_final);
	}
	if ($cantidadtotal > 0.00){
         ?>
		 <div class="contenedor-fila">
			<div class="contenedor-columna-50">
				<label>Material</label>-->  <b> <?php echo $material->getDescripcionShort(); ?></b>
	||
			</div>
			<div class="contenedor-columna-20">
			
			<label>CANTIDADES</label>-->  <b> <?php echo $cantidadtotal; ?></b>
				<label>VALOR UNIDAD PROM.</label>-->  <b> <?php echo $valor_unidad_promedio/sizeof($gastoitems); ?></b>
			||	<label>VALOR FINAL</label>-->  <b> <?php echo $valor_final_total; ?></b>
			</div>
			<div class="contenedor-columna-20">
				<label>CONSUMIDO</label>-->  <b>$ 	<?php echo $consumidototal; ?></b>
||
				<label>RESTA CONSUMIR</label>-->  <b>$  <?php echo $cantidadtotal-$consumidototal; ?></b>
			</div>

		</div>
		 <?php 
	}
}
?>
</div>
</div>