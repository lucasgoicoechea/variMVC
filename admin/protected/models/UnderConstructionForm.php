<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UnderConstructionForm extends CFormModel {
	public $password;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (
				// username and password are required
				array (
						'password',
						'required' 
				) 
		);
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * 
	 * @return boolean whether login is successful
	 */
	public function login() {
		return $this->password == Yii::app ()->params ['enableUnderConstructionPass'];
	}
}
