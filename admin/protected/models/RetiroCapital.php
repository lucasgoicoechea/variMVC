<?php
class RetiroCapital extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'retirocapital';
	}
	public function rules() {
		return array (
				array (
						'Fecha,  descripcion',
						'required' 
				),
				array (
						'id_retirocapital, id_cuenta, id_forma_pago, id_gasto',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'asentado,Importe',
						'numerical' 
				),
				array (
						'descripcion',
						'length',
						'max' => 250 
				),
				array (
						'id_retirocapital, Fecha, id_cuenta, Importe, id_forma_pago, id_gasto, descripcion',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'gasto' => array (
						self::BELONGS_TO,
						'Gasto',
						'id_gasto' 
				),
				'formaPago' => array (
						self::BELONGS_TO,
						'FormaPago',
						'id_forma_pago' 
				),
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
	public function attributeLabels() {
		return array (
				'id_retirocapital' => Yii::t ( 'app', 'Id Retirocapital' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'id_cuenta' => Yii::t ( 'app', 'Id Cuenta' ),
				'Importe' => Yii::t ( 'app', 'Importe' ),
				'id_forma_pago' => Yii::t ( 'app', 'Id Forma Pago' ),
				'id_gasto' => Yii::t ( 'app', 'Id Gasto' ),
				'descripcion' => Yii::t ( 'app', 'Descripcion' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_retirocapital', $this->id_retirocapital );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'Importe', $this->Importe );
		
		$criteria->compare ( 'id_forma_pago', $this->id_forma_pago );
		
		$criteria->compare ( 'id_gasto', $this->id_gasto );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getRetiroCapitalFechaCuentaID($fecha, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = '  id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'Fecha', $fecha, $fecha );
		$ingCTA = RetiroCapital::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $ingCTA ) > 0) {
			foreach ( $ingCTA as $ingreso ) {
				$result = $result + $ingreso->Importe;
			}
		}
		return $result;
	}
	
	public function getRetiroCapitalCajaIDCuentaID($id_caja, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = '  id_cuenta=' . $idCuenta.' and caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'Fecha', $fecha, $fecha );
		$ingCTA = RetiroCapital::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $ingCTA ) > 0) {
			foreach ( $ingCTA as $ingreso ) {
				$result = $result + $ingreso->Importe;
			}
		}
		return $result;
	}
	
}
