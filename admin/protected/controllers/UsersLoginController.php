<?php
class UsersLoginController extends Controller {
	/**
	 *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *      using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	public $defaultAction = 'admin';
	public $label = 'Usuarios';
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete'  // we only allow deletion via POST request
				);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules() {
		/*
		 * const ROLE_SUPER_USUARIO='super'; const ROLE_USUARIO='usuario'; const ROLE_ADMINISTRADOR='admin'; const ROLE_EMPRESA='empresa'; const ROLE_USUARIO_LOGUEADO='@'; const ROLE_USUARIO_TODOS='*';
		 */
		return array (
				array (
						'allow',
						'actions' => array (
								'cv',
								'admin',
								'delete',
								'create',
								'update',
								'forgotPassword' 
						),
						'roles' => array (
								UsersLogin::ROLE_ADMINISTRADOR 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'cv',
								'admin',
								'delete',
								'create',
								'update',
								'forgotPassword' 
						),
						'roles' => array (
								UsersLogin::ROLE_ADMINISTRADOR,
								UsersLogin::ROLE_USUARIO 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'cv',
								'admin',
								'delete',
								'create',
								'update',
								'forgotPassword' 
						),
						'roles' => array (
								UsersLogin::ROLE_ADMINISTRADOR,
								UsersLogin::ROLE_EMPRESA 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'cv',
								'admin',
								'delete',
								'create',
								'update',
								'forgotPassword' 
						),
						'users' => array (
								UsersLogin::ROLE_USUARIO_TODOS 
						) 
				),
				array (
						'deny',
						'users' => array (
								UsersLogin::ROLE_USUARIO_TODOS 
						) 
				) 
		);
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel ( $id );
		$role = new RoleForm ();
		
		if (isset ( $_POST ["ajax"] ) and $_POST ["ajax"] === "role-form") {
			echo CActiveForm::validate ( $role );
			Yii::app ()->end ();
		}
		
		if (isset ( $_POST ["RoleForm"] )) {
			$role->attributes = $_POST ["RoleForm"];
			if ($role->validate ()) {
				Yii::app ()->authManager->createRole ( $role->name, $role->description );
				Yii::app ()->authManager->assign ( $role->name, $id );
				
				$this->redirect ( array (
						"view",
						"id" => $id 
				) );
			}
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['UsersLogin'] )) {
			$model->attributes = $_POST ['UsersLogin'];
			if ($model->save ())
				$this->redirect ( array (
						'update',
						'id' => $model->id 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model,
				'role' => $role 
		) );
	}
	public function actionAssign($id) {
		if (Yii::app ()->authManager->checkAccess ( $_GET ["item"], $id ))
			Yii::app ()->authManager->revoke ( $_GET ["item"], $id );
		else
			Yii::app ()->authManager->assign ( $_GET ["item"], $id );
		$this->redirect ( array (
				"update",
				"id" => $id 
		) );
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		$this->loadModel ( $id )->delete ();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (! isset ( $_GET ['ajax'] ))
			$this->redirect ( isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
					'admin' 
			) );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new UsersLogin ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['UsersLogin'] ))
			$model->attributes = $_GET ['UsersLogin'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function crearActivacionPassword($usuario_campo, $tipo_userslogin = 1) {
		$usersLoginActivacion = new UsersLoginActivacionNewPass ();
		$usersLoginActivacion->id_userslogin = UsersLogin::getUsersLoginIDbyUserName ( $usuario_campo, $tipo_userslogin );
		$usersLoginActivacion->username = $usuario_campo;
		$usersLoginActivacion->tipo_userslogin = $tipo_userslogin;
		$codigoActivacion = 'ERROR_EN_EL_CODIGO' . date ( 'j' );
		echo $usersLoginActivacion->tipo_userslogin;
			// Yii::app ()->end();
		if ($usersLoginActivacion->tipo_userslogin == Empresas::TIPO_USERS)
			$codigoActivacion = Empresas::getCodigoActivacionPostMail ( $usersLoginActivacion->id_userslogin, $usersLoginActivacion->username );
		
		$usersLoginActivacion->codigo_activacion = $codigoActivacion;
		if (! $usersLoginActivacion->save ()) {
			Yii::app ()->user->setFlash ( 'error', 'Error en la reactivación, comuniquese con PROLAB telefonicamente' );
			$this->redirect ( Yii::app ()->homeUrl );
		}
	}
	public function actionForgotPassword($id) {
		$model = new ReactivacionForm ();
		if (isset ( $_POST ['ReactivacionForm'] )) {
			// $model->attributes=
			$model->username = $_POST ['ReactivacionForm'] ['username'];
			$usuario_campo = $model->username;
			if (! isset ( $usuario_campo )) { // || ! isset ( $tipo_userslogin )) {
				Yii::app ()->user->setFlash ( 'mensaje', 'Error en el intento reactivación, comuniquese con PROLAB telefonicamente' );
				//$this->redirect ( Yii::app ()->homeUrl );
			}
			
			if (! UsersLogin::existeUsersLoginByTipo ( $usuario_campo, $id )) {
				Yii::app ()->user->setFlash ( 'error', 'Usuario inexistente en nuestra Base de Datos, comuniquese con PROLAB telefonicamente' );
				//$this->redirect ( Yii::app ()->homeUrl );
			}
			$this->crearActivacionPassword ( $usuario_campo, $id );
			Yii::app ()->user->setFlash ( 'success', 'RECIBIRÁ UN E-MAIL CON EL LINK PARA GENERAR SU NUEVA CONTRASEÑA' );
			//$this->redirect ( Yii::app ()->homeUrl );
		}
		// $this->redirect ( Yii::app ()->homeUrl );
		$this->render ( 'reactivacion', array (
				'model' => $model,
				'reactivacion' => false 
		) );
	}
	public function actionReactivacion($codigoActivacion) {
		$model = new ReactivacionForm ();
		$userActivacion = UsersLoginActivacionNewPass::getByCodigoActivation ( $codigoActivacion );
		if ($userActivacion == null) {
			Yii::app ()->user->setFlash ( 'error', 'ERROR, CODIGO DE ACTIVACIÓN HA VENCIDO, VUELVA A PEDIR UNA RENOVACIÓN' );
			$this->redirect ( Yii::app ()->homeUrl );
		}
		// collect user input data
		if (isset ( $_POST ['ReactivacionForm'] )) {
			$model->password = $_POST ['ReactivacionForm'] ['password'];
			// validate user input and redirect to the previous page if valid
			if ($model->validateRenovacionClave ()) {
				if (UsersLogin::cambiarPass ( $userActivacion->id_userslogin, $model->password )) {
					Yii::app ()->user->setFlash ( 'success', 'CONTRASEÑA NUEVA REGISTRADA CON EXITO	' );
					$userActivacion->delete ();
					$this->redirect ( Yii::app ()->homeUrl );
				}
			} else {
				Yii::app ()->user->setFlash ( 'error', 'INGRESE CORRECTAMENTE SU NUEVA CONTRASEÑA' );
			}
		}
		
		// display the login form
		$this->render ( 'reactivacion', array (
				'model' => $model,
				'reactivacion' => true 
		) );
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id
	 *        	the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = UsersLogin::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exisUserst.' );
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 *
	 * @param Users $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'users-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
