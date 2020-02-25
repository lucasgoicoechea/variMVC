<?php
class AdministradoresController extends Controller {
	public $layout = '//layouts/column2';
	private $_model;
	public function filters() {
		return array (
				'accessControl' 
		);
	}
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'index',
								'view' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'actualizarAdminLogin',
								'create',
								'update',
								'backupManual' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'admin',
								'delete' 
						),
						'users' => array (
								'admin',
								'@' 
						) 
				),
				array (
						'deny',
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function actionCreate() {
		$model = new Administradores ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Administradores'] )) {
			$model->attributes = $_POST ['Administradores'];
			$model->accesos = $_POST ['Administradores'] ['accesos_IDs'];
			if ($model->validate ()) {
				$usuarioLogueado = UsersLogin::createNonPersistentModel ( $model->usuario, $model->clave, Administradores::TIPO_USERS );
				if (isset ( $usuarioLogueado ) || $usuarioLogueado != false) {
					$model->id_userslogin = $usuarioLogueado->id;
					if ($model->validate () && $usuarioLogueado->login ( $model->clave )) {
						if ($model->save ())
							$model->refresh ();
						$usuarioLogueado->assingRole ( UsersLogin::ROLE_ADMINISTRADOR, $usuarioLogueado->id );
						Yii::app ()->user->setFlash ( 'mensaje', 'Usuario registrado exitosamente' );
						$this->redirect ( array (
								'admin',
								// 'id' => $model->dni,
								'exitoCambio' => true 
						) );
					} else
						$this->refresh ();
				} else
					Yii::app ()->user->setFlash ( 'mensaje', 'Fallo en la creación de sesión' );
			} else
				Yii::app ()->user->setFlash ( 'mensaje', 'Fallo en el ingreso de Datos' );
		}
		
		$this->render ( 'create', array (
				'model' => $model,
				'usuario' => UsersLogin::getAdministradorByUsersLoginID ( Yii::app ()->user->id )
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Administradores'] )) {
			$model->attributes = $_POST ['Administradores'];
			$model->usersLogin->username = $model->usuario;
			$model->accesos = $_POST ['Administradores'] ['accesos_IDs'];
			if ($model->save () && $model->usersLogin->save ())
				Yii::app ()->user->setFlash ( 'mensaje', 'Usuario actualizado exitosamente' );
			$this->redirect ( array (
					'admin',
					'id' => $model->id 
			) );
		}
		
		$this->render ( 'update', array (
				'model' => $model,
				'usuario' => UsersLogin::getAdministradorByUsersLoginID ( Yii::app ()->user->id )
		) );
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$this->loadModel ()->delete ();
			
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'admin' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Administradores' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$usuario = UsersLogin::getAdministradorByUsersLoginID ( Yii::app ()->user->id );
		$model = new Administradores ( 'search' );
		
		if ($usuario != null) {
			$this->performAjaxValidation ( $model );
			if (isset ( $_POST ['Administradores'] )) {
				$model->attributes = $_POST ['Administradores'];
				$model->accesos = $_POST ['Administradores'] ['accesos_IDs'];
				if ($model->validate ()) {
					$usuarioLogueado = UsersLogin::createNonPersistentModel ( $model->usuario, $model->clave, Administradores::TIPO_USERS );
					if (isset ( $usuarioLogueado ) || $usuarioLogueado != false) {
						$model->id_userslogin = $usuarioLogueado->id;
						if ($model->validate ()) { // && $usuarioLogueado->login ( $model->clave )) {
							if ($model->save ())
								$model->refresh ();
							$usuarioLogueado->assingRole ( UsersLogin::ROLE_ADMINISTRADOR, $usuarioLogueado->id );
							Yii::app ()->user->setFlash ( 'mensaje', 'Usuario registrado exitosamente' );
							$this->redirect ( array (
									'admin',
									// 'id' => $model->dni,
									'exitoCambio' => true 
							) );
						} else
							$this->refresh ();
					} else
						Yii::app ()->user->setFlash ( 'mensaje', 'Fallo en la creación de sesión' );
				} else
					Yii::app ()->user->setFlash ( 'mensaje', 'Fallo en el ingreso de Datos' );
			}
		}
		
		if ($usuario != null) {
			if (! $usuario->getTipoAdmin()->isEditaPerfiles ())
				$this->redirect (array (
									'update',
									'id' =>$usuario->id
							) );
			if (isset ( $_GET ['Administradores'] ))
				$model->attributes = $_GET ['Administradores'];
			
			$this->render ( 'admin', array (
					'model' => $model,
					'usuario' => UsersLogin::getAdministradorByUsersLoginID ( Yii::app ()->user->id )
			) );
		} else
			$this->redirect ( Yii::app ()->homeUrl );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Administradores::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'administradores-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionActualizarAdminLogin() {
		$admines = Administradores::model ()->findAll ();
		foreach ( $admines as $admin ) {
			// if ($admin->id_userslogin==null || $admin->id_userslogin==0) {
			$usuarioLogueado = UsersLogin::createNonPersistentModel ( $admin->usuario, $admin->clave, Administradores::TIPO_USERS );
			if ($usuarioLogueado->save ()) {
				$usuarioLogueado->refresh ();
				$admin->id_userslogin = $usuarioLogueado->id;
				$usuarioLogueado->assingRole ( UsersLogin::ROLE_ADMINISTRADOR, $usuarioLogueado->id );
				$sql = 'update admin set id_userslogin = '. $usuarioLogueado->id.' where usuario="'.$admin->usuario.'"';
				if (Yii::app ()->db->createCommand($sql)->execute()>0){
					$admin->printData ();
					echo '--> EXITO' . '<br>';
				} else {
					echo '--> ERRORES:';
					echo CHtml::errorSummary ( $admin );
				}
			} else {
				echo CHtml::errorSummary ( $usuarioLogueado );
			}
			// }
		}
	}
	
	public function actionBackupManual(){
		Yii::import('ext.dumpDB.dumpDB');
		$dumper = new dumpDB();
		$bk_file = 'FILE_NAME-'.date('YmdHis').'.sql';
		$fh = fopen($bk_file, 'w') or die("can't open file");
		fwrite($fh, $dumper->getDump(FALSE));
		fclose($fh);
		/*header('Content-Type: application/sql');
		header('Content-Disposition: attachment; filename="backup-manual.sql";');
		header('Content-Length: '.filesize('$bk_file'));
		readfile($bk_file);
		Yii::app()->end();*/
	}
}
