<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias ( 'bakFolder', dirname ( __FILE__ ) . "/../../../prolab_bak" );
Yii::setPathOfAlias ( 'ecalendarview', dirname ( __FILE__ ) . '/../extensions/ecalendarview' );

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array (
		'language' => 'es',
		'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
		'name' => 'VARI S.R.L.',
		// 'theme'=>"classic",
		// 'theme'=>"base",
		// 'theme'=>"blue", failed to open stream: No such file or directory
		// 'theme'=>"chame_blue",
		// "theme"=>"chame_salmon",
		// "theme"=>"gustalh",
		"theme" => "prolab_old",
		
		// preloading 'log' component
		'preload' => array (
				'log' 
		),
		
		// autoloading model and component classes
		'import' => array (
				'application.models.*',
				'application.components.*',
				'application.helpers.*',
				'application.extensions.CAdvancedArBehavior' 
		),
		
		'modules' => array (
				// uncomment the following to enable the Gii tool
				
				'gii' => array (
						'class' => 'system.gii.GiiModule',
						'password' => '123456',
						// If removed, Gii defaults to localhost only. Edit carefully to taste.
						'generatorPaths' => array (
								'ext.gtc' 
						) // Gii Template Collection
,
						'ipFilters' => array (
								/* '192.168.102.49',
								'127.0.0.1',
								'::1' */ 
						),
						'newFileMode' => 7777,
						'newDirMode' => 7777 
				),	
	),
		
		// application components
		'components' => array (
 'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
				'authManager' => array (
						"class" => "CDbAuthManager",
						"connectionID" => "db" 
				),
				'assetManager' => array (
						'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' 
				),
				'session' => array(
						'timeout' => 3600*24,
						'autoStart'=> true,
				),
				'happy' => array (
						"class" => "ext.FHappy" 
				),
				'sad' => array (
						"class" => "ext.FHappy",
						"trato" => 1 
				),
				'user' => array (
						// enable cookie-based authentication
						'allowAutoLogin' => true,
						'loginUrl' => array (
								"/site/index" 
						) 
				),
				// uncomment the following to enable URLs in path-format
				'urlManager' => array (
						'urlFormat'=>'path',
						'showScriptName' => false,
						 'urlSuffix' => '.html',
						'rules' => array (
								'<controller:\w+>/<id:\d+>' => '<controller>/view',
								'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
								'<controller:\w+>/<action:\w+>' => '<controller>/<action>' 
						) 
				),
		'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=c1591330_vari_bd',
				'emulatePrepare' => true,
				'username' => 'c1591330_vari_bd',
				'password' => '69fuseGItu',
				'charset' => 'utf8',
		),
     
				'errorHandler' => array (
						// use 'site/error' action to display errors
						'errorAction' => 'site/error' 
				),
				'log' => array (
						'class' => 'CLogRouter',
						'routes' => array (
								array (
										'class' => 'CFileLogRoute',
										'levels' => 'error, warning' 
								) 
						)
						// uncomment the following to show log messages on web pages
						
						/*
						 * array(
						 * 'class'=>'CWebLogRoute',
						 * ),
						 */
						
						 
				),
		/*'clientScript' => array(
				'scriptMap' => array(
						'jquery.js'=>false,
						'jquery.min.js'=>false,
						'core.css'=>false,
						'styles.css'=>false,
						'pager.css'=>false,
						'default.css'=>false,
				),
				'packages'=>array(
						'jquery'=>array(
								'baseUrl'=>'bootstrap/',
								'js'=>array('js/jquery-1.7.2.min.js'),
						),
						'bootstrap'=>array(
								'baseUrl'=>'bootstrap/',
								'js'=>array('js/bootstrap.min.js'),
								'css'=>array(
										'css/bootstrap.min.css',
										'css/custom.css',
										'css/bootstrap-responsive.min.css',
								),
								'depends'=>array('jquery'),
						),
				),
		),*/
		'ePdf' => array (
						'class' => 'ext.yii-pdf.EYiiPdf',
						'params' => array (
								'mpdf' => array (
										'librarySourcePath' => 'application.vendors.mpdf.*',
										'constants' => array (
												'_MPDF_TEMP_PATH' => Yii::getPathOfAlias ( 'application.runtime' ) 
										),
										'class' => 'mPDF' 
								) // the literal class filename to be loaded from the vendors folder
								/*
								 * 'defaultParams' => array( // More info: http://mpdf1.com/manual/index.php?tid=184
								 * 'mode' => '', // This parameter specifies the mode of the new document.
								 * 'format' => 'A4', // format A4, A5, ...
								 * 'default_font_size' => 0, // Sets the default document font size in points (pt)
								 * 'default_font' => '', // Sets the default font-family for the new document.
								 * 'mgl' => 15, // margin_left. Sets the page margins for the new document.
								 * 'mgr' => 15, // margin_right
								 * 'mgt' => 16, // margin_top
								 * 'mgb' => 16, // margin_bottom
								 * 'mgh' => 9, // margin_header
								 * 'mgf' => 9, // margin_footer
								 * 'orientation' => 'P', // landscape or portrait orientation
								 * )
								 */
								,
								'HTML2PDF' => array (
										'librarySourcePath' => 'application.vendors.html2pdf.*',
										'classFile' => 'html2pdf.class.php' 
								) // For adding to Yii::$classMap
								/*
								 * 'defaultParams' => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
								 * 'orientation' => 'P', // landscape or portrait orientation
								 * 'format' => 'A4', // format A4, A5, ...
								 * 'language' => 'en', // language: fr, en, it ...
								 * 'unicode' => true, // TRUE means clustering the input text IS unicode (default = true)
								 * 'encoding' => 'UTF-8', // charset encoding; Default is UTF-8
								 * 'marges' => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
								 * )
								 */
								 
						) 
				) 
		),
		
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' => array (
				'openTabs' => '1,9',
				// this is used in contact page
				'adminEmail' => 'lucasgoicoechea@gmail.com',
				'cv_bak_files' => 'http://www.graduados.unlp.edu.ar/admin2/cv/files/',
				// 'cv_bak_files'=> 'http://www.prolab.unlp.edu.ar/prolabMVC/prolab_bak/cv/',
				'enableLogSQLinPage' => false,
				'enableUnderConstruction' => true,
				'enableUnderConstructionPass' => 'acceso' 
		) 
);
