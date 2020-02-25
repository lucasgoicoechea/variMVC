<?php
class MigracionQuincena extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'MIGRACION_QUINCENAS';
	}
	public function rules() {
		return array (
					array (
						'id_migracion_quincena,id_obra, FECHA, ID_QUINCENAL, QUINCENAL, id_personal, NOMBRE, VALOR_CATEGORIA, DIAS_TRABAJADOS, FINAL, DESCUENTOS,ADELANTOS,FECHA_COBRO,MONTO_PAGADO,
						FORMA_PAGO,NRO_CHEQUE,ID_CUENTA_BANCO,ID_CUENTA,M_PAGADO,MIGRADO',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
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
				 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
