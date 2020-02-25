<?php
class Administradores extends CActiveRecord {
	const TIPO_USERS = 4;
	public $accesos_IDs = array ();
	public $accesos_DESCs = array ();
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'admin';
	}
	public function rules() {
		return array (
				array (
						'nombre, apellido, usuario, clave',
						'required' 
				),
				array (
						'verEntrevista',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'usuario, clave, idTipo',
						'length',
						'max' => 20 
				),
				array (
						'nombre, apellido',
						'length',
						'max' => 35 
				),
				array (
						'tipoAdmin,id, usuario, clave, nombre, apellido, idTipo, verEntrevista, id_userslogin',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'usersLogin' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'id_userslogin' 
				),
				'tipoAdmin' => array (
						self::BELONGS_TO,
						'TipoAdministradores',
						'idTipo' 
				),
				'accesos' => array (
						self::MANY_MANY,
						'Accesos',
						'admin_acceso(id_admin, id_acceso)' 
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
				'id' => Yii::t ( 'app', 'ID' ),
				'usuario' => Yii::t ( 'app', 'Usuario' ),
				'clave' => Yii::t ( 'app', 'Clave' ),
				'nombre' => Yii::t ( 'app', 'Nombre' ),
				'apellido' => Yii::t ( 'app', 'Apellido' ),
				'idTipo' => Yii::t ( 'app', 'Tipo' ),
				'verEntrevista' => Yii::t ( 'app', 'Ver Entrevista' ),
				'id_userslogin' => Yii::t ( 'app', 'Id Userslogin' ) 
		);
	}
	public function search() {
		$this->verEntrevista = null;
		$this->id_userslogin = null;
		$this->clave = null;
		// $idtipotmp=$this->idTipo;
		// $this->idTipo = null;
		
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id );
		
		$criteria->compare ( 'usuario', $this->usuario, true );
		
		$criteria->compare ( 'clave', $this->clave, true );
		
		$criteria->compare ( 'nombre', $this->nombre, true );
		
		$criteria->compare ( 'apellido', $this->apellido, true );
		
		$criteria->compare ( 'idTipo', $this->idTipo, true );
		// $this->idTipo = $idtipotmp;
		// $criteria->compare('verEntrevista',$this->verEntrevista);
		
		// $criteria->compare('id_userslogin',$this->id_userslogin);
		
		/*
		 * return new CActiveDataProvider(get_class($this), array( 'criteria'=>$criteria, ));
		 */
		$resultados = Administradores::model ()->findAll ();
		$dataProvider = new CArrayDataProvider ( $resultados, array (
				'id' => 'id',
				'sort' => array (
						'attributes' => array (
								'apellido',
								'nombre' 
						) 
				),
				'pagination' => array (
						'pageSize' => 50 
				) 
		) );
		return $dataProvider;
	}
	public static function getUrlAfterLogin() {
		$id = UsersLogin::getAdministradorIDByUsersLoginID ( Yii::app ()->user->id );
		if ($id == null || $id == '') {
			return Yii::app ()->baseUrl . '/site/logout';
		}
		Yii::app ()->getSession ()->add ( 'accessAllow', 'true' );
		return Yii::app ()->homeUrl;
	}
	public function getTipoAdminDescripcion() {
		$this->refresh ();
		return $this->getTipoAdmin()->descripcion;
	}
	
	// Get current users for this permission:
	public function afterFind() {
		if (! empty ( $this->accesos )) {
			foreach ( $this->accesos as $acceso ) {
				$this->accesos_IDs [] = $acceso->id;
				$this->accesos_DESCs [] = $acceso->descripcion;
			}
		}
	}
	public function getTipoAdmin(){
       return TipoAdministradores::model()->find(' id='.$this->idTipo);		
	}
	
	public function printData() {
		echo $this->usuario.'<br>';
	}
	public function getApellidoNombre(){
		return $this->apellido.', '.$this->nombre;
	}
	public function getPublico(){
		return $this->getTipoAdmin()->publico;
	}
}
