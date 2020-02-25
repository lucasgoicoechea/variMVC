<?php
class Cobro extends CActiveRecord {
	const ID_TIPO_FACTURA_NOTA_CREDITO = '3';
	public $fechaDesde = null;
	public $fechaHasta = null;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cobros';
	}
	public function rules() {
		return array (
				array (
						'Fecha, Indice, Importe,id_obra,id_cliente',
						'required' 
				),
				array (
						'Indice, id_cliente, id_obra, id_imputacion, id_forma,asentado',
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
				),*/
				array (
						'NumFactura',
						'length',
						'max' => 20 
				),
				array (
						'mes_iva, numero_op, expediente, numero_pedido_fondo',
						'length',
						'max' => 200 
				),
				array (
						'Detalles, id_cuenta_banco',
						'length',
						'max' => 200 
				),
				array (
						'id_cobro, Indice, id_cliente, id_obra, id_imputacion, id_forma, Importe, Fecha, FechaCobro, NumFactura, Detalles,cobrado, asentado,es_blanco,fechaDesFinde, fechaHasta,nro_cheque_certificado,id_tipo_factura',
						'safe' 
				)
				// 'on' => 'search'
				 
		);
	}
	public function relations() {
		return array (
				
				'cliente' => array (
						self::BELONGS_TO,
						'Cliente',
						'id_cliente' 
				),
				'imputacion' => array (
						self::BELONGS_TO,
						'Imputacion',
						'id_imputacion' 
				),
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
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
				),
				'tipoFactura' => array (
						self::BELONGS_TO,
						'TipoFactura',
						'id_tipo_factura' 
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
		$url = Yii::app ()->createUrl ( 'cobro/imprimirOrden', array (
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
				'nro_cheque_certificado' => Yii::t ( 'app', 'Nro. Cheque o Certificado' ),
				'FechaCobro' => Yii::t ( 'app', 'Fecha Cobro' ),
				'NumFactura' => Yii::t ( 'app', 'Nro. Factura' ),
				'Detalles' => Yii::t ( 'app', 'Detalles' ),
				'asentado' => Yii::t ( 'app', 'Cobro Asentado' ),
				'id_cuenta_banco' => Yii::t ( 'app', 'Cuenta Banco' ),
				'cobrado' => Yii::t ( 'app', 'Cobrado' ),
				'es_blanco' => Yii::t ( 'app', 'Ticket' ),
				'mes_iva' => Yii::t ( 'app', 'Mes IVA' ),
				'numero_op' => Yii::t ( 'app', 'Número OP' ),
				'numero_pedido_fondo' => Yii::t ( 'app', 'Pedido Fondo' ),
				'expediente' => Yii::t ( 'app', 'Expediente' ),
				'id_tipo_factura' => Yii::t ( 'app', 'Tipo Factura' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_cobro', $this->id_cobro );
		/*
		 * if ($this->Indice > 0)
		 * $criteria->compare ( 'Indice', $this->Indice );
		 */
		$criteria->compare ( 'id_cliente', $this->id_cliente );
		$criteria->compare ( 'id_obra', $this->id_obra );
		$criteria->compare ( 'id_imputacion', $this->id_imputacion );
		$criteria->compare ( 'id_forma', $this->id_forma );
		$criteria->compare ( 'Importe', $this->Importe, true );
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		$criteria->compare ( 'en_blanco', $this->en_blanco );
		$criteria->compare ( 'FechaCobro', $this->FechaCobro, true );
		$criteria->compare ( 'NumFactura', $this->NumFactura, true );
		$criteria->compare ( 'Detalles', $this->Detalles, true );
		$criteria->compare ( 'cobrado', $this->cobrado );
		$criteria->compare ( 'asentado', $this->asentado );
		if ($this->id_tipo_factura != null)
			$criteria->compare ( 'id_tipo_factura', $this->id_tipo_factura );
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
		$criteria->compare ( 'id_cliente', $this->id_cliente );
		$criteria->compare ( 'id_obra', $this->id_obra );
		$criteria->compare ( 'cobrado', $this->cobrado );
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->id_tipo_factura != null)
			$criteria->compare ( 'id_tipo_factura', $this->id_tipo_factura );
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
		$results = Cobro::model ()->findAll ( $criteria );
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
		$results = Cobro::model ()->findAll ( $criteria );
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
	public function validarExistaTipoNroFactura() {
		$criteria = new CDbCriteria ();
		$criteria->condition = 'id_tipo_factura=' . $this->id_tipo_factura . ' and NumFactura=' . $this->NumFactura;
		$results = Cobro::model ()->findAll ( $criteria );
		if ($results == null) {
			return true;
		} else {
			$this->addError ( 'NumFactura', 'ERROR ||  Ya existe registro de:  ' . $this->tipoFactura->nombre . ' - Nro. ' . $this->NumFactura );
		}
		return false;
	}
	public function getTotalCobrosMesAnio($anio, $mes, $tipofactura) {
		// facturas A y
		$fechaIni = $anio . '-' . $mes . '-01';
		$fechaFin = $anio . '-' . $mes . '-31';
		if ($mes < 10) {
			$fechaIni = $anio . '-0' . $mes . '-01';
			$fechaFin = $anio . '-0' . $mes . '-31';
		}
		$sql = "SELECT SUM(`Importe`) as total FROM `cobros` WHERE id_tipo_factura = " . $tipofactura . " and FechaCobro >= '" . $fechaIni . "' and FechaCobro <= '" . $fechaFin . "'";
		$total = Yii::app ()->db->createCommand ( $sql )->queryScalar ();
		return $total;
	}
	public function getTotalCobrado(){
		$sql = "SELECT SUM(Importe) as total FROM `cobro_items` WHERE id_cobro=".$this->id_cobro;
		$total = Yii::app ()->db->createCommand ( $sql )->queryScalar ();
		return $total + 0.00;
	}

	public function getPendienteCobro(){
		$cobrado = $this->getTotalCobrado();
		$importe = LGHelper::functions ()->unformatNumber($this->Importe);
		return $importe - $cobrado;
	}

	public function getFacturasPendientes($fecha) {
		$str = '';
		$criteria = new CDbCriteria ();
		$criteria->compare ( 't.FechaCobro', '<=' . $fecha, true );
		$criteria->compare ( 'cobrado', 0, true );
		$criteria->order = ' FechaCobro desc';
		$results = Cobro::model ()->findAll ( $criteria );
		if ($results != null) {
			foreach ( $results as $cobro ) {
				$str = $str . CHtml::link ( '' . $cobro->tipoFactura->nombre . ' - Nro. ' . $cobro->NumFactura . ' -- ', Yii::app ()->createUrl ( 'cobro/view', array (
						"id" => $cobro->id_cobro 
				) ), array (
						'title' => 'Facturas Pendientes de Cobro' 
				) );
			}
		}
		return $str;
	}
	public function getUrlAnulaFactura() {
		$url = Yii::app ()->createUrl ( 'cobro/anularFactura', array (
				'id' => $this->id_cobro,
		) );
		return $url;
	}
	public function isAnulado(){
		return false;
	}
public function anularFactura(){

	Yii::log('Error SAve NC:',CLogger::LEVEL_ERROR);
	    $notaCredito = new Cobro();
	    $notaCredito->Indice = $this->Indice;
	    $id_lead_last = Yii::app ()->db->createCommand ( "SELECT secuencia FROM `tipo_factura` WHERE id_tipo_factura=".Cobro::ID_TIPO_FACTURA_NOTA_CREDITO )->queryScalar ();
	    $id_lead_new = $id_lead_last + 1;
		$notaCredito->NumFactura = 'NC'.$id_lead_new;
	 	$notaCredito->Importe=    LGHelper::functions ()->unformatNumber($this->Importe) * (-1);
	 	$notaCredito->id_tipo_factura=    3;
	 	$notaCredito->id_cliente=    $this->id_cliente;
	 	$notaCredito->id_obra=    $this->id_obra;
	 	$notaCredito->id_cuenta=    $this->id_cuenta;
	 	$notaCredito->mes_iva=    $this->mes_iva;
	 	$notaCredito->id_imputacion=    $this->id_imputacion;
	 	$notaCredito->id_forma=    $this->id_forma;
	 	$notaCredito->Fecha=    $this->Fecha;
	 	$notaCredito->Detalles= 'Nota de Crédito que ANULA Factura '.$this->id_tipo_factura=1?'A ':'B '.', nro. '.$this->NumFactura;
	 	$notaCredito->numero_op=    $this->numero_op;
	 	$notaCredito->expediente=    $this->expediente;
	 	$notaCredito->numero_pedido_fondo=    $this->numero_pedido_fondo;
	 	$notaCredito->id_cuenta_banco=    $this->id_cuenta_banco;
	 	$notaCredito->es_blanco=    $this->es_blanco;
	 	$notaCredito->save();
	  	Yii::app ()->db->createCommand ( "UPDATE `tipo_factura` SET secuencia=".$id_lead_new." WHERE id_tipo_factura=".Cobro::ID_TIPO_FACTURA_NOTA_CREDITO )->execute ();
		return $notaCredito;
	}
	
	public function afterFind() {
		$this->Importe= LGHelper::functions ()->formatNumber ($this->Importe);
		return parent::afterFind();
	}
	public function save() {
		$this->Importe= LGHelper::functions ()->unformatNumber ($this->Importe);
		return parent::save();
	}

	public function getExeptuaCierre() {
		return true;
	}
}
