<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ReactivacionForm extends CFormModel {
	public $username;
	public $password;
	public $new_password;
	public $tipoUsersLogin;
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array ();
	}
	public function validateRenovacionClave() {
		return $this->password !== $this->new_password;
	}
}
