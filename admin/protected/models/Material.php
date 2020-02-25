<?php
class Material extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'materiales';
	}
	public function rules() {
		return array (
				array (
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
				),
				array (
						'id_material, Codigo, Nombre, Costo, id_rubro, id_subrubro, Observaciones, Medida, Fecha',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'rubro' => array (
						self::BELONGS_TO,
						'Rubro',
						'id_rubro' 
				),
				'subrubro' => array (
						self::BELONGS_TO,
						'SubRubro',
						'id_subrubro' 
				),
				'ordenesCompras' => array (
						self::HAS_MANY,
						'OrdenCompra',
						'id_material' 
				),
				'presupuestos' => array (
						self::HAS_MANY,
						'Presupuesto',
						'id_material' 
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
				'id_material' => Yii::t ( 'app', 'Id Material' ),
				'Codigo' => Yii::t ( 'app', 'Codigo' ),
				'Nombre' => Yii::t ( 'app', 'Nombre' ),
				'Costo' => Yii::t ( 'app', 'Costo' ),
				'id_rubro' => Yii::t ( 'app', 'Id Rubro' ),
				'id_subrubro' => Yii::t ( 'app', 'Id Subrubro' ),
				'Observaciones' => Yii::t ( 'app', 'Observaciones' ),
				'Medida' => Yii::t ( 'app', 'Medida' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_material', $this->id_material );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		
		$criteria->compare ( 'Costo', $this->Costo, true );
		
		$criteria->compare ( 'id_rubro', $this->id_rubro );
		
		$criteria->compare ( 'id_subrubro', $this->id_subrubro );
		
		$criteria->compare ( 'Observaciones', $this->Observaciones, true );
		
		$criteria->compare ( 'Medida', $this->Medida, true );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}

	public function getDescripcionShort(){
		return $this->Codigo.'-'.$this->Nombre;
	}
}
