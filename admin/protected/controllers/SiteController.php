<?php
class SiteController extends Controller {
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
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$this->layout = "column2";
		if (! Yii::app ()->user->isGuest) {
			if (UsersLogin::isAdministrador ( Yii::app ()->user->id )) {
				Yii::app ()->getSession ()->add ( 'accessAllow', 'true' );
			} else {
				$this->redirect ( Yii::app ()->baseUrl . '/site/logout' );
			}
		}
		// else $this->redirect(Yii::app()->baseUrl.'/site/logout');
		$model = new LoginForm ();
		Obra::model()->revisarTerminadas();
		$this->render ( 'principal', array (
				"model" => $model 
		) );
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app ()->errorHandler->error) {
			if (Yii::app ()->request->isAjaxRequest)
				echo $error ['message'];
			else
				$this->render ( 'error', $error );
		}
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if (isset ( $_POST ['ContactForm'] )) {
			$model->attributes = $_POST ['ContactForm'];
			if ($model->validate ()) {
				$name = '=?UTF-8?B?' . base64_encode ( $model->name ) . '?=';
				$subject = '=?UTF-8?B?' . base64_encode ( $model->subject ) . '?=';
				$headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";
				
				mail ( Yii::app ()->params ['adminEmail'], $subject, $model->body, $headers );
				Yii::app ()->user->setFlash ( 'contact', 'Thank you for contacting us. We will respond to you as soon as possible.' );
				$this->refresh ();
			}
		}
		$this->render ( 'contact', array (
				'model' => $model 
		) );
	}

	public function actionAccesoDenegado(){
		$this->layout = "column2";
		$this->render ( 'accesoDenegado', array (
				'code'=>'ERROR POR FALTA DE PERMISOS',
				'message'=>'Usted no tiene acceso a esa operación, solicité con el Administrador'
		) );
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginForm ();
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $model->login ())
				// $this->redirect(Yii::app()->user->returnUrl);
				// $this->render('/usuarios/update/',array('id'=>UsersLogin::getUsuarioDNIByUsersLoginID(Yii::app()->user->id)));
				$this->redirect ( '/usuarios/update/' . UsersLogin::getUsuarioDNIByUsersLoginID ( Yii::app ()->user->id ) . '.html' );
		}
		// display the login form
		$this->render ( 'login', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app ()->getSession ()->add ( 'accessAllow', 'false' );
		Yii::app ()->user->logout ();
		$this->redirect ( Yii::app ()->homeUrl );
	}
	
	/**
	 * Displays the login page
	 */
	public function actionArticulosInfo($id = 0) {
		$this->layout = "column2";
		if ($id == 0) {
			$this->redirect ( Yii::app ()->homeUrl );
		}
		$model = ArticulosInformativos::model ()->findByPK ( $id ); // display the login form
		if ($model != null)
			$this->render ( 'articulosInfo', array (
					'model' => $model 
			) );
		else
			$this->redirect ( Yii::app ()->homeUrl );
	}
	public function actionViewTestimonio($id) {
		$this->layout = "column2";
		$model = ArticulosRelacionados::model ()->findByPk ( $id );
		$this->render ( 'viewTestimonio', array (
				'model' => $model 
		) );
	}
	public function actionViewTestimonios() {
		$this->layout = "column2";
		$testimonios = ArticulosRelacionados::model ()->getTestimoniosNotHome ();
		$this->render ( 'viewTestimonios', array (
				'testimonios' => $testimonios 
		) );
	}
	public function actionLoginAdmin() {
		$this->layout = "loginAdmin";
		/*
		 * $model=new UnderConstructionForm; // collect user input data if(isset($_POST['UnderConstructionForm'])) { $model->attributes=$_POST['UnderConstructionForm']; // validate user input and redirect to the previous page if valid if($model->validate() && $model->login()){ Yii::app()->getSession()->add('accessUnderConstruction', 'true'); $this->redirect('index'); } )} // display the login form
		 */
		$this->render ( 'loginAdmin' );
	}
	
		
public function actionDownloadPDF($url){
		# mPDF
		//$mPDF1 = Yii::app()->ePdf->mpdf();
		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A5');
		Yii::import('ext.ehttpclient.*');
		Yii::import('ext.ehttpclient.adapter.*');
		$uri= Yii::app()->request->hostInfo.$url.'.html?renderPartial=true';
		$client = new EHttpClient($uri, array(
				'maxredirects' => 9,
				'timeout'      => 300));
				//,'adapter'      => 'EHttpClientAdapterCurl'));
		 
		//$client->setParameterGet(array('hl'=>'es', 'q'=>'manolo'));
		//$client->setCookieJar();
		$response = $client->request('GET');
		//$response->getLastRequest();
		if($response->isSuccessful())
			$mPDF1->WriteHTML( $response->getBody());
		else
			$mPDF1->WriteHTML($response->getRawBody());
		//echo $response->getBody();
		# render (full page)
		//$mPDF1->WriteHTML($this->render($url, array('renderPartial'=>true), true));
		
    	# Load a stylesheet
		//$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
		//$mPDF1->WriteHTML($stylesheet, 1);
		# renderPartial (only 'view' of current controller)
		//$mPDF1->WriteHTML($this->renderPartial('index', array(), true));
		# Renders image
		//$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
		# Outputs ready PDF

		//$this->redirect (Yii::app()->request->hostInfo.$url.'.html?renderPartial=true');
		$mPDF1->Output();
	}
	public function actionDownloadPDFHTML($html){
		# mPDF
		//$mPDF1 = Yii::app()->ePdf->mpdf();
		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A5');
		$mPDF1->WriteHTML( $response->getBody());
		$mPDF1->Output();
	}
	public function actionDownloadPDFAction($url){
		# mPDF
		//$mPDF1 = Yii::app()->ePdf->mpdf();
		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A5');
		Yii::import('ext.ehttpclient.*');
		Yii::import('ext.ehttpclient.adapter.*');
		$uri= Yii::app()->request->hostInfo.$url.'.html?renderPartial=true';
		$client = new EHttpClient($uri, array(
				'maxredirects' => 9,
				'timeout'      => 300));
		//,'adapter'      => 'EHttpClientAdapterCurl'));
			
		//$client->setParameterGet(array('hl'=>'es', 'q'=>'manolo'));
		//$client->setCookieJar();
		$response = $client->request('GET');
		//$response->getLastRequest();
		if($response->isSuccessful())
			$mPDF1->WriteHTML( $response->getBody());
		else
			$mPDF1->WriteHTML($response->getRawBody());
		//echo $response->getBody();
		# render (full page)
		//$mPDF1->WriteHTML($this->render($url, array('renderPartial'=>true), true));
	
		# Load a stylesheet
		//$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
		//$mPDF1->WriteHTML($stylesheet, 1);
		# renderPartial (only 'view' of current controller)
		//$mPDF1->WriteHTML($this->renderPartial('index', array(), true));
		# Renders image
		//$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
		# Outputs ready PDF
	
		//$this->redirect (Yii::app()->request->hostInfo.$url.'.html?renderPartial=true');
		$mPDF1->Output();
	}
	public function actionDownloadDOC($url) {
		LGHelper::functions()->generateDOCbyURL($url);
	}
	
	public function actionEncuestaOnline() {
	$model = new DniForm();	
	$this->layout = "column1Public";
	if (isset($_POST['DniForm'])){
		$model->attributes = $_POST ['DniForm'];
		if($model->validate()){
	       if (Graduados::existeDNI($model->dni)){
	       	   $unGra = Graduados::getByDNI($model->dni);
	       	   $this->redirect(Yii::app()->createUrl('graduados/createAndPollPublic',array('id'=>$unGra->id)) );
	       }
	       	else
	       		$this->redirect(Yii::app()->createUrl('graduados/createAndPollPublic') );
		}
	}
	$this->render( 'identificacionDNI',array('model'=>$model));
	}
} 
