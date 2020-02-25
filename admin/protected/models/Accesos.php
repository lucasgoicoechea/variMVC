<?php
class Accesos extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'accesos';
	}
	public function rules() {
		return array (
				array (
						'orden',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'descripcion',
						'length',
						'max' => 45 
				),
				array (
						'id, descripcion, orden',
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
				'descripcion' => Yii::t ( 'app', 'Descripcion' ),
				'orden' => Yii::t ( 'app', 'Orden' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id, true );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		$criteria->compare ( 'orden', $this->orden );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
