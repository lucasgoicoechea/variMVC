<?php
class UsersLoginActivacionNewPass extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'userslogin_activacion_pass';
	}
	public function rules() {
		return array (
				array (
						'username,id_userslogin, tipo_userslogin, codigo_activacion',
						'required' 
				),
				array (
						'username,id_userslogin',
						'length',
						'max' => 20 
				),
				array (
						'tipo_userslogin',
						'length',
						'max' => 4 
				),
				array (
						'codigo_activacion',
						'length',
						'max' => 200 
				),
				array (
						'id_userslogin, tipo_userslogin, codigo_activacion',
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
				'id_userslogin' => Yii::t ( 'app', 'Id Userslogin' ),
				'tipo_userslogin' => Yii::t ( 'app', 'Tipo Userslogin' ),
				'codigo_activacion' => Yii::t ( 'app', 'Codigo Activacion' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id, true );
		
		$criteria->compare ( 'id_userslogin', $this->id_userslogin, true );
		
		$criteria->compare ( 'tipo_userslogin', $this->tipo_userslogin, true );
		
		$criteria->compare ( 'codigo_activacion', $this->codigo_activacion, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	
	public function getByCodigoActivation($codigo){
		return UsersLoginActivacionNewPass::find('codigo="'.$codigo.'"');
		
	}
}
