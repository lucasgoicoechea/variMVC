<?php
Yii::import ( 'zii.widgets.CPortlet' );
class UserLogin extends CPortlet {
	public $title = 'Accede a tu CV';
	public $tipoUsersLogin = 1;
	protected function renderContent() {
		// $form=new LoginForm;
		// if(isset($_POST['LoginForm']))
		// {
		// $form->attributes=$_POST['LoginForm'];
		// if($form->validate())
		// $this->controller->refresh();
		// }
		// $this->render('userLogin',array('form'=>$form));
		$model = new LoginForm ();
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			$model->attributes = $_POST ['LoginForm'];
			$model->tipoUsersLogin = $this->tipoUsersLogin;
			// validate user input and redirect to the previous page if valid
			if (!$model->validate ()) {
				echo CHtml::errorSummary($model);
				Yii::app()->end();
			}
			if (!$model->login ()) {
				echo CHtml::errorSummary($model);
				Yii::app()->end();
			}
			if ($model->validate () && $model->login ()) {
				$url = Yii::app ()->homeUrl;
				if ($model->tipoUsersLogin == '1')
					$url = Administradores::getUrlAfterLogin ();
				elseif ($model->tipoUsersLogin === Administradores::TIPO_USERS)
					$url = Administradores::getUrlAfterLogin ();
				elseif ($model->tipoUsersLogin === Empresas::TIPO_USERS)
					$url = Empresas::getUrlAfterLogin ();
				elseif ($model->tipoUsersLogin === Administradores::TIPO_USERS)
					$url = Administradores::getUrlAfterLogin ();
				$this->controller->redirect ( $url );
			}
		}
		// display the login form
		$this->render ( 'userLogin', array (
				'form' => $model 
		) );
	}
}
