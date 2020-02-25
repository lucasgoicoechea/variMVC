<?php
$this->menu = array (
array (
				'label' => Yii::t ( 'app', 'List OrdenPago' ),
				'url' => array (
						'index' 
						)
						),
						array (
				'label' => Yii::t ( 'app', 'Crear nuevo ' ),
				'url' => array (
						'create' 
						)
						)
						);

						Yii::app ()->clientScript->registerScript ( 'search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('orden-pago-grid', {
data: $(this).serialize()
});
				return false;
				});
			" );
						?>

<div class="titulo">Administrar&nbsp;Orden Pagos</div>

						<?php echo CHtml::link(Yii::t('app', 'Busqueda avanzada'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display: none">
<?php

$this->renderPartial ( '_search', array (
		'model' => $model 
) );
?>
</div>
<div id="profileDIV"></div>
<div id="statusMsg"></div>
<?php

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'orden-pago-grid',
		'dataProvider' => $model->search (),
		'filter' => $model,
		'columns' => array (

/*array (
 'htmlOptions' => array (
 'width' => '10px'
 ),
 'template' => '{toggleButton}',
 'class' => 'CButtonColumn',
 'buttons' => array (
 'toggleButton'=>array(
 'label' => 'Ver comprobantes',
 'imageUrl' => Yii::app ()->theme->baseUrl . "/img/add.png",
 'options'=>array('id'=>'miBoton',
 'class'=>'.treeview .hitarea'),
 'click'=>'$("#miBoton").click(function(){$("#miBoton").closest("tr").toggle()})',
 ),),
 ),*/
array(
            'type'=>'raw',
            'value'=>'CHtml::ajaxLink(CHtml::image(Yii::app ()->theme->baseUrl . "/img/gridview/up.gif"),"verComprobante",array(
                            "data"=>array(
                                    "id_orden_pago"=>$data->id_orden_pago,
                                    "refresh" => true,
                                    "direction"=>"up"
                            ),
                 "success"=>"js:function( data )    {
    jQuery(\"#comprobantes".$data->id_orden_pago."\").remove();
                  }",
    
                        ))."".
                    CHtml::ajaxLink(CHtml::image(Yii::app ()->theme->baseUrl . "/img/gridview/down.gif"),"verComprobante",array(
                            "data"=>array(
                                    "id_orden_pago"=>$data->id_orden_pago,
                                    "refresh" => true,
                                    "direction"=>"down"
                            ),
                           "success"=>"js:function( data )    {
                     
    jQuery(\"#send-link".$data->id_orden_pago."\").closest(\"tr\").after(\"<tr><td colspan=\'8 \' id=\'comprobantes".$data->id_orden_pago."\'></td></tr>\");
    jQuery(\"#comprobantes".$data->id_orden_pago."\").html(data);
    
                  }",
                     "beforeSend"=>"function( request )    {
                           
                     }"
                        ),    array("id" => "send-link$data->id_orden_pago"))',),
								array (
						'name' => 'numero_op',
						'value' => '$data->numero_op',
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'fecha',
						'value' => '$data->fecha!=null?$data->fecha:""',
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;"
								)
								),
								array (
						'name' => 'id_cuenta',
						'value' => '$data->cuenta!=null?$data->cuenta->descripcion:""',
						'filter' => CHtml::listData ( Cuenta::model ()->findAll ( array (
								'order' => 'Codigo' 
								) ), 'id_cuenta', 'descripcion' ),
						'htmlOptions' => array (
								'width' => '100px',
								'style' => "text-align:center;" 
								)
								),
								array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
								),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
								),
						'name' => 'pagada',
						'type' => 'raw',
						'value' => '$data->isPagada()?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
						),array (
						'filter' => array (
								'0' => Yii::t ( 'app', 'No' ),
								'1' => Yii::t ( 'app', 'Si' ) 
								),
						'htmlOptions' => array (
								'width' => '20px',
								'style' => "text-align:center;" 
								),
						'name' => 'en_pago',
						'type' => 'raw',
						'value' => '$data->en_pago?CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b2.gif"):CHtml::image(Yii::app ()->theme->baseUrl . "/img/icons/b4.gif")' 
						),
						array (
						'htmlOptions' => array (
								'width' => '30px',
								'style' => "text-align:center;" 
								),
					'header'=>'Monto',
								//'type' => 'raw',
								//'value' => 'OrdenPago::model()->getMonto($data->id_orden_pago)'
						'value' => '$data->getMonto()'
						),
				'observacion',
				
						

						array (
						'htmlOptions' => array (
								'width' => '20px' 
								),
						'header' => ' ',
						'template' => '{view}{update}{imprimirOrden}{delete}{verPago}',
						'class' => 'CButtonColumn',
						 'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
						'buttons' => array (
								'imprimirOrden' => array (
										'label' => 'Imprimir Orden Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_print.png",
										'url' => '$data->getUrlImprimir()',
										'visible' => 'true',
										'options' => array (
												'target' => '_blank' 
)
)
,
'verPago' => array (
										'label' => 'Ver Pago',
										'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
										'url' => '$data->getUrlPago()',
										'visible' => '$data->en_pago',
										'options' => array (
												'target' => '_blank' 
												)
												)
					
)
)
)
) );
?>
