<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $_id;
	private $tipoUsersLogin = 1;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * 
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$user = UsersLogin::model ()->find ( "LOWER(username)=? AND id_tipo_userslogin=? ", array (
				strtolower ( $this->username ),
				$this->tipoUsersLogin 
		) );
		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif (md5 ( $this->password ) !== $user->password)
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id = $user->id;
			$this->errorCode = self::ERROR_NONE;
		}
		return ! $this->errorCode;
	}
	
	/**
	 * Constructor.
	 * 
	 * @param string $username
	 *        	username
	 * @param string $password
	 *        	password
	 */
	public function __construct($username, $password, $tipoUsersLogin) {
		$this->username = $username;
		$this->password = $password;
		$this->tipoUsersLogin = $tipoUsersLogin;
	}
	public function getId() {
		return $this->_id;
	}
}