<?php
class CobroItem extends CActiveRecord {
	const ID_TIPO_FACTURA_NOTA_CREDITO = '3';
	public $fechaDesde = null;
	public $fechaHasta = null;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cobro_items';
	}
	public function rules() {
		return array (
				array (
						'Fecha, Indice, Importe',
						'required' 
				),
				array (
						'Indice, id_imputacion, id_forma,asentado',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Importe',
						'length',
						'max' => 12 
				),
				/*array (
						'Importe',
						'numerical',
						'integerOnly' => false 
				*/
				array (
						'mes_iva, numero_orden_pago',
						'length',
						'max' => 200 
				),
				array (
						'Detalles, id_cuenta_banco',
						'length',
						'max' => 200 
				),
				array (
						'id_cobro_item,id_cobro,id_cuenta, Indice, id_imputacion, id_forma, Importe, Fecha, FechaCobro, Detalles, asentado,fechaDesFinde, fechaHasta,nro_cheque_certificado',
						'safe' 
				)
				// 'on' => 'search'
				 
		);
	}
	public function relations() {
		return array (
				'imputacion' => array (
						self::BELONGS_TO,
						'Imputacion',
						'id_imputacion' 
				),
				'formaPago' => array (
						self::BELONGS_TO,
						'FormaPago',
						'id_forma' 
				),
				'cuentaBanco' => array (
						self::BELONGS_TO,
						'CuentaBanco',
						'id_cuenta_banco' 
				),
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta' 
				) 
		)
		;
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'cobro/imprimirCobroItem', array (
				'id' => $this->id_cobro 
		) );
		return $url;
	}
	public function attributeLabels() {
		return array (
				'id_cobro' => Yii::t ( 'app', 'Cobro' ),
				'Indice' => Yii::t ( 'app', 'Indice' ),
				'id_cliente' => Yii::t ( 'app', 'Cliente' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_imputacion' => Yii::t ( 'app', 'Imputacion' ),
				'id_forma' => Yii::t ( 'app', 'Forma Cobro' ),
				'Importe' => Yii::t ( 'app', 'Importe' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'nro_cheque_certificado' => Yii::t ( 'app', 'Nro.Cheque/Certificado/Ref.Deposito' ),
				'FechaCobro' => Yii::t ( 'app', 'Fecha Cobrado' ),
				'Detalles' => Yii::t ( 'app', 'Detalles' ),
				'asentado' => Yii::t ( 'app', 'Cobro Asentado' ),
				'id_cuenta_banco' => Yii::t ( 'app', 'Cuenta Banco' ),
				'cobrado' => Yii::t ( 'app', 'Cobrado' ),
				'es_blanco' => Yii::t ( 'app', 'Ticket' ),
				'mes_iva' => Yii::t ( 'app', 'Mes IVA' ),
				'numero_orden_pago' => Yii::t ( 'app', 'Número OP' )
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_cobro_item', $this->id_cobro_item );
	    $criteria->compare ( 'id_cobro', $this->id_cobro);
		$criteria->compare ( 'id_imputacion', $this->id_imputacion );
		$criteria->compare ( 'id_forma', $this->id_forma );
		$criteria->compare ( 'Importe', $this->Importe, true );
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		$criteria->compare ( 'FechaCobro', $this->FechaCobro, true );
	$criteria->compare ( 'Detalles', $this->Detalles, true );
		//$criteria->compare ( 'asentado', $this->asentado );
		//$criteria->order = ' t.Fecha desc';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria ,
				'sort'=>array(
					'defaultOrder'=>'t.Fecha DESC',				
				  )
		) );
	}
	public function searchFiltros() {
		$criteria = new CDbCriteria ();
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaCobro', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaCobro', '<=' . $this->fechaHasta, true );
		echo $this->fechaDesde;
		$criteria->order = ' t.id_cobro desc';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getFormasPago() {
		$formas = FormaPago::model ()->findAll ( ' 1=1 order by id_forma desc ' );
		return CHtml::listData ( $formas, "id_forma", "Nombre" );
	}
	public function getCobroFechaCuentaID($fecha, $idCuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = 'id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'FechaCobro', $fecha, $fecha );
		$results = CobroItem::model ()->findAll ( $criteria );
		$suma = 0;
		if ($results == null) {
			return 0.00;
		} else {
			foreach ( $results as $cob ) {
				$suma = $suma + $cob->Importe;
			}
		}
		return $suma;
	}
	
	
	public function getCobroCajaIDCuentaID($id_caja, $idCuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = 'id_cuenta=' . $idCuenta.' and caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'FechaCobro', $fecha, $fecha );
		$results = CobroItem::model ()->findAll ( $criteria );
		$suma = 0;
		if ($results == null) {
			return 0.00;
		} else {
			foreach ( $results as $cob ) {
				$suma = $suma + $cob->Importe;
			}
		}
		return $suma;
	}
	public function getTipoFactura() {
		$tiposComprobantes = TipoFactura::model ()->findAll ( array (
				// "condition"=>'visible=1',
				'order' => 'nombre' 
		) );
		return CHtml::listData ( $tiposComprobantes, "id_tipo_factura", "nombre" );
	}
	
	public function getUrlBorrarMovimiento() {
		$url = Yii::app ()->createUrl ( 'cobro/anularCobroItem', array (
			'id' => $this->id_cobro_item,
	) );
	return $url;
	}

	
	public function isAnulado(){
		return false;
	}
	public function afterFind() {
		$this->Importe= LGHelper::functions ()->formatNumber ($this->Importe);	
		$this->importe_anterior= LGHelper::functions ()->formatNumber ($this->importe_anterior);
		return parent::afterFind();
	}
	public function save() {
		$this->Importe= LGHelper::functions ()->unformatNumber ($this->Importe);
		$this->importe_anterior= LGHelper::functions ()->unformatNumber ($this->importe_anterior);
		return parent::save();
	}

	public function getExeptuaCierre() {
		return true;
	}
}
