<?php
class Caja extends CActiveRecord {
	public $fechaDesde = null;
	public $fechaHasta = null;
	public $id_obra = null;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'caja';
	}
	public function rules() {
		return array (
				array (
						'cerrada',
						'required' 
				),
				array (
						'codigo, id_cuenta, cerrada',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'numero',
						'length',
						'max' => 40 
				),
				array (
						'importe',
						'length',
						'max' => 12 
				),
				array (
						'fecha',
						'safe' 
				),
				array (
						'id_caja, codigo, fecha, numero, importe, id_cuenta, cerrada,fechaDesde, fechaHasta,id_obra',
						'safe' 
				)
				// 'on' => 'search'
				 
		);
	}
	public function relations() {
		return array (
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta' 
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
	public function existeCaja($fechaCaja) {
		$criteria = new CDbCriteria ();
		$criteria->addBetweenCondition ( 'fecha', $fechaCaja, $fechaCaja );
		$results = Caja::model ()->find ( $criteria );
		if ($results == null) {
			return false;
		}
		return true;
	}
	public function getPorFecha($fechaCaja) {
		$criteria = new CDbCriteria ();
		// $criteria->condition = ' fecha=' . $fechaCaja;
		$criteria->addBetweenCondition ( 'fecha', $fechaCaja, $fechaCaja );
		$results = Caja::model ()->find ( $criteria );
		// Yii::log ( "Buscando Caja para la fecha:" . $fechaCaja, CLogger::LEVEL_WARNING, 'CierreDiario' );
		if ($results == null) {
			Caja::model ()->abrirCaja ( $fechaCaja );
			return Caja::model ()->getPorFecha ( $fechaCaja );
		}
		return $results;
	}
	public function getPorFechaOrNull($fechaCaja) {
		$criteria = new CDbCriteria ();
		// $criteria->condition = ' fecha=' . $fechaCaja;
		$criteria->addBetweenCondition ( 'fecha', $fechaCaja, $fechaCaja );
		$results = Caja::model ()->find ( $criteria );
		// Yii::log ( "Buscando Caja para la fecha:" . $fechaCaja, CLogger::LEVEL_WARNING, 'CierreDiario' );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	public function getByID($idCaja) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_caja=' . $idCaja;
		$results = Caja::model ()->find ( $criteria );
		if ($results == null) {
			return new Caja ();
		}
		return $results;
	}
	public function getUltimaCaja() {
		$criteria = new CDbCriteria ();
		// $criteria->condition = ' id_caja<' . $idCaja;
		$criteria->order = ' id_caja desc';
		$results = Caja::model ()->find ( $criteria );
		if ($results == null) {
			return new Caja ();
		}
		return $results;
	}
	
	public function  cerrarCajaYNoAbrir($caja){
		Caja::model ()->updateByPk ( $caja->id_caja, array (
				"cerrada" => 1
		) );
		$cajaAnt = Caja::model ()->getCajaAnterior ( $caja);
		CuentaSaldosAcumulado::model ()->calcularSaldosAcumulados ( $cajaAnt, $caja->id_caja, $caja );
	}
	
	public function generarCajas($hastaFecha){
		$caja = Caja::model ()->getUltimaCaja ();
		$fechaInicio=strtotime($caja->fecha);
		$fechaFin=strtotime($hastaFecha);
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
			echo $caja->fecha."-";
			$caja = Caja::abrirCajaFecha( $caja , date("Y-m-d", $i) );
			echo $caja->fecha."<br>";
		}
	}
	
	public function getCajaAbierta($fechaCaja) {
		// sino esta abierta la abre
		$caja = Caja::model ()->getUltimaCaja ();
		if ($caja->id_caja != null) {
			//if (LGHelper::functions()->compararFechas($caja->fecha, $fechaCaja) != 0) {
			$prim =  $caja->fecha;
			$seg = $fechaCaja;
			if ($prim != $seg){
				Yii::log("Ultima caja:".$caja->fecha.'-'.$fechaCaja, CLogger::LEVEL_WARNING, 'CAJA');
				if ($caja->cerrada) {
					$caja = Caja::abrirCajaID( $caja );
				}	
			}
		} else {
			$caja = Caja::abrirCaja ( $fechaCaja );
		}
		return $caja;
	}
	public function getCajaAnteriorPorFecha($fecha) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 't.fecha', '<' . $fecha, true );
		$criteria->order = ' fecha desc';
		$results = Caja::model ()->find ( $criteria );
		if ($results == null) {
			return new Caja ();
		}
		return $results;
	}
	public function getCajaAnterior($caja) {
		$caja = Caja::model ()->getByID ( $caja->id_caja_anterior );
		/*
		 * $criteria = new CDbCriteria ();
		 * $criteria->compare ( 't.fecha', '<' . $caja->fecha, true );
		 * $criteria->order = ' fecha desc';
		 * $results = Caja::model ()->find ( $criteria );
		 * if ($results == null) {
		 * return new Caja ();
		 * }
		 * return $results;
		 */
		return $caja;
	}
	public function attributeLabels() {
		return array (
				'id_caja' => Yii::t ( 'app', 'Id Caja' ),
				'codigo' => Yii::t ( 'app', 'Codigo' ),
				'fecha' => Yii::t ( 'app', 'Fecha' ),
				'numero' => Yii::t ( 'app', 'Numero' ),
				'importe' => Yii::t ( 'app', 'Importe' ),
				'id_cuenta' => Yii::t ( 'app', 'Id Cuenta' ),
				'cerrada' => Yii::t ( 'app', 'Cerrada' ) 
		);
	}
	public function deshacerUltimoCierre() {
		$caja = Caja::getUltimaCaja ();
		if ($caja->cerrada) {
			// cambio a abierta
			// borro los acumulados
			Caja::model ()->updateByPk ( $caja->id_caja, array (
					"cerrada" => 0 
			) );
			//CuentaSaldosAcumulado::borrarCuentaSaldosAcumulados ( $caja->id_caja );
		}
	}
	public function abrirCaja($fechaCaja) {
		// echo "EXISTE CAJA";
		if (! Caja::model ()->existeCaja ( $fechaCaja )) {
			$caja = new Caja ();
			$caja->fecha = $fechaCaja;
			$caja->id_cuenta = Empresas::model ()->getIDCuentaEfectivoOCajaChica ();
			// cantado que codigo es id_cuenta
			$caja->codigo = Caja::model ()->getUltimoCodigo ();
			// el nro es verdaderamenteel Codigo, ya que podes tener
			// muchas veces la misma fecha, cada una por diferente Cuenta
			// ppero para darle orden y notoriedad se le asigna un numero
			// q podria ser el ID
			$caja->numero = Caja::model ()->getUltimoNumero ();
			$caja->cerrada = 0;
			$cjAnt = Caja::model ()->getCajaAnteriorPorFecha ( $caja->fecha );
			$caja->id_caja_anterior = $cjAnt->id_caja;
			$errors = $caja->guardar ();
			if (! $errors) {
				// echo print_r($caja->getErrors());
				// Yii::app()->end();
				return true;
			} else
				return false;
		}
		return false;
	}
	public function abrirCajaID($cajaAnt) {
		// echo "EXISTE CAJA";
			$caja = new Caja ();
			$caja->fecha = CTimestamp::formatDate ( 'Y-m-d ' ) ;
			$caja->id_cuenta = Empresas::model ()->getIDCuentaEfectivoOCajaChica ();
			// cantado que codigo es id_cuenta
			$caja->codigo = Caja::model ()->getUltimoCodigo ();
			// el nro es verdaderamenteel Codigo, ya que podes tener
			// muchas veces la misma fecha, cada una por diferente Cuenta
			// ppero para darle orden y notoriedad se le asigna un numero
			// q podria ser el ID
			$caja->numero = Caja::model ()->getUltimoNumero ();
			$caja->cerrada = 0;
			$caja->id_caja_anterior = $cajaAnt->id_caja;
			$errors = $caja->guardar ();
			if (! $errors) {
				$ultCaja = Caja::getUltimaCaja();
				return $ultCaja;
			} else
				return false;
	}
	

	public function abrirCajaFecha($cajaAnt,$fecha) {
		// echo "EXISTE CAJA";
		$caja = new Caja ();
		$caja->fecha = $fecha;
		$caja->id_cuenta = Empresas::model ()->getIDCuentaEfectivoOCajaChica ();
		// cantado que codigo es id_cuenta
		$caja->codigo = Caja::model ()->getUltimoCodigo ();
		// el nro es verdaderamenteel Codigo, ya que podes tener
		// muchas veces la misma fecha, cada una por diferente Cuenta
		// ppero para darle orden y notoriedad se le asigna un numero
		// q podria ser el ID
		$caja->numero = Caja::model ()->getUltimoNumero ();
		$caja->cerrada = 0;
		$caja->id_caja_anterior = $cajaAnt->id_caja;
		$errors = $caja->guardar ();
		if (! $errors) {
			$ultCaja = Caja::getUltimaCaja();
			return $ultCaja;
		} else
			return false;
	}
	public function guardar() {
		$sql = "insert into caja (fecha,codigo,id_cuenta,numero, cerrada, id_caja_anterior) 
				values (:fecha_param,:codigo_param,:idcuenta_param,:numero_param,:cerrada_param,:caja_anterior)";
		$parameters = array (
				":fecha_param" => $this->fecha,
				":codigo_param" => $this->codigo,
				":idcuenta_param" => $this->id_cuenta,
				":numero_param" => $this->numero,
				":cerrada_param" => $this->cerrada ,
				":caja_anterior" => $this->id_caja_anterior
		);
		Yii::app ()->db->createCommand ( $sql )->execute ( $parameters );
	}
	public function getUltimoCodigo() {
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_caja`) as `max` FROM `caja` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		return $id_lead_new;
	}
	public function getUltimoNumero() {
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_caja`) as `max` FROM `caja` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		return $id_lead_new;
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_caja', $this->id_caja );
		
		$criteria->compare ( 'codigo', $this->codigo );
		
		$criteria->compare ( 'fecha', $this->fecha, true );
		
		$criteria->compare ( 'numero', $this->numero, true );
		
		$criteria->compare ( 'importe', $this->importe, true );
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'cerrada', $this->cerrada );
		
		$this->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->fechaDesde );
		$this->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->fechaHasta );
		if ($this->fechaDesde != null)
			$criteria->compare ( 't.FechaFactura', '>=' . $this->fechaDesde, true );
		if ($this->fechaHasta != null)
			$criteria->compare ( 't.FechaFactura', '<=' . $this->fechaHasta, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getAnterioresPendientes() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 't.fecha', '<' . $this->fecha, true );
		$criteria->compare ( 'cerrada', 0, true );
		$criteria->order = ' fecha ';
		$results = Caja::model ()->findAll ( $criteria );
		return $results;
	}
	public function cajasAnterioresPendientes() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 't.fecha', '<' . $this->fecha, true );
		$criteria->compare ( 'cerrada', 0, true );
		$criteria->order = ' fecha desc';
		$results = Caja::model ()->findAll ( $criteria );
		if ($results != null) {
			$str = '';
			foreach ( $results as $caja ) {
				$str = $str . CHtml::link ( '<' . $caja->fecha . '>', Yii::app ()->createUrl ( 'caja/cierreDiariosCajaLink', array (
						"idCaja" => $caja->id_caja 
				) ), array (
						'title' => 'Cerrar Caja Diaria',
						'target' => '_blank' 
				) );
			}
			$results = $str;
		} else
			return '';
		return $results;
	}
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'caja/imprimirCierreDiario', array (
				'id_caja' => $this->id_caja 
		) );
		return $url;
	}
	public function getUrlImprimirFechas() {
		$url = Yii::app ()->createAbsoluteUrl ( 'caja/imprimirCierreDiarioFechas', array (
				'fechaDesde' => $this->fechaDesde,
				'fechaHasta' => $this->fechaHasta,
				'id_obra' => $this->id_obra 
		) );
		return $url;
	}
	public function facturasPendientes() {
		return Cobro::model ()->getFacturasPendientes ( $this->fecha );
	}
}
