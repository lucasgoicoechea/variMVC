<?php
class Presupuesto extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'presupuestos';
	}
	public function rules() {
		return array (
				array (
						'Fecha, Detalle, id_material',
						'required' 
				),
				array (
						'NumeroOrden, id_obra, id_proveedor, id_material, id_atencion_venta, id_empresa',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Cantidad',
						'length',
						'max' => 10 
				),
				array (
						'Detalle',
						'length',
						'max' => 154 
				),
				array (
						'id_presupuesto, NumeroOrden, Fecha, id_obra, id_proveedor, Cantidad, Detalle, id_material, id_atencion_venta, id_empresa',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'atencionVenta' => array (
						self::BELONGS_TO,
						'AtencionVenta',
						'id_atencion_venta' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'material' => array (
						self::BELONGS_TO,
						'Material',
						'id_material' 
				),
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				) ,
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
				'id_presupuesto' => Yii::t ( 'app', 'Id Presupuesto' ),
				'NumeroOrden' => Yii::t ( 'app', 'Numero Orden' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'Cantidad' => Yii::t ( 'app', 'Cantidad' ),
				'Detalle' => Yii::t ( 'app', 'Detalle' ),
				'id_material' => Yii::t ( 'app', 'Id Material' ),
				'id_atencion_venta' => Yii::t ( 'app', 'Id Atencion Venta' ),
				'id_empresa' => Yii::t ( 'app', 'Id Empresa' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_presupuesto', $this->id_presupuesto );
		
		$criteria->compare ( 'NumeroOrden', $this->NumeroOrden );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'Cantidad', $this->Cantidad, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->compare ( 'id_material', $this->id_material );
		
		$criteria->compare ( 'id_atencion_venta', $this->id_atencion_venta );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				 'pagination' => array (
						'pageSize' => 20 
				) 
		) );
	}
}
