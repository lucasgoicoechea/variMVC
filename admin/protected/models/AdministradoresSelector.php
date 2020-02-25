<?php
class AdministradoresSelector extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'admin_selector';
	}
	public function rules() {
		return array (
				array (
						'id_usuario',
						'required' 
				),
				array (
						'dni, id_usuario',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'apellido, nombre',
						'length',
						'max' => 100 
				),
				array (
						'descripcion',
						'length',
						'max' => 200 
				),
				array (
						'id_admin_selector, apellido, nombre, dni, descripcion, id_usuario',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function getId() {
		return $this->id_admin_selector;
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
				'id_admin_selector' => Yii::t ( 'app', 'Id Admin Selector' ),
				'apellido' => Yii::t ( 'app', 'Apellido' ),
				'nombre' => Yii::t ( 'app', 'Nombre' ),
				'dni' => Yii::t ( 'app', 'Dni' ),
				'descripcion' => Yii::t ( 'app', 'Descripcion' ),
				'id_usuario' => Yii::t ( 'app', 'Id Usuario' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_admin_selector', $this->id_admin_selector );
		
		$criteria->compare ( 'apellido', $this->apellido, true );
		
		$criteria->compare ( 'nombre', $this->nombre, true );
		
		$criteria->compare ( 'dni', $this->dni );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		$criteria->compare ( 'id_usuario', $this->id_usuario );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
