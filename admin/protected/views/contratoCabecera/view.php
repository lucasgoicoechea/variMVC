<div class="titulo">Detalle de SubContrato #<?php echo $model->codigo; ?></div>

<?php
echo CHtml::link ( "Editar Proveedor", Yii::app ()->createUrl ( 'proveedor/view', array (
				'id' => $model->id_proveedor
		) ), array (
		'style' => 'color: white',
		'class' => 'btn btn-primary',
		'target' => '_blank'
) );
echo CHtml::link ( "Editar Obra", Yii::app ()->createUrl ( 'obra/view', array (
		'id' => $model->id_obra
) ), array (
		'style' => 'color: white',
		'class' => 'btn btn-primary',
		'target' => '_blank'
) );
$this->widget ( 'zii.widgets.CDetailView', array (
		'data' => $model,
		'attributes' => array (
				'codigo',
				array (
						'name' => 'Proveedor',
						'value' => $model->proveedor->getDescripcion() 
				),
				'Fecha',
				'Descripcion',
				'Precio',
				'Plazo',
				'Acuerdo',
				array (
						'name' => 'Obra',
						'value' => $model->obra->getDescripcion() 
				),
				// 'empresa.nombre',
				array (
						'name' => 'Autorizo',
						'value' => $model->getUsuarioAutorizo() 
				),
				array (
						'name' => 'Solicito',
						'value' => $model->getUsuarioSolicito()
				),
		) 
) );
?>

<div class="view">
<?php 	echo $this->renderPartial ( '_viewPagos', array (
		'model' => $model
) ); ?>

<?php
$this->beginWidget ( 'LGVerticalTab', array (
		'tagIdContent' => 6,
		'tagTitle' => 'Agregar Item Subcontrato',
		'expandedTab' => false 
) );
?>
<div class="contenedor-tabla" >
<?php 
$contratoTmp = new Contrato();
$contratoTmp->id_contrato_cabecera = $model->id_contrato_cabecera;
$this->renderPartial ( 'createItemSubcontrato', array (	
	'model' => $contratoTmp,
	'id_contrato_cabecera'=>$model->id_contrato_cabecera,
    'grillaPosgrados' => 'id_subcontrato_list',
	'urlOperationAction'=>Contrato::model()->getUrlAgregarContrato($model->id_contrato_cabecera)) );
?>
</div>
<?php $this->endWidget(); ?>
<div class="contenedor-tabla" id="items_sub">
<?php 	echo $this->renderPartial ( '_viewContrato', array (
		'model' => $model
) ); ?>
</div>

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
				echo CHtml::link ( 'Volver', $this->createUrl ( 'contratoCabecera/admin' ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span><span>
    <?php
				echo CHtml::link ( 'Editar Subcontrato', $this->createUrl ( 'contratoCabecera/update', array (
						'id' => $model->id_contrato_cabecera
				) ), array (
						'style' => 'color: white',
						'class' => 'btn btn-primary' 
				) );
				?>
	</span>
		</div>
	</div>
