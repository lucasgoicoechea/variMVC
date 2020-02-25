<?php
class Cheque extends CActiveRecord {
	public $chequeNroHasta = 0;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cheques';
	}
	public function rules() {
		return array (
				array (
						' id_obra, id_cuenta_banco, id_proveedor, id_cheque',
						'numerical',
						'integerOnly' => true 
				),
				array (
						' porc_impuesto_cheque,porc_impuesto_debito',
						'numerical',
						//'integerOnly' => true
				),
				array (
						'Numero',
						'length',
						'max' => 510 
				),
				array (
						'Importe',
						'length',
						'max' => 10 
				),
				array (
						'FechaEmision, FechaPago,serie',
						'safe' 
				),
				array (
						'serie, id_pago, id_cuenta_banco, Numero, FechaEmision, FechaPago, Importe, id_cheque,a_la_orden,porc_impuesto_cheque,porc_impuesto_debito, anulado,id_cheque_reemplaza,id_cheque_dias',
						'safe',
						//'on' => 'search' 
				) 
		);
	}
	
	
	public function relations() {
		return array (
				'cuentaBanco' => array (
						self::BELONGS_TO,
						'CuentaBanco',
						'id_cuenta_banco' 
				),
				'chequeDias' => array (
						self::BELONGS_TO,
						'ChequeDias',
						'id_cheque_dias' 
				),
				'cobros' => array (
						self::HAS_MANY,
						'Cobro',
						'id_cheque' 
				),
				'recuperacheques' => array (
						self::HAS_MANY,
						'RecuperaCheque',
						'id_cheque' 
				),
				'pago' => array (
						self::BELONGS_TO,
						'Pago',
						'id_pago' 
				),
				'chequeReemplazo' => array (
						self::BELONGS_TO,
						'Cheque',
						'id_cheque_reemplaza'
				),
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
				'serie' => Yii::t ( 'app', 'Serie' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_cuenta_banco' => Yii::t ( 'app', 'Cuenta Banco' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'Numero' => Yii::t ( 'app', 'Numero' ),
				'FechaEmision' => Yii::t ( 'app', 'Fecha Emision' ),
				'FechaPago' => Yii::t ( 'app', 'Fecha Pago' ),
				'Importe' => Yii::t ( 'app', 'Importe' ),
				'id_cheque' => Yii::t ( 'app', 'Cheque' ) ,
				'id_pago' => Yii::t ( 'app', 'Pago' ),
				'a_la_orden' => Yii::t ( 'app', 'A la Orden de' ),
				'porc_impuesto_cheque' => Yii::t ( 'app', '% Impuesto Cheque' ),
				'porc_impuesto_debito' => Yii::t ( 'app', '% Impuesto Debito' ),
				 'anulado' => Yii::t ( 'app', 'Anulado' ),
				'id_cheque_reemplaza' => Yii::t ( 'app', 'Cheque reemplazo' )
		);
	}
	public function getDescripcion() {
		return "Serie: " . $this->serie . " - Nro.: " . $this->Numero;
	}
	
	public function getUrlReemplazoCheque() {
		$url = Yii::app ()->createUrl ( 'cheque/reemplazarCheque', array (
				'id' => $this->id_cheque,
		) );
		return $url;
	}
	public function getUrlAnularCheque() {
		$url = Yii::app ()->createUrl ( 'cheque/anularCheque', array (
				'id' => $this->id_cheque,
		) );
		return $url;
	}

	public function agregarEnPago($idCheque, $idPago) {
		$pago = Pago::model()->findByPk($idPago);
		Cheque::model()->updateByPk
		($idCheque,array("id_pago"=>$idPago,//"id_obra"=>$pago->id_obra,
		"id_proveedor"=>$pago->id_proveedor));
	}
	
	public function copiarParaReemplazo($chequeOriginal, $cheque) {
		//id_obra
		$cheque->id_pago = $chequeOriginal->id_pago ;
		$cheque->id_proveedor=$chequeOriginal->id_proveedor;
		$cheque->id_cheque_reemplaza =$chequeOriginal->id_cheque; 
		$cheque->id_cheque_dias=$chequeOriginal->id_cheque_dias;
		$cheque->FechaPago=$chequeOriginal->FechaPago;
		$cheque->FechaEmision=$chequeOriginal->FechaEmision;
		$cheque->Importe=$chequeOriginal->Importe;
		$cheque->a_la_orden=$chequeOriginal->a_la_orden;
		$cheque->porc_impuesto_cheque=$chequeOriginal->porc_impuesto_cheque;
		$cheque->porc_impuesto_debito=$chequeOriginal->porc_impuesto_debito;
		return $cheque->save();
	}

	public function sacarEnPago($idCheque){
		Cheque::model()->updateByPk
		($idCheque,array("id_pago"=>null));
	}
	

	public function anularCheque($idCheque){
		Cheque::model()->updateByPk
		($idCheque,array("anulado"=>1));
	}
	
	public function isAnulado() {
		return $this->anulado;
	}
	
	public function isConPago() {
		return $this->id_pago!=null;		
	}

	public function getUrlPagoEditar() {
		$url = Yii::app ()->createUrl ( 'pago/update', array (
								'id' => $this->id_pago
						) );
		return $url;
	}
	
	public function searchEntreFechas($fechaDesde, $fechaHasta) {
		$criteria = new CDbCriteria ();
	
		$criteria->compare ( 'serie', $this->serie );
	
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		$criteria->compare ( 'anulado', $this->anulado );
	
		$criteria->compare ( 'Numero', $this->Numero, true );
	
		if ($fechaDesde==null) {
			//inicio de activades, habrai que sacarlo de la empresa
			$fechaDesde ='2016-09-01';
		}
		if ($fechaHasta==null) {
			$fechaHasta =CTimestamp::formatDate ( 'Y-m-d' );
		}
		$criteria->compare ( 't.FechaEmision', '>=' . $fechaDesde, true );
		$criteria->compare ( 't.FechaEmision', '<=' . $fechaHasta, true );
		
		$criteria->compare ( 'FechaPago', $this->FechaPago, true );
	
		$criteria->compare ( 'Importe', $this->Importe, true );
	
		$criteria->compare ( 'id_cheque', $this->id_cheque );
	
		$criteria->compare ( 'id_cheque_dias', $this->id_cheque_dias );
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria ,
				'pagination' => false
		) );
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'serie', $this->serie );
		
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		$criteria->compare ( 'anulado', $this->anulado );
		
		$criteria->compare ( 'Numero', $this->Numero, true );
		
		$criteria->compare ( 'FechaEmision', $this->FechaEmision, true );
		
		$criteria->compare ( 'FechaPago', $this->FechaPago, true );
		
		$criteria->compare ( 'Importe', $this->Importe, true );
		
		$criteria->compare ( 'id_cheque', $this->id_cheque );

		$criteria->compare ( 'id_cheque_dias', $this->id_cheque_dias );
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria ,
				'pagination' => array (
						'pageSize' => 20 
				) 
		) );
	}
	public function searchChequesLibres() {
		$criteria = new CDbCriteria ();
	
		$criteria->compare ( 'serie', $this->serie );
	
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		$criteria->compare ( 'anulado', false );
		$criteria->compare ( 'id_pago', null );
	
		$criteria->compare ( 'Numero', $this->Numero, true );
	
		$criteria->compare ( 'FechaEmision', $this->FechaEmision, true );
	
		$criteria->compare ( 'FechaPago', $this->FechaPago, true );
	
		$criteria->compare ( 'Importe', $this->Importe, true );
	
		$criteria->compare ( 'id_cheque', $this->id_cheque );
	
		$criteria->compare ( 'id_cheque_dias', $this->id_cheque_dias );
		
		$criteria->addCondition( ' NOT EXISTS (SELECT id_cheque FROM pago_cheque WHERE pago_cheque.id_cheque = t.id_cheque)' );
		
		$criteria->order = ' t.id_cheque DESC'; 
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria ,
				'pagination' => array (
						'pageSize' => 20
				)
		) );
	}
	
	public function getReemplazantes() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_cheque_reemplaza', $this->id_cheque );
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria ,
				'pagination' => array (
						'pageSize' => 20
				)
		) );
	}
	
	
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'cheque/imprimirCheque', array (
				'id' => $this->id_cheque,
		) );
		return $url;
	}
	public function getUrlVerDetalle() {
		$url = Yii::app ()->createUrl ( 'cheque/view', array (
				'id' => $this->id_cheque,
		) );
		return $url;
	}
	
	
	public function afterFind() {
		$this->Importe= LGHelper::functions ()->formatNumber ($this->Importe);
		$this->FechaEmision= LGHelper::functions ()->displayFecha ($this->FechaEmision);
		$this->FechaPago= LGHelper::functions ()->displayFecha ($this->FechaPago);
		return parent::afterFind();
	}
	public function save() {
		$this->Importe= LGHelper::functions ()->unformatNumber ($this->Importe);
		$this->FechaEmision= LGHelper::functions ()->undisplayFecha ($this->FechaEmision);
		$this->FechaPago= LGHelper::functions ()->undisplayFecha ($this->FechaPago);
		return parent::save();
	}
}
