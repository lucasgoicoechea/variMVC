<div class="titulo">Detalle de Contrato #<?php echo $model->id_contrato; ?></div>

<?php

$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'id_contrato',
				'proveedor.Nombre',
				'Fecha',
				'Detalle',
				'Precio',
				'Plazo',
				'Acuerdo',
				'obra.Codigo',
				// 'empresa.nombre',
				array (
						'name' => 'Autorizo',
						'value' => $model->usuarioAutorizo->username 
				),
				array (
						'name' => 'Solicito',
						'value' => $model->usuarioSolicito->username
				),
		) 
) );
?>

<div class="view">
<?php 	echo $this->renderPartial ( '_viewPagos', array (
		'model' => $model
) ); ?>
<div class="row-center">
			
	<span>
	<?php
	echo CHtml::link ( CHtml::image ( Yii::app ()->theme->baseUrl . "/img/icons/b_print.png" ), $model->getUrlImprimir (), array (
			'style' => 'color: white',
			'class' => 'btn btn-primary',
			'target' => '_blank' 
	) );
    ?>
    </span> <span>
    <?php
				echo CHtml::link ( 'Volver', $this->createUrl ( 'contrato/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span><span>
    <?php
				echo CHtml::link ( 'Editar Subcontrato', $this->createUrl ( 'contrato/update', array (
						'id' => $model->id_contrato 
				) ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>
		</div>
	</div>
