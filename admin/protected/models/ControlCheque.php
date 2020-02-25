<?php
class ControlCheque extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'controlcheques';
	}
	public function rules() {
		return array (
				array (
						'id_cheque, id_cuenta_banco, Fecha, Hora',
						'required' 
				),
				array (
						'id_cheque, id_cuenta_banco',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'id_control_cheque, id_cheque, id_cuenta_banco, Fecha, Hora',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cheque' => array (
						self::BELONGS_TO,
						'Cheque',
						'id_cheque' 
				),
				'cuentaBanco' => array (
						self::BELONGS_TO,
						'CuentaBanco',
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
				'id_control_cheque' => Yii::t ( 'app', 'Id Control Cheque' ),
				'id_cheque' => Yii::t ( 'app', 'Id Cheque' ),
				'id_cuenta_banco' => Yii::t ( 'app', 'Id Cuenta Banco' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'Hora' => Yii::t ( 'app', 'Hora' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_control_cheque', $this->id_control_cheque );
		
		$criteria->compare ( 'id_cheque', $this->id_cheque );
		
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		$criteria->compare ( 'Hora', $this->Hora, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
