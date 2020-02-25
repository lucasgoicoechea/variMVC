<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
  * @property string $birthday
 * @property string $name
 * @property integer $countries_id
 * @property integer $cities_id
 * @property integer $status
 */
class UsersLogin extends CActiveRecord {
	const ROLE_SUPER_USUARIO = 'super';
	const ROLE_USUARIO = 'usuario';
	const ROLE_ADMINISTRADOR = 'admin';
	const ROLE_EMPRESA = 'empresa';
	const ROLE_USUARIO_LOGUEADO = '@';
	const ROLE_USUARIO_TODOS = '*';
	
	// public id_tipo_userslogin
	// public $countries_id=1;
	public $status = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return Users the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'userslogin';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'username, password,  status',
						'required' 
				),
				array (
						' status',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'username, password',
						'length',
						'max' => 128 
				),
				// array('name', 'length', 'max'=>255),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array (
						'id, username, password, status',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array ();
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'username' => 'Username',
				'password' => 'Password',
				// 'name' => 'Name',
				'status' => 'Status' 
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * 
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id );
		$criteria->compare ( 'username', $this->username, true );
		$criteria->compare ( 'password', $this->password, true );
		/* $criteria->compare('name',$this->name,true); */
		$criteria->compare ( 'status', $this->status );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	public function getMenuCountries() {
		$countries = Countries::model ()->findAll ( "status=?", array (
				1 
		) );
		return CHtml::listData ( $countries, "id", "selectName" );
	}
	public function getMenuCities($defaultCountry = 1) {
		$cities = Cities::model ()->findAll ( "status=? AND countries_id=?", array (
				1,
				$defaultCountry 
		) );
		return CHtml::listData ( $cities, "id", "name" );
	}
	
	
	public function getEmpresasContactoByUsersLoginID($idUsersLogin) {
		$usuarios = Empresas::model ()->findAll ( " id_userslogin=?", array (
				$idUsersLogin 
		) );
		return isset ( $usuarios [0] ) ? $usuarios [0]->nombre . ' ' . $usuarios [0]->apellido . ' (' . $usuarios [0]->nombrecomercial . ')' : '';
	}
	public function getEmpresaByUsersLoginID($idUsersLogin) {
		$usuarios = Empresas::model ()->findAll ( " id_userslogin=?", array (
				$idUsersLogin 
		) );
		return isset ( $usuarios [0] ) ? $usuarios [0] : null;
	}
	public static function getTipoUsersLoginDescripcion($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return 'DESCONOCIDO';
		$tipoUsersLogin = TipoUsersLogin::model ()->findAll ( " id=? ", array (
				$_usersLogin->id_tipo_userslogin 
		) );
		return isset ( $tipoUsersLogin [0] ) ? $tipoUsersLogin [0]->descripcion : 'DESCONOCIDO';
	}
	public function isUsuario($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return false;
		return $_usersLogin->id_tipo_userslogin == 1;
	}
	public function isProfesional($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return false;
		return $_usersLogin->id_tipo_userslogin ==2;
	}
	public function isEmpresa($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return false;
		return $_usersLogin->id_tipo_userslogin == 3;
	}
	public static function isAdministrador($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return false;
		return $_usersLogin->id_tipo_userslogin == Administradores::TIPO_USERS;
	}
	public function existeAdministrador($usuario) {
		$_usersLogin = UsersLogin::model ()->find ( 'username="' . $usuario . '" and id_tipo_userslogin=' . Administradores::TIPO_USERS );
		if ($_usersLogin == null)
			return false;
		return true;
	}
	public function existeProfesional($usuario) {
		$_usersLogin = UsersLogin::model ()->find ( 'username="' . $usuario . '" and id_tipo_userslogin=' . 2);
		if ($_usersLogin == null)
			return false;
		return true;
	}
	public function getUserName($idUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findByPK ( $idUsersLogin );
		if ($_usersLogin == null)
			return '';
		return $_usersLogin->username;
	}
	public function existeUsersLoginByTipo($nameUsersLogin, $tipoUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findAll ( " username='" . $nameUsersLogin . "' and id_tipo_userslogin=" . $tipoUsersLogin );
		return $_usersLogin != null && $_usersLogin [0] != null;
	}
	public function getUsersLoginIDbyUserName($nameUsersLogin, $tipoUsersLogin) {
		$_usersLogin = UsersLogin::model ()->findAll ( " username='" . $nameUsersLogin . "' and id_tipo_userslogin=" . $tipoUsersLogin );
		if ($_usersLogin != null && $_usersLogin [0] != null)
			return $_usersLogin [0]->id;
		return null;
	}
	public function createNonPersistentModel($usuario, $password, $tipoUsuario) {
		$model = new UsersLogin ();
		if (isset ( $usuario ) && isset ( $password )) {
			$password = md5 ( $password );
			$model->password = $password;
			$model->username = $usuario;
			$model->id_tipo_userslogin = $tipoUsuario;
			$model->status = 1;
			if ($model->save ()) {
				return $model;
			} else
				'';
		}
		return false;
	}
	public function createNonPersistentModelConMD5PorParam($usuario, $password, $tipoUsuario) {
		$model = new UsersLogin ();
		if (isset ( $usuario )) {
			//$password = md5 ( $password );
			if (!isset ( $password )) {
				$password = md5('1234');
			}
			$model->password = $password;
			$model->username = $usuario;
			$model->id_tipo_userslogin = $tipoUsuario;
			$model->status = 1;
			if ($model->save ()) {
				return $model;
			} else {
				echo 'fallo el save de userslogin:<br>';
			   echo '--> ERRORES:';
			   echo CHtml::errorSummary($model).'<br>';
			}
		}
		else {echo 'usuario no seteado<br>';}
		return false;
	}
	public function cambiarPass($id, $passwordSinMD5) {
		$userslogin = UsersLogin::model ()->findByPK ( $id );
		$password = md5 ( $passwordSinMD5 );
		$userslogin->password = $password;
		if ($userslogin->save ()) {
			return true;
		} else
			false;
	}
	public function login($passwordSinMD5) {
		$loginForm = new LoginForm ();
		$loginForm->username = $this->username;
		$loginForm->password = $passwordSinMD5;
		$loginForm->tipoUsersLogin = $this->id_tipo_userslogin;
		$result = $loginForm->login ();
		// echo $result;
		return $result;
	}
	public function assingRole($nameRole, $idUser) {
		Yii::app ()->authManager->assign ( $nameRole, $idUser );
	}
	
	public static function getAdministradorIDByUsersLoginID($idUsersLogin) {
		$usuarios = Administradores::model ()->findAll ( " id_userslogin=?", array (
				$idUsersLogin 
		) );
		//echo isset ( $usuarios [0] );
		//Yii::app()->end();
		return isset ( $usuarios [0] ) ? $usuarios [0]->id : '';
	}
	
	public static function getAdministradorByUsersLoginID($idUsersLogin) {
		$usuarios = Administradores::model ()->findAll ( " id_userslogin=?", array (
				$idUsersLogin 
		) );
		return isset ( $usuarios [0] ) ? $usuarios [0] : null;
	}
	public static function getAdministradorUserNameByUsersLoginID($idUsersLogin) {
		if (isset ( $idUsersLogin )) {
			$usuarios = Administradores::model ()->findAll ( " id_userslogin=?", array (
					$idUsersLogin 
			) );
			return isset ( $usuarios [0] ) ? $usuarios [0]->usuario : 'SIN ACCESO';
		}
		return '';
	}

	public static function isMiguelAlba($iduserlogin) {
		//id=19164
		return 19164==$iduserlogin;
	}
	/*public function getNombreApellidoAdmin(){
	   $usuario = UsersLogin::getAdministradorByUsersLoginID($this->id);
	   return  $usuario->nombre.'  '.$usuario->apellido;
	}*/
}