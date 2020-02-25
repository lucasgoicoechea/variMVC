<?php

// change the following paths if necessary
$yii = dirname ( __FILE__ ) . '/../framework/yii.php';
$config = dirname ( __FILE__ ) . '/protected/config/main.php';

//$this->pageTitle=Yii::app()->name;
//error_reporting(E_ALL);
ini_set("memory_limit","1024M");
ini_set('display_errors',0);
error_reporting(E_ERROR);
define ( 'YII_DEBUG', true );
// remove the following lines when in production mode
//defined ( 'YII_DEBUG' ) or define ( 'YII_DEBUG', false );
// remove the following line when in production mode
/*
 * if ($_SERVER['HTTP_HOST'] == 'localhost') { defined('YII_DEBUG') or define('YII_DEBUG',true); $config['components']['log']['routes'][] = array( 'class'=>'CWebLogRoute', 'categories'=>'system.db.CDbCommand', 'showInFireBug'=>true, ); $config['components']['db']['enableProfiling'] = true; $config['components']['db']['enableParamLogging'] = true; }
 */
//set_time_limit(1000);
set_time_limit(0);
// specify how many levels of call stack should be shown in each log message
//defined ( 'YII_TRACE_LEVEL' ) or define ( 'YII_TRACE_LEVEL', 3 );
//error_reporting(-1);
require_once ($yii);
Yii::$enableIncludePath = false; // disable PHP include path usage
Yii::createWebApplication ( $config )->run ();

