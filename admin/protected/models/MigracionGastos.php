<?php
class MigracionGastos extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'migracion_gastos';
	}
	public function rules() {
		return array (
				/*array (
						'Nombre, Medida, Fecha',
						'required' 
				),
				array (
						'Codigo, id_rubro, id_subrubro',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Nombre, Observaciones',
						'length',
						'max' => 100 
				),
				array (
						'Costo, Medida',
						'length',
						'max' => 10 
				),*/
				array (
						'id_obra, FECHA, ID_QUINCENAL, QUINCENAL, id_personal, NOMBRE, VALOR_CATEGORIA, DIAS_TRABAJADOS, FINAL, DESCUENTOS,MIGRADO',
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
