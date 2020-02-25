<div style="width:1600px;text-align: center;height: 600px;">
<div style=" float:left; width:44%; height:600px; overflow-x: scroll; border-right:4px solid;">
<div class="titulo">Movimientos Conciliados</div>
<?php

$asientos->saldo = null;
$dataproviderAsentados = $asientos->search ();
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'asientos-bco-grid',
		'dataProvider' => $dataproviderAsentados ,
		'filter' => $asientos,
		'columns' => array ( 
            array (
                'name' => 'id_tipo_asiento',
                'value' => '$data->tipoAsiento!=null?$data->tipoAsiento->nombre:""',
                'filter' => CHtml::listData ( TipoAsiento::model ()->findAll(), 'id_tipo_asiento', 'nombre' )
            ),
                array (
                        'name' => 'tipo_asiento',
                        'htmlOptions' => array (
                                        'width' => '80px' 
								)
                        ),	
                array (
                        'name' => 'id_cuenta',
                        'value' => '$data->cuenta!=0?$data->cuenta->Nombre:""',
                        ) ,
                        array (
                                'name' => 'fecha_log',
                                'value' => '$data->getFecha()'
                                        ) ,
                array (
                'name' => 'monto',
                'value' => '$data->getMonto()',
                ) ,
                array (
                        'name' => 'saldo',
                        'value' => '$data->saldo',
                        ) ,
                array (
                        'htmlOptions' => array (
                                'width' => '20px' 
                                ),
                        'header' => ' ',
                        'template' => '{verComprobante}{borrarAsiento}',
                        'class' => 'CButtonColumn',
                        'buttons' => array (
                                'verComprobante' => array (
                                        'label' => 'Ver Comprobante Origen',
                                        'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
                                        'url' => '$data->getUrlVerOrigen()',
                                        'visible' => 'true',
                                        'options' => array (
                                                'target' => '_blank' 
                                        )),
                                        'borrarAsiento' => array (
                                        'label' => 'Borrar Asiento',
                                        'imageUrl' => Yii::app ()->theme->baseUrl . "/img/gridview/delete.png",
                                        'url' => '$data->getUrlBorrarAsiento()',
                                        'visible' => 'true',
                                        'options' => array (
                                                // 'target' => '_blank' 
                                        ))            
                    ))
                )
												) );
												?>
</div>
<div style=" float:left; width:45%; height:600px; overflow-x: scroll;">
<div class="titulo">Movimientos para Conciliación Bancaria</div>
<?php

$dataproviderNoAsentados = $asienMov->search ();
$this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'asientos-grid',
		'dataProvider' => $dataproviderNoAsentados,
		'filter' => $asienMov,
		'columns' => array (
            array (
                'name' => 'id_tipo_asiento',
                'value' => '$data->tipoAsiento!=null?$data->tipoAsiento->nombre:""',
                'filter' => CHtml::listData ( Obra::model ()->findAll ( array ( 'order' => 'nombre'  ) ),
                         'id_tipo_asiento', 'nombre' )
                         ,
                        'htmlOptions' => array (
                                        'width' => '60px' 
                                )
                        ),
                                        array (
						'name' => 'tipo_asiento',
						'htmlOptions' => array (
								'width' => '30px' 
								)
                        ),
                        array (
                                'name'=>'n_tipo_asiento',
				'htmlOptions' => array (
						'width' => '20px' 
					)
                        )
                       , array (
                        'name' => 'id_cuenta',
                        'value' => '$data->cuenta!=0?$data->cuenta->Nombre:""',
                        'htmlOptions' => array (
                                        'width' => '60px' 
                                )
                        ) 
                       ,  array (
                        'name' => 'fecha_log',
                        'value' => '$data->getFecha()',
                        'htmlOptions' => array (
                                        'width' => '30px' 
                                )
                        ) 
                     ,	array (
                    'name' => 'monto',
                    'value' => '$data->tipoAsiento!=null?($data->monto*$data->tipoAsiento->multiplicador):$data->monto',
                    'htmlOptions' => array (
                                    'width' => '60px' 
                            )
                    ) ,
                     array (
                        'htmlOptions' => array (
                                'width' => '20px' 
                                ),
                        'header' => ' ',
                        'template' => '{verComprobante}{crearAsiento}',
                        'class' => 'CButtonColumn',
                        'buttons' => array (
                                'verComprobante' => array (
                                        'label' => 'Ver Comprobante Origen',
                                        'imageUrl' => Yii::app ()->theme->baseUrl . "/img/icons/b_props.png",
                                        'url' => '$data->getUrlVerOrigen()',
                                        'visible' => 'true',
                                        'options' => array (
                                                'target' => '_blank' 
                                        )),
                                        'crearAsiento' => array (
                                            'label' => 'Crear Asiento',
                                            'imageUrl' => Yii::app ()->theme->baseUrl . "/img/perfil.png",
                                            'url' => '$data->getUrlCrearAsiento()',
                                            'visible' => 'true',
                                            'options' => array (
                                                    //'target' => '_blank' 
                                            ),
                                            /*'ajax' => array(
                                                'type' => 'GET',
                                                'update'=>'#asientos-grid',      
                                                'ajaxUrl' => '$data->getUrlCrearAsiento()',
                                                //'dataType' => 'json',
                                                //'data' => array('id' =>'js:this.value'),
                                            )  */                                    
                                        )) )
)) );
												?>
</div>
</div>
<div style="width:1500px">

<div class="titulo">SALDOS</div>
<?php 
    $datAsientosBco = $dataproviderAsentados->getData(true);
    $dataAsientoMovs = $dataproviderNoAsentados->getData(true);
    $asientos->calcularSaldos($datAsientosBco, $dataAsientoMovs);
    $this->renderPartial ( '_footerSaldosBancos', array (
                    'model' => $asientos 
    ) );
    
?>
</div>