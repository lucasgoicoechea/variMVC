<?php
class MigracionQuincenas extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'migracion_quincenas';
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
						'ID_OBRA, FECHA, ENCARGADO, ID_PROVEEDOR, PROVEEDOR, TIPO, NRO_FACTURA, DETALLE, CANTIDAD, SUBTOTAL, IVA, ALICUOTA, RETENCIONES, TOTAL, FECHA_COBRO, MONTO_PAGADO, FORMA_PAGO,NRO_CHEQUE, ID_CUENTA_BANCO, ID_CUENTA, M_PAGADO, CODIGO_SUBCONTRATO,MIGRADO',
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
