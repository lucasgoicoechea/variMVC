<?php
class UpgradeDataController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array (
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array (
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF 
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array (
						'class' => 'CViewAction' 
				) 
		);
	}
	public function passAdministradoresUsersLogin() {
		$admins = Administradores::model ()->findAll ();
		foreach ( $admins as $admin ) {
			if (! UsersLogin::existeAdministrador ( $admin->usuario )) {
				UsersLogin::createNonPersistentModel ( $admin->usuario, $admin->clave, Administradores::TIPO_USERS );
			}
		}
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionPassAdministradoresUsersLogin() {
		$this->layout = "column2";
		if (! Yii::app ()->user->isGuest) {
			if (UsersLogin::isAdministrador ( Yii::app ()->user->id )) {
				passAdministradoresUsersLogin ();
			} else {
				$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
			}
		} else
			$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
	}
	public function passProfesionalesUsersLogin() {
		$admins = Profesionales::model ()->findAll ();
		foreach ( $admins as $admin ) {
			if (! UsersLogin::existeProfesional ( $admin->dni )) {
				$logined = UsersLogin::createNonPersistentModel ( $admin->dni, $admin->password, Profesionales::TIPO_USERS );
				if ($logined != false) {
					$admin->id_userslogin = $logined->id;
					if (! $admin->save ())
						$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
				}
			}
		}
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionPassProfesionalesUsersLogin() {
		$this->layout = "column2";
		if (! Yii::app ()->user->isGuest) {
			if (UsersLogin::isAdministrador ( Yii::app ()->user->id )) {
				passProfesionalesUsersLogin ();
			} else {
				$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
			}
		} else
			$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
	}
} 
