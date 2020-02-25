<?php
class TipoAdministradores extends CActiveRecord {
	const TIPO_ADMINISTRADOR = 1;
	public $publico;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'tipo_admin';
	}
	public function rules() {
		return array (
				array (
						'id',
						'length',
						'max' => 20 
				),
				array (
						'descripcion',
						'length',
						'max' => 45 
				),
				array (
						'id, descripcion,publico',
						'safe',
						//'on' => 'search' 
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
				'descripcion' => Yii::t ( 'app', 'Descripcion' ) ,
				'publico' => 'PUBLICO'
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
	public function isEditaPerfiles() {
		return $this->id == TipoAdministradores::TIPO_ADMINISTRADOR;
	}
}
