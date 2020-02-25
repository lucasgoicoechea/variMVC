<?php
class CuentaBanco extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cuentasbancos';
	}
	public function rules() {
		return array (
				array (
						'nombre, numero_cuenta, id_empresa',
						'required' 
				),
				array (
						'codigo, id_empresa',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'nombre, numero_cuenta',
						'length',
						'max' => 60 
				),
				array (
						'id_cuenta_banco, codigo, nombre, numero_cuenta, id_empresa',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cheques' => array (
						self::HAS_MANY,
						'Cheque',
						'id_cuenta_banco' 
				),
				'controlcheques' => array (
						self::HAS_MANY,
						'ControlCheque',
						'id_cuenta_banco' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'recuperacheques' => array (
						self::HAS_MANY,
						'RecuperaCheque',
						'id_cuenta_banco' 
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
				'id_cuenta_banco' => Yii::t ( 'app', 'Id Cuenta Banco' ),
				'codigo' => Yii::t ( 'app', 'Codigo' ),
				'nombre' => Yii::t ( 'app', 'Nombre' ),
				'numero_cuenta' => Yii::t ( 'app', 'Numero Cuenta' ),
				'id_empresa' => Yii::t ( 'app', 'Empresa' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		
		$criteria->compare ( 'codigo', $this->codigo );
		
		$criteria->compare ( 'nombre', $this->nombre, true );
		
		$criteria->compare ( 'numero_cuenta', $this->numero_cuenta, true );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	
	public function getDescripcion(){
		return $this->codigo.' - '.$this->numero_cuenta.' :: '.$this->nombre;
	}
}
