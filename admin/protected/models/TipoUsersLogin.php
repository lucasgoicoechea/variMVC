<?php
class TipoUsersLogin extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'tipo_userslogin';
	}
	public function rules() {
		return array (
				array (
						'id, descripcion',
						'required' 
				),
				array (
						'id',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'descripcion',
						'length',
						'max' => 50 
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
		
		$criteria->compare ( 'id', $this->id );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
