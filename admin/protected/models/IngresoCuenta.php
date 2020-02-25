<?php
class IngresoCuenta extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'ingreso_cuenta';
	}
	public function rules() {
		return array (
				array (
						'fecha,  descripcion,id_obra',
						'required' 
				),
				array (
						'asentado,id_ingreso_cuenta, id_cuenta, id_forma_pago',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'importe',
						'numerical' 
				),
				array (
						'descripcion',
						'length',
						'max' => 250 
				),
				array (
						'id_ingreso_cuenta, fecha, id_cuenta, importe, id_forma_pago, descripcion,id_obra',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				
				'formaPago' => array (
						self::BELONGS_TO,
						'FormaPago',
						'id_forma_pago' 
				),
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta' 
				),
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
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
				'id_ingreso_cuenta' => Yii::t ( 'app', 'ID' ),
				'fecha' => Yii::t ( 'app', 'Fecha' ),
				'id_cuenta' => Yii::t ( 'app', 'Cuenta' ),
				'importe' => Yii::t ( 'app', 'Importe' ),
				'id_forma_pago' => Yii::t ( 'app', 'Forma Pago' ),
				'descripcion' => Yii::t ( 'app', 'Descripcion' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_ingreso_cuenta', $this->id_ingreso_cuenta );
		
		$criteria->compare ( 'fecha', $this->fecha, true );
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'importe', $this->importe );
		
		$criteria->compare ( 'id_forma_pago', $this->id_forma_pago );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function searchFechas($desde, $hasta) {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_ingreso_cuenta', $this->id_ingreso_cuenta );
		//$criteria->compare ( 'fecha', $this->fecha, true );
		if ($desde != null){
			$criteria->compare ( 't.fecha', '>=' . LGHelper::functions()->undisplayFecha($desde), true );
		}
		if ($hasta != null)
			$criteria->compare ( 't.fecha', '<=' . LGHelper::functions()->undisplayFecha($hasta), true );
		
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'importe', $this->importe );
		
		$criteria->compare ( 'id_forma_pago', $this->id_forma_pago );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getIngresoFechaCuentaID($fecha, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = '  id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'fecha', $fecha, $fecha );
		$ingCTA = IngresoCuenta::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $ingCTA ) > 0) {
			foreach ( $ingCTA as $ingreso ) {
				$result = $result + $ingreso->importe;
			}
		}
		return $result;
	}
	
	public function getIngresoCajaIDCuentaID($id_caja, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = '  id_cuenta=' . $idCuenta.' and caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha', $fecha, $fecha );
		$ingCTA = IngresoCuenta::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $ingCTA ) > 0) {
			foreach ( $ingCTA as $ingreso ) {
				$result = $result + $ingreso->importe;
			}
		}
		return $result;
	}
}
