<?php
class Recibo extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'recibos';
	}
	public function rules() {
		return array (
				array (
						'fecha, id_obra, id_empresa',
						'required' 
				),
				array (
						'id_contrato_cabecera, id_proveedor, id_obra, id_empresa, impreso',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Importe',
						'length',
						'max' => 10 
				),
				array (
						'Detalle',
						'length',
						'max' => 510 
				),
				array (
						'id_contrato_cabecera, fecha, Importe, Detalle, id_proveedor, id_obra, id_recibo, id_empresa, impreso',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'contratoCabecera' => array (
						self::BELONGS_TO,
						'ContratoCabecera',
						'id_contrato_cabecera' 
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
				'id_contrato_cabecera' => Yii::t ( 'app', 'Id Contrato' ),
				'fecha' => Yii::t ( 'app', 'Fecha' ),
				'Importe' => Yii::t ( 'app', 'Importe' ),
				'Detalle' => Yii::t ( 'app', 'Detalle' ),
				'id_proveedor' => Yii::t ( 'app', 'Id Proveedor' ),
				'id_obra' => Yii::t ( 'app', 'Id Obra' ),
				'id_recibo' => Yii::t ( 'app', 'Id Recibo' ),
				'id_empresa' => Yii::t ( 'app', 'Id Empresa' ),
				'impreso' => Yii::t ( 'app', 'Impreso' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_contrato_cabecera', $this->id_contrato_cabecera );
		
		$criteria->compare ( 'fecha', $this->fecha, true );
		
		$criteria->compare ( 'Importe', $this->Importe, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_recibo', $this->id_recibo );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		
		$criteria->compare ( 'impreso', $this->impreso );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
