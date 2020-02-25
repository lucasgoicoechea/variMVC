<?php
class AdministradoresAccesos extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'admin_acceso';
	}
	public function rules() {
		return array (
				array (
						'id_admin, id_acceso',
						'length',
						'max' => 20 
				),
				array (
						'id_admin, id_acceso',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'Administrador' => array (
						self::BELONGS_TO,
						'Administradores',
						'id_admin' 
				),
				'Acceso' => array (
						self::BELONGS_TO,
						'Accesos',
						'id_acceso' 
				) 
		)
		;
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
				'id_admin' => Yii::t ( 'app', 'Id Admin' ),
				'id_acceso' => Yii::t ( 'app', 'Id Acceso' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_admin', $this->id_admin, true );
		
		$criteria->compare ( 'id_acceso', $this->id_acceso, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function existeAccesoByUsersLoginID($id_acceso, $iduserslogin) {
		$administrador_id = UsersLogin::getAdministradorIDByUsersLoginID ( $iduserslogin );
		if ($administrador_id != null && $administrador_id != '') {
			$accesos = AdministradoresAccesos::model ()->findAll ( " id_admin=? AND id_acceso=? ", array (
					$administrador_id,
					$id_acceso 
			) );
			return $accesos != null && $accesos [0] != null;
		}
		return false;
	}

	public function validateAcceso($url){ //$url ej pago/create
		$administrador_id = Yii::app ()->getSession ()->get ( 'id_administrador' );
		$owner = Menu::model()->getIDByURL($url);
		//Yii::log ( "VALIDANDO ACCESO: menu:".$owner->label , CLogger::LEVEL_WARNING, 'PERMISOS' );
		//Yii::log ( "VALIDANDO ACCESO: id_admin:" .$administrador_id."-url:".$url , CLogger::LEVEL_WARNING, 'PERMISOS' );
		if ($owner != null && !AdministradoresAccesos::existeAccesoByAdminID ( $owner->id_acceso, $administrador_id )) {
			Yii::app()->getController()->redirect(array('site/accesoDenegado'));
		}
	}
	
	public static function existeAccesoByAdminID($id_acceso, $administrador_id ) {
		if ($administrador_id != null && $administrador_id != '') {
			$accesos = AdministradoresAccesos::model ()->findAll ( " id_admin=? AND id_acceso=? ", array (
					$administrador_id,
					$id_acceso
			) );
			return $accesos != null && $accesos [0] != null;
		}
		return false;
	}
}
