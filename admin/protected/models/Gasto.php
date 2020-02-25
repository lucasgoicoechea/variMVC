<?php
class Gasto extends CActiveRecord {
	public $id_pago;
	public $id_medio_pago = null;
	public $fechaDesde = null;
	public $fechaAsientoHasta = null;
	public $fechaAsientoDesde = null;
	public $fechaHasta = null;
	public $subTotalSinIVA = 0.00;
	public $subTotalDeIVA = 0.00;
	public $subTotalConIVA = 0.00;
	public $totalSinIVA = 0.00;
	public $totalDeIVA = 0.00;
	public $totalConIVA = 0.00;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'gastos';
	}
	public function rules() {
		return array (
				// array('fechaDesde','convertir_fecha'),
				array (
						'id_obra, id_proveedor, id_tipo_comprobante,FechaAsiento',
						'required' 
				),
				array (
						'id_contrato_cabecera',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'id_obra, id_proveedor, id_tipo_comprobante',
						'numerical',
						'integerOnly' => true,
						'min' => 1,
						'message' => 'Debe ingresar valor' 
				),
				array (
						'Codigo',
						'numerical' 
				),
				array (
						'NumComprobante, Detalle',
						'length',
						'max' => 510 
				),
				array (
						'Monto',
						'length',
						'max' => 12 
				),
				array (
						'FechaAsiento, FechaFactura',
						'safe' 
				),
				array (
						'id_proveedor',
						'numerical',
						'integerOnly' => true,
						'min' => 1 
				),
				
				array (
						'id_quincena, id_gasto,en_blanco, en_orden_pago, pagada,Codigo, FechaAsiento, id_obra, id_proveedor, id_tipo_comprobante, NumComprobante,  Monto, FechaFactura, Detalle,  id_contrato_cabecera,fechaDesde, fechaHasta,fechaAsientoDesde,fechaAsientoHasta,id_medio_pago,NumComprobante',
						'safe' 
				) 
		);
		// 'on' => 'search'
		
		;
	}
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'gasto/imprimirComprobante', array (
				'id' => $this->id_gasto 
		) );
		return $url;
	}
	public function getUrlImprimirContrato() {
		$url = Yii::app ()->createUrl ( 'gasto/imprimirComprobanteContrato', array (
				'id' => $this->id_gasto 
		) );
		return $url;
	}
	public function getUrlBorrarContrato() {
		$url = Yii::app ()->createUrl ( 'gasto/borrarGastoContrato', array (
				'id' => $this->id_gasto
		) );
		return $url;
	}
	public function getEditarGasto() {
		$url = Yii::app ()->createUrl ( 'gasto/update', array (
				'id' => $this->id_gasto 
		) );
		return $url;
	}
	public function getVerGasto() {
		$url = Yii::app ()->createUrl ( 'gasto/view', array (
				'id' => $this->id_gasto 
		) );
		return $url;
	}
	public function relations() {
		return array (
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'tipoComprobante' => array (
						self::BELONGS_TO,
						'TipoComprobante',
						'id_tipo_comprobante' 
				),
				
				'contratoCabecera' => array (
						self::BELONGS_TO,
						'ContratoCabecera',
						'id_contrato_cabecera' 
				),
				'retiroscapitales' => array (
						self::HAS_MANY,
						'RetiroCapital',
						'id_gasto' 
				) ,
				'quincena' => array (
						self::HAS_MANY,
						'Quincena',
						'id_quincena'
				) 
		);
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function agregarEnOP($id_gasto) {
		Gasto::model ()->updateByPk ( $id_gasto, array (
				"en_orden_pago" => 1 
		) );
	}
	public function sacarEnOP($id_gasto) {
		Gasto::model ()->updateByPk ( $id_gasto, array (
				"en_orden_pago" => 0 ,
				"pagada" => 0
		) );
	}
	function tienePago() {
		$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
		if ($opg != null && sizeof ( $opg ) > 0) {
			foreach ( $opg as $opgasto ) {
				$op = OrdenPago::model ()->findByPk ( $opgasto->id_orden_pago );
				if ($op->en_pago)
					return true;
			}
		}
		return false;
	}
	public function getExeptuaCierre() {
		return true;
	}
	public function getUrlOP() {
		$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
		if ($opg != null && sizeof ( $opg ) > 0) {
			foreach ( $opg as $opgasto ) {
				$op = OrdenPago::model ()->findByPk ( $opgasto->id_orden_pago );
				$url = Yii::app ()->createUrl ( 'ordenPago/view', array (
						'id' => $op->id_orden_pago 
				) );
				return $url;
				;
			}
		}
		return '#';
	}
	public function getUrlPagar() {
		$url = Yii::app ()->createUrl ( 'gasto/updatePrePagado', array (
				'id' => $this->id_gasto 
		) );
		return $url;
	}
	public function getUrlPago() {
		$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
		if ($opg != null && sizeof ( $opg ) > 0) {
			foreach ( $opg as $opgasto ) {
				$pagOP = PagoOrdenPago::model ()->searchWithOrdenPagoOO ( $opgasto->ordenPago->id_orden_pago );
				if ($pagOP != null && sizeof ( $pagOP ) > 0) {
					foreach ( $pagOP as $pagitoOP ) {
						$url = Yii::app ()->createUrl ( 'pago/view', array (
								'id' => $pagitoOP->id_pago 
						) );
						return $url;
					}
				}
			}
		}
		return '#';
	}
	public function getUrlContrato() {
		$url = Yii::app ()->createUrl ( 'contratoCabecera/view', array (
				'id' => $this->id_contrato_cabecera 
		) );
		return $url;
	}
	public function getContrato() {
		return ContratoCabecera::model ()->findByPk ( $this->id_contrato_cabecera );
	}
	public function getUrlPagoEditar() {
		$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
		if ($opg != null && sizeof ( $opg ) > 0) {
			foreach ( $opg as $opgasto ) {
				$pagOP = PagoOrdenPago::model ()->searchWithOrdenPagoOO ( $opgasto->id_orden_pago );
				if ($pagOP != null && sizeof ( $pagOP ) > 0) {
					foreach ( $pagOP as $pagitoOP ) {
						$url = Yii::app ()->createUrl ( 'pago/update', array (
								'id' => $pagitoOP->id_pago 
						) );
						return $url;
					}
				}
			}
		}
		return '#';
	}
	function getPago() {
		$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
		if ($opg != null && sizeof ( $opg ) > 0) {
			foreach ( $opg as $opgasto ) {
				$pagOP = PagoOrdenPago::model ()->searchWithOrdenPagoOO ( $opgasto->id_orden_pago );
				if ($pagOP != null && sizeof ( $pagOP ) > 0) {
					foreach ( $pagOP as $pagitoOP ) {
						return $pagitoOP->pago;
					}
				}
			}
		}
		return new Pago ();
	}
	public function attributeLabels() {
		return array (
				'id_gasto' => Yii::t ( 'app', 'Gasto' ),
				'Codigo' => Yii::t ( 'app', 'Codigo de Asiento' ),
				'FechaAsiento' => Yii::t ( 'app', 'Fecha Asiento' ),
				'pagada' => Yii::t ( 'app', 'Pagado' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'id_tipo_comprobante' => Yii::t ( 'app', 'Tipo Comprobante' ),
				'NumComprobante' => Yii::t ( 'app', 'Nro. Factura / Comprobante' ),
				'Monto' => Yii::t ( 'app', 'Importe' ),
				'FechaFactura' => Yii::t ( 'app', 'Fecha Factura / Compra' ),
				'Detalle' => Yii::t ( 'app', 'Detalle' ),
				'id_contrato_cabecera' => Yii::t ( 'app', 'Contrato' ),
				'IIBB' => Yii::t ( 'app', '% IIBB' ) 
		);
	}
	public function searchConOP() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'en_orden_pago', $this->en_orden_pago );
		$criteria->compare ( 'id_gasto', $this->id_gasto );
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 30 
				) 
		) );
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_gasto', $this->id_gasto );
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 30 
				) 
		) );
	}
	public function searchSinPaginar() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_gasto', $this->id_gasto );
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => false 
		) );
	}
	public function getProveedorDescripcion() {
		$prov = $this->proveedor != null ? $this->proveedor : new Proveedor ();
		return $prov->getDescripcion ();
	}
	public function getTipoComprobante() {
		$tiposComprobantes = TipoComprobante::model ()->findAll ( array (
				"condition" => 'visible=1',
				'order' => 'Nombre' 
		) );
		return CHtml::listData ( $tiposComprobantes, "id_tipo_comprobante", "Nombre" );
	}
	public function getTipoComprobanteSubcontrato() {
		$tiposComprobantes = TipoComprobante::model ()->findAll ( array (
				"condition" => 'subcontrato=1',
				'order' => 'Nombre' 
		) );
		return CHtml::listData ( $tiposComprobantes, "id_tipo_comprobante", "Nombre" );
	}
	public function isPagada() {
		return $this->pagada;
	}
	public function searchWithContrato($id_contrato) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_contrato_cabecera', $id_contrato );
		$criteria->order = ' id_gasto desc ';
		$results = Gasto::model ()->findAll ( $criteria );
		return $results;
	}
	public function searchFiltrosConMedioPago() {
		$criteria = new CDbCriteria ();
		//$criteria->distinct = true;
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		/*$this->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $this->FechaAsiento );
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		$criteria->compare ( 'pagada', $this->pagada );
		$criteria->compare ( 'en_orden_pago', $this->en_orden_pago );
		/*if ($this->id_medio_pago != null) {
			$tipoMedioPago = MedioPago::model ()->findByPk ( $this->id_medio_pago );
			$criteria->join = $criteria->join . 'LEFT JOIN ' . OrdenPagoGasto::model ()->tableName () . ' gc ON gc.id_gasto=t.id_gasto ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . PagoOrdenPago::model ()->tableName () . ' pop ON gc.id_orden_pago = pop.id_orden_pago ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . $tipoMedioPago->tabla_pk . ' tc ON tc.id_pago=pop.id_pago ';
			// $criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true));
			$criteria->addCondition ( 'tc.id_pago IS NOT NULL' ); //
		}
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		*/
		//$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria,
				'pagination' => false ,
				'sort' => array (
						'defaultOrder' => 't.FechaAsiento DESC' 
				) 
		) );
	}
	public function searchFiltrosConMedioPagoSinPaginar() {
		$criteria = new CDbCriteria ();
		$criteria->distinct = true;
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$this->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $this->FechaAsiento );
		if ($this->FechaAsiento != null)
			$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		if ($this->id_proveedor != null && $this->id_proveedor>0) {
			$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		}
		//$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		$criteria->compare ( 'pagada', $this->pagada );
		$criteria->compare ( 'en_orden_pago', $this->en_orden_pago );
		if ($this->id_medio_pago != null) {
			$tipoMedioPago = MedioPago::model ()->findByPk ( $this->id_medio_pago );
			$criteria->join = $criteria->join . 'LEFT JOIN ' . OrdenPagoGasto::model ()->tableName () . ' gc ON gc.id_gasto=t.id_gasto ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . PagoOrdenPago::model ()->tableName () . ' pop ON gc.id_orden_pago = pop.id_orden_pago ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . $tipoMedioPago->tabla_pk . ' tc ON tc.id_pago=pop.id_pago ';
			// $criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true));
			$criteria->addCondition ( 'tc.id_pago IS NOT NULL' ); //
		}
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		$this->fechaAsientoDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaAsientoDesde );
		$this->fechaAsientoHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaAsientoHasta );
		if ($this->fechaAsientoDesde != null)
			$criteria->compare ( 't.FechaAsiento', '>=' . $this->fechaAsientoDesde, true );
		if ($this->fechaAsientoHasta != null)
			$criteria->compare ( 't.FechaAsiento', '<=' . $this->fechaAsientoHasta, true );
		$criteria->limit = 2000;
		//$criteria->order = ' FechaAsiento asc ';
		$gastos = new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria,
				'pagination' => false ,
				'sort'=>array(
					    'defaultOrder'=>'Codigo DESC',
					  )
				
		)
		 );
		return $gastos;
	}
	public function searchFiltrosConMedioPagoAPagarSinPaginar() {
		/*Yii::app ()->db->createCommand ("SET SQL_BIG_SELECTS = 1")->execute();
		$criteria = new CDbCriteria ();
		$criteria->distinct = true;
		$criteria->compare ( 'Codigo', $this->Codigo );
	
		$this->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $this->FechaAsiento );
		if ($this->FechaAsiento != null)
			$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
	
		$criteria->compare ( 'id_obra', $this->id_obra );
	
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		if ($this->id_proveedor != null && $this->id_proveedor>0) {
			$criteria->compare ( 't.id_proveedor', $this->id_proveedor );
		}
		//$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
	
		$criteria->compare ( 'Monto', $this->Monto, true );
		$criteria->compare ( 'pagada', $this->pagada );
		$criteria->compare ( 'en_orden_pago', $this->en_orden_pago );
		//if ($this->id_medio_pago != null) {
			$tipoMedioPago = MedioPago::model ()->findByPk ( $this->id_medio_pago );
			$criteria->join = $criteria->join . 'LEFT JOIN ' . OrdenPagoGasto::model ()->tableName () . ' gc ON gc.id_gasto=t.id_gasto ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . PagoOrdenPago::model ()->tableName () . ' pop ON gc.id_orden_pago = pop.id_orden_pago ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . Pago::model ()->tableName (). ' tc ON tc.id_pago=pop.id_pago ';
			// $criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true));
			$criteria->addCondition ( 'tc.id_cuenta = 1' ); //CUENTA FACTURAS A PAGAR
		//}
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		$this->fechaAsientoDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaAsientoDesde );
		$this->fechaAsientoHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaAsientoHasta );
		if ($this->fechaAsientoDesde != null)
			$criteria->compare ( 't.FechaAsiento', '>=' . $this->fechaAsientoDesde, true );
		if ($this->fechaAsientoHasta != null)
			$criteria->compare ( 't.FechaAsiento', '<=' . $this->fechaAsientoHasta, true );
		$criteria->limit = 2000;
		//$criteria->order = ' FechaAsiento asc ';
		$gastos = new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria,
				'pagination' => false ,
				'sort'=>array(
						'defaultOrder'=>'Codigo DESC',
				)
	
		)
		);*/
		$criteria = new CDbCriteria ();
		$criteria->distinct = true;
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		$criteria->compare ( 'id_obra', $this->id_obra );
		if ($this->id_proveedor != null && $this->id_proveedor>0) {
			$criteria->compare ( 't.id_proveedor', $this->id_proveedor );
		}
		//$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		$criteria->compare ( 'Monto', $this->Monto, true );
		$criteria->compare ( 'pagada', 0 );
		$gastos = new CActiveDataProvider ( 'Gasto', array (
			'criteria' => $criteria,
			'pagination' => false ,
			'sort'=>array(
					'defaultOrder'=>'Codigo DESC',
			)
		)
		);
		return $gastos;
	}
	public function searchFiltros() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$this->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $this->FechaAsiento );
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		$criteria->compare ( 'pagada', $this->pagada );
		$criteria->compare ( 'en_orden_pago', $this->en_orden_pago );
		
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria ,
				'sort'=>array(
					    'defaultOrder'=>'FechaFactura DESC',
					  )
		) );
	}
	public function searchFiltrosSinPaginar() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_obra', $this->id_obra );
		$criteria->compare ( 'pagada', true );
		
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria,
				'pagination' => false ,
				'sort'=>array(
					    'defaultOrder'=>'FechaFactura DESC',
					  )
		) );
	}
	public function searchGastos() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		// $criteria->compare ( 'en_blanco', $this->en_blanco);
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		$criteria->compare ( 'pagada', 0 );
		$criteria->compare ( 'en_orden_pago', 0 );
		// $criteria->condition = ' id_proveedor=' . $idProveedor;
		// $criteria->condition = ' pagada=0 and en_orden_pago=0';
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria 
		) );
	}

	public function searchGastosFacturasAPagar() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		// $criteria->compare ( 'en_blanco', $this->en_blanco);
		
		//$criteria->compare ( 'id_proveedor', $this->id_proveedor,true );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		//$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		//$criteria->compare ( 'pagada', false,true );
		//$criteria->compare ( 'en_orden_pago', false,true );
	   	$criteria->condition =  ' id_proveedor=' . $this->id_proveedor.' and  pagada=0 and en_orden_pago=0';
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( 'Gasto', array (
				'criteria' => $criteria 
		) );
	}
	public function sacarEnPago($idGasto) {
		Gasto::model ()->updateByPk ( $idGasto, array (
				"pagada" => 0 
		) );
	}
	public function getTotalMontoRetenciones($idGasto) {
		// debe recorrer todas los medios de pago y genera el monto
		$montoTotalRetenciones = 0;
		$resultados = GastoRetencionPercepcion::model ()->searchWithGastoOO ( $idGasto );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalRetenciones = $montoTotalRetenciones + $value->alicuota;
			}
		}
		return $montoTotalRetenciones;
	}
	public function getUrlAgregarRetenciones($id_gasto) {
		$url = Yii::app ()->createUrl ( 'gasto/agregarRetencionGasto', array (
				'id_gasto' => $id_gasto 
		) );
		return $url;
	}
	
	public function getUrlAgregarDetalleItem($id_gasto,$id_obra,$id_proveedor) {
		$url = Yii::app ()->createUrl ( 'gasto/agregarDetalleItem', array (
				'id_gasto' => $id_gasto ,
				'id_proveedor' =>$id_proveedor,
				'id_obra'=> $id_obra
		) );
		return $url;
	}
	
	public function getUrlTotalGasto($id_gasto) {
		$url = Yii::app ()->createUrl ( 'gasto/calcularTotalGasto', array (
				'id_gasto' => $id_gasto 
		) );
		return $url;
	}
	public function getUrlTotalGastoPagado($id_gasto) {
		$url = Yii::app ()->createUrl ( 'gasto/calcularTotalGastoPagado', array (
				'id_gasto' => $id_gasto 
		) );
		return $url;
	}
	public function agregarRetencionesPercepciones() {
		if ($this->tipoComprobante->iva_iibb_fijados) {
			$impuestosfijos = RetencionPercepcion::model ()->getImpuestosFijos ();
			foreach ( $impuestosfijos as $retencion ) {
				$gastoRete = new GastoRetencionPercepcion ();
				$gastoRete->id_retencion_percepcion = $retencion->id_retencion_percepcion;
				$gastoRete->id_gasto = $this->id_gasto;
				$gastoRete->valor = $retencion->valor_fijo;
				if ($retencion->es_porcentaje) {
					$porcentaje = 0;
					$monto = LGHelper::functions ()->unformatNumber ( $this->Monto );
					if ($monto > 0 && $gastoRete->valor > 0)
						$porcentaje = $monto / 100 * $gastoRete->valor;
					$gastoRete->alicuota = $porcentaje;
				} else
					$gastoRete->alicuota = $gastoRete->valor;
				$gastoRete->save ();
			}
		}
	}
	public function actualizarRetencionesPercepciones() {
		$impuestosfijos = GastoRetencionPercepcion::model ()->searchWithGastoOO ( $this->id_gasto );
		if (sizeof ( $impuestosfijos ) > 0) {
			foreach ( $impuestosfijos as $gastoRete ) {
				$retencion = RetencionPercepcion::model ()->findByPK ( $gastoRete->id_retencion_percepcion );
				if ($retencion->impuesto_fijo) {
					$gastoRete->valor = $retencion->valor_fijo;
					$gastoRete->alicuota = $retencion->valor_fijo;
				} else {
					// $gastoRete->valor = $retencion->valor_fijo;
					if ($retencion->es_porcentaje) {
						$porcentaje = 0;
						$monto = LGHelper::functions ()->unformatNumber ( $this->Monto );
						if ($monto > 0 && $retencion->valor_fijo > 0)
							$porcentaje = $monto / 100 * $retencion->valor_fijo;
						$gastoRete->alicuota = $porcentaje;
					} else
						$gastoRete->alicuota = $gastoRete->valor;
					$gastoRete->save ();
				}
			}
		}
	}
	public function ponerPagada($idGasto) {
		Gasto::model ()->updateByPk ( $idGasto, array (
				"pagada" => 1 
		) );
	}
	public function ponerNoPagada($idGasto) {
		Gasto::model ()->updateByPk ( $idGasto, array (
				"pagada" => 0 
		) );
	}
	
	public function getDescripcion() {
		return $this->NumComprobante;
	}
	public function getMontoTotal() {
		$subtotal = $this->Monto;
		// $retpercep = 0;
		// no aplica las retenciones RRalba 17/11/16 y el subtotal es el total
		// $retpercep = $this->getTotalMontoRetenciones($this->id_gasto);
		// return $subtotal + $retpercep;
		return LGHelper::functions ()->unformatNumber ( $this->Monto );
	}
	public function getIVACalculado() {
		if ($this->tipoComprobante->iva_iibb_fijados) {
			$monto = LGHelper::functions ()->unformatNumber ( $this->Monto );
			if ($monto > 0.00) {
				$iva = $monto / 1.21 * 0.21;
				return round ( $iva, 2 );
			}
		}
		return 0.00;
	}
	public function calcularTotales($dataObjs) {
		$this->subTotalSinIVA = 0.00;
		$this->subTotalDeIVA = 0.00;
		$this->subTotalConIVA = 0.00;
		$this->totalSinIVA = 0.00;
		$this->totalDeIVA = 0.00;
		$this->totalConIVA = 0.00;
		foreach ( $dataObjs as $gasto ) {
			$monto = LGHelper::functions ()->unformatNumber ( $gasto->Monto );
			$this->subTotalSinIVA = $this->subTotalSinIVA + ($monto - $gasto->getIVACalculado ());
			$this->totalSinIVA = $this->totalSinIVA + ($monto - $gasto->getIVACalculado ());
			$this->subTotalDeIVA = $this->subTotalDeIVA + $gasto->getIVACalculado ();
			$this->totalDeIVA = $this->totalDeIVA + $gasto->getIVACalculado ();
			$this->totalConIVA = $this->totalConIVA + $monto;
			$this->subTotalConIVA = $this->subTotalConIVA + $monto;
		}
		$this->subTotalSinIVA = LGHelper::functions ()->formatNumber ( $this->subTotalSinIVA );
		$this->subTotalDeIVA = LGHelper::functions ()->formatNumber ( $this->subTotalDeIVA );
		$this->subTotalConIVA = LGHelper::functions ()->formatNumber ( $this->subTotalConIVA );
		$this->totalSinIVA = LGHelper::functions ()->formatNumber ( $this->totalSinIVA );
		$this->totalDeIVA = LGHelper::functions ()->formatNumber ( $this->totalDeIVA );
		$this->totalConIVA = LGHelper::functions ()->formatNumber ( $this->totalConIVA );
	}
	public function getFechaFacturaDisplay() {
		return LGHelper::functions ()->displayFecha ( $this->FechaFactura );
	}
	public function convertir_fecha($fechaD) {
		$fecha_partida = explode ( "/", $fechaD );
		$dia = $fecha_partida [0];
		$mes = $fecha_partida [1];
		$anio = $fecha_partida [2];
		$fechaD = $mes . "/" . $dia . "/" . $anio;
		$fechaD = date ( "Y-m-d", strtotime ( $fechaD ) ); // CDateTimeParser::parse($this->fechaDesde,'yyyy-mm-dd');
		if ($fechaD == null)
			$this->addError ( 'fecha', 'La fecha es requerida.' );
		return $fechaD;
	}
	public function findGastosPorMesAnio($anio, $mes, $conIva) {
		$criteria = new CDbCriteria ();
		$fechaIni = $anio . '-' . $mes . '-01';
		$fechaFin = $anio . '-' . $mes . '-31';
		if ($mes < 10) {
			$fechaIni = $anio . '-0' . $mes . '-01';
			$fechaFin = $anio . '-0' . $mes . '-31';
		}
		$criteria->addBetweenCondition ( 't.FechaFactura', $fechaIni, $fechaFin );
		// solo Fac A y Fac E que tributano descargan
		$cciva = $conIva ? "1 " : "0 ";
		$sql = "SELECT DISTINCT id_tipo_comprobante FROM tipocomprobante WHERE tributa=" . $cciva;
		$valores = Yii::app ()->db->createCommand ( $sql )->queryAll ( true );
		$string = '';
		foreach ( $valores as $key => $value ) {
			$string .= "," . $value ['id_tipo_comprobante'];
		}
		$string = substr ( $string, 1 );
		// Yii::log ( "Criteria:" . $arr, CLogger::LEVEL_WARNING, 'BUSCAR GASTOS' );
		$criteria->addCondition ( ' t.id_tipo_comprobante IN (' . $string . ' ) ' );
		// Yii::log ( "Criteria:" . $criteria->condition, CLogger::LEVEL_WARNING, 'BUSCAR GASTOS' );
		$results = Gasto::model ()->with ( array (
				'obra' 
		) )->findAll ( $criteria );
		// Yii::log ( "Criteria:" . $criteria->condition, CLogger::LEVEL_WARNING, 'BUSCAR GASTOS' );
		return $results;
	}
	public function getObra() {
		return $this->obra;
	}
	public function searchIVA($conIva) {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_gasto', $this->id_gasto );
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'FechaAsiento', $this->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		
		$criteria->compare ( 'id_tipo_comprobante', $this->id_tipo_comprobante );
		
		$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaFactura', $this->FechaFactura, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$cciva = $conIva ? "1 " : "0 ";
		$sql = "SELECT DISTINCT id_tipo_comprobante FROM tipocomprobante WHERE tributa=" . $cciva;
		$valores = Yii::app ()->db->createCommand ( $sql )->queryAll ( true );
		$string = '';
		foreach ( $valores as $key => $value ) {
			$string .= "," . $value ['id_tipo_comprobante'];
		}
		$string = substr ( $string, 1 );
		$criteria->addCondition ( ' t.id_tipo_comprobante IN (' . $string . ' ) ' );
		
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20 
				) 
		) );
	}
	public function afterFind() {
		// Yii::log ( 'VALOR'.$this->Monto, CLogger::LEVEL_WARNING, 'MONTO-BD' );
		$this->Monto = LGHelper::functions ()->formatNumber ( $this->Monto );
		// Yii::log ( 'VALOR'.$this->Monto, CLogger::LEVEL_WARNING, 'MONTO-FORMAT' );
		return parent::afterFind ();
	}
	public function save() {
		$this->Monto = LGHelper::functions ()->unformatNumber ( $this->Monto );
		
		return parent::save ();
	}
	public function getTotals($keys) {
		$wages = self::model ()->findAllByPk ( $keys );
		$sum = 0.00;
		foreach ( $wages as $wage )
			$sum += LGHelper::functions ()->unformatNumber ( $wage->Monto );
		return $sum;
	}
	public function getPendientesPorCajaIDCuentaID($id_caja, $id_cuenta) {
		$caja = Caja::getByID ( $id_caja );
		$gastos = Pago::getGastosFechaCuentaID ( $caja->fecha, $id_cuenta, false );
		return $gastos;
	}
	public function existeComprobante() {
		$sql = "SELECT * FROM gastos WHERE NumComprobante='" . $this->NumComprobante . "'";
		$sql = $sql . " and id_proveedor=" . $this->id_proveedor;
		$sql = $sql . " and id_obra=".$this->id_obra;
		//$sql = $sql . " and id_cuenta=".$this->id_cuenta;
		$sql = $sql . " and Monto=" . LGHelper::functions ()->unformatNumber ($this->Monto);
		//echo $sql;
		$valores = Yii::app ()->db->createCommand ( $sql )->queryAll ( true );
		return $valores != null;
	}

	public function borrarGastoContrato(){
		$this->borrarGastoConOPyPagos();
	}
	
	public function borrarGastoQuincena(){
		$this->borrarGastoConOPyPagos();
	}
    public function borrarGastoConOPyPagos(){
		
		//TODO BUSCAR SI TIENE CONTRATO Y SI TIENE QUINCENA Y BORRARLOS TAMBIEN
        //hay que borrar el gasto y sacarlo de la orden de pago y borrar el pago
      	$opgs = OrdenPagoGasto::model()->searchOrdenPagoWithGasto ( $this->id_gasto );
      	//echo '-Gasto:';
      	if ($opgs != null && sizeof ( $opgs ) > 0) {
      		//echo '-OP-Gasto:';
      		 
      		foreach ( $opgs as $opg){
      			//echo '-OP-Gasto:';
      			//echo '--'.$opg->id_orden_pago;
	      		$op = $opg->ordenPago;
	      		//echo '-OP:';
      			//echo $op->id_orden_pago.'--';
	      		//printf($op);
	      		$pops = PagoOrdenPago::model()->searchWithOrdenPagoOO($op->id_orden_pago);
	      		if ($pops != null && sizeof ( $pops ) > 0) {
		      		foreach ( $pops as $pop ){
		      			//echo '-OP-Pago:';
		      			//var_dump($pop);
		      			$pago = $pop->pago;
		      			//echo '-Pago:';
		      			//var_dump($pago);
		      			$pago->borrarPagosImputaciones();
		      			$pago->delete();
		      		}
	      		}
          		$op->delete();
	      		$opg->delete();
      		}	
      	}   	
      	echo $this->id_gasto.'dd';
      	$this->delete();
      	exit();
     }
     
     public function  bajaYCreateQuincenaPagado($quincena){
     	$model = Gasto::model()->findByPk ( $quincena->id_gasto) ;
     	$model->borrarGastoConOPyPagos();
     	$result = Gasto::model()->createQuincenaPagado($quincena);
     	return $result;     	
     }
     

     public function createQuincenaPagado($quincena) {
     	$model = new Gasto ();
     	$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_gasto`) as `max` FROM `gastos` WHERE 1" )->queryScalar ();
     	$id_lead_new = $id_lead_last + 1;
     	$model->Codigo = $id_lead_new;
     	//$this->performAjaxValidation ( $model );
     	if ($quincena->id_quincena != null) {
     		$model->quincena = $quincena;
     		$model->id_quincena = $model->quincena->id_quincena;
     		$model->id_tipo_comprobante = 5; // _formComprobante
     		$model->id_obra = $model->quincena!= null ? $model->quincena->id_obra : null;
     		$model->id_proveedor = $model->quincena!= null ? $model->quincena->id_proveedor : null;
     		$model->Detalle = 'Pago de QUINCENA a: ' . $model->proveedor->getDescripcion() . ', POR OBRA:' . $model->obra->getDescripcion ();
     		$model->pagada = 1;
			 $model->Monto = $model->quincena->Final;
			 echo $quincena->Fecha;
     		$model->FechaFactura = LGHelper::functions ()->undisplayFecha ( $quincena->Fecha  );
     		$model->FechaAsiento =date ( "Y-m-d");//LGHelper::functions ()->undisplayFecha ( $quincena->Fecha  );
     		     		
     		$idCuenta = $quincena->id_cuenta;//35; //SUELDOS PERSONALES
     		// Guardar el gasto
     		if ($model->save ()) {
				 $quincena->id_gasto = $model->id_gasto;
				 $quincena->save();
     			// $model->agregarRetencionesPercepciones ();
     			if ($model->tipoComprobante->iva_iibb_fijados) {
     				GastoController::model()->generateRetencionIVA ( $model->id_gasto, $model->Monto );
     			}
     			
     			$newOP = OrdenPago::model ()->crearNuevaOPPagada ( $model );
     			$newOP->id_cuenta = $idCuenta;
     			// Crear un numero de OP
     			
     			if ($newOP->save ()) {
     				$fechaCobro =$quincena->Fecha ;
     				$pago = Pago::model ()->crearNuevoPagoPagado ( $model->id_obra, $model->id_proveedor, $idCuenta, $fechaCobro );
     				// crear un Pago
     				if ($pago->save ()) {
     					// unir el gasto con la op
     					$opGasto = new OrdenPagoGasto ();
     					$opGasto->id_orden_pago = $newOP->id_orden_pago;
     					$opGasto->id_gasto = $model->id_gasto;
     					if ($opGasto->save ()) {
     						$pagoOP = new PagoOrdenPago ();
     						$pagoOP->id_orden_pago = $newOP->id_orden_pago;
     						$pagoOP->id_pago = $pago->id_pago;
     						// unir la op con el pago
     						// poner todo en pagado=true
     						if ($pagoOP->save ()) {
     							return "GUARDADO";
     						} else
     							return "Fallo al unir el Pago a la OP". print_r ( $pagoOP->getErrors () );
     					} else
     						return "Fallo al relacionar el Comprobante a la OP". print_r ( $opGasto->getErrors () );
     				} else
     					return "Fallo la creacion del Pago." . " " . print_r ( $pago->getErrors () );
     			} 	else
				 return "Falla al registrar la Orden Pago:". print_r ( $newOP->getErrors () );
     		} 	else
			 return "Fallo al registrar el Gasto:".print_r ( $model->getErrors () );
     	}
     	else  return "La Quincena no proviene con ID";
     }
     
     public function borrarGasto(){
     	//hay que borrar el gasto y sacarlo de la orden de pago y borrar el pago
     	$opg = OrdenPagoGasto::model ()->searchOrdenPagoWithGasto ( $this->id_gasto );
     	if ($opg != null && sizeof ( $opg ) > 0) {
     		$opg->delete();
     	}
     	$this->delete();
	 }
	 

}



