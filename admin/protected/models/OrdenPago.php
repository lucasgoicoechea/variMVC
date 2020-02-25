<?php
class OrdenPago extends CActiveRecord {
	public $id_proveedor = 0;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'orden_pago';
	}
	public function rules() {
		return array (
				array (
						' id_cuenta, observacion, pagada, numero_op, fecha',
						'required' 
				),
				array (
						'id_orden_pago, id_proveedor,id_cuenta, pagada, numero_op',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'observacion',
						'length',
						'max' => 255 
				),
				array (
						'id_orden_pago, id_cuenta,en_pago,id_proveedor, observacion, pagada, numero_op, fecha',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta' 
				),
				'proveedor' => array (
					self::BELONGS_TO,
					'Proveedor',
					'id_proveedor' 
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
	public function attributeLabels() {
		return array (
				'id_orden_pago' => Yii::t ( 'app', 'Orden Pago' ),
				'id_cuenta' => Yii::t ( 'app', 'Cuenta' ),
				'observacion' => Yii::t ( 'app', 'Observacion' ),
				'pagada' => Yii::t ( 'app', 'Pagada' ),
				'numero_op' => Yii::t ( 'app', 'Nro. Orden Pago' ),
				'fecha' => Yii::t ( 'app', 'Fecha' ) 
		);
	}
	public function agregarEnPago($id_orden_pago) {
		OrdenPago::model ()->updateByPk ( $id_orden_pago, array (
				"en_pago" => 1 
		) );
	}
	public function crearNuevaOP($idPago) {
		$op = new OrdenPago ();
		$op->en_pago = 1;
		$op->pagada = 0;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_orden_pago`) as `max` FROM `orden_pago` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$op->numero_op = $id_lead_new;
		$op->id_orden_pago = $id_lead_new;
		$op->observacion = 'Orden de Pago automatica creada para el Pago ID:' . $idPago;
		$op->fecha = CTimestamp::formatDate ( 'Y-m-d' );
		return $op;
	}
	public function crearNuevaOPPagada($gasto) {
		$op = new OrdenPago ();
		$op->en_pago = 1;
		$op->pagada = 1;
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_orden_pago`) as `max` FROM `orden_pago` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$op->numero_op = $id_lead_new;
		$op->id_orden_pago = $id_lead_new;
		$op->observacion = 'Orden de Pago automatica creada para el Comprobante :' . $gasto->tipoComprobante->Nombre . ' - Nro.: ' . $gasto->NumComprobante;
		$op->fecha = CTimestamp::formatDate ( 'Y-m-d' );
		return $op;
	}
	public function sacarEnPago($id_orden_pago) {
		OrdenPago::model ()->updateByPk ( $id_orden_pago, array (
				"en_pago" => 0,
				"pagada" => 0 
		) );
		OrdenPagoGasto::model ()->sacarEnPagadoGastos ( $id_orden_pago );
	}
	public function ponerPagada($id_orden_pago) {
		OrdenPago::model ()->updateByPk ( $id_orden_pago, array (
				"pagada" => 1 
		) );
		OrdenPagoGasto::model ()->ponerEnPagadoGastos ( $id_orden_pago );
	}
	public function ponerNoPagada($id_orden_pago) {
		OrdenPago::model ()->updateByPk ( $id_orden_pago, array (
				"pagada" => 1 
		) );
		OrdenPagoGasto::model ()->ponerEnNoPagadoGastos ( $id_orden_pago );
	}
	
	public function searchOrdenesPagos() {
		$criteria = new CDbCriteria ();
		
		// $criteria->compare('id_orden_pago',$this->id_orden_pago);
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'observacion', $this->observacion, true );
		
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'numero_op', $this->numero_op );
		
		$criteria->compare ( 'fecha', $this->fecha, true );
		$criteria->order = ' id_orden_pago DESC';
		
		$criteria->condition = ' pagada=0 and en_pago=0';
		
		return new CActiveDataProvider ( 'OrdenPago', array (
				'criteria' => $criteria 
		) );
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		// $criteria->compare('id_orden_pago',$this->id_orden_pago);
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'observacion', $this->observacion, true );
		
		$criteria->compare ( 'pagada', $this->pagada );
		
		$criteria->compare ( 'numero_op', $this->numero_op );
		
		$criteria->compare ( 'fecha', $this->fecha, true );
		$criteria->order = ' id_orden_pago DESC';
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20 
				) 
		) );
	}
	public function isPagada() {
		return $this->pagada;
	}
	public function getMonto() {
		$montoTotalOP = 0.00;
		$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $this->id_orden_pago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				if ($value->gasto->id_tipo_comprobante == 10) { //nota de credito
					$montoTotalOP = $montoTotalOP - $value->gasto->getMontoTotal ();
				}
				else $montoTotalOP = $montoTotalOP + $value->gasto->getMontoTotal ();
			}
		}
		return $montoTotalOP;
	}
	public function borrarComprobantes() {
		$resultados = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $this->id_orden_pago );
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$value->delete ();
			}
		}
	}
	public function validarParaBorrar() {
		// fijarse que no tenga Pago
		$resultados = PagoOrdenPago::model ()->searchWithOrdenPago ( $this->id_orden_pago );
		return (sizeof ( $resultados ) == 0);
	}
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'ordenPago/imprimirOrden', array (
				'id' => $this->id_orden_pago 
		) );
		return $url;
	}
	public function getUrlPago() {
		$pagOP = PagoOrdenPago::model ()->searchWithOrdenPagoOO ( $this->id_orden_pago );
		if ($pagOP != null && sizeof ( $pagOP ) > 0) {
			foreach ( $pagOP as $pagitoOP ) {
				$url = Yii::app ()->createUrl ( 'pago/view', array (
						'id' => $pagitoOP->id_pago 
				) );
				return $url;
			}
		}
		return '#';
	}
	public function getPago($id_orden_pago) {
		$pagOP = PagoOrdenPago::model ()->searchWithOrdenPagoOO ( $id_orden_pago );
		if ($pagOP != null && sizeof ( $pagOP ) > 0) {
			foreach ( $pagOP as $pagitoOP ) {
				return Pago::model ()->findByPk ( $pagitoOP->id_pago );
			}
		}
		return '#';
	}
	public function getComprobantes() {
		$ops = OrdenPagoGasto::model ()->searchWithOrdenPagoOO ( $this->id_orden_pago );
		$gastos = array();
		if (sizeof ( $ops ) > 0) {
			foreach ( $ops as $op ) {
				$gastos[] = $op->gasto;
			}
		}
		return $gastos;
	}
}
