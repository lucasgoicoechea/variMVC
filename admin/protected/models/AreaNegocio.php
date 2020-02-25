<?php
class AreaNegocio extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'area_negocio';
	}
	public function rules() {
		return array (
				array (
						'descripcion',
						'length',
						'max' => 45 
				),
				array (
						'id, descripcion',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array ();
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
				'id' => Yii::t ( 'app', 'ID' ),
				'descripcion' => Yii::t ( 'app', 'Descripcion' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id, true );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
