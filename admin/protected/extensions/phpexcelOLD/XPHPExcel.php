<?php

/**
 * Wrapper for the PHPExcel library.
 * @see README.md
 */
class XPHPExcel extends CComponent
{
	private static $_isInitialized = false;
	
	/**
	 * Register autoloader.
	 */
	public static function init()
	{
		if (!self::$_isInitialized) {
			$baseFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'PHPExcel.php';
			if (!file_exists($baseFile)) {
				throw new CException('Cannot find PHPExcel.php in expected path.');
			}
			
			spl_autoload_unregister(array('YiiBase', 'autoload'));
			require($baseFile);
			spl_autoload_register(array('YiiBase', 'autoload'));
			
			self::$_isInitialized = true;
		}
	}
	
	/**
	 * Returns new PHPExcel object. Automatically registers autoloader.
	 * @return PHPExcel
	 */
	public static function createPHPExcel()
	{
		self::$_isInitialized = true;
		self::init();
		spl_autoload_unregister(array('YiiBase','autoload'));
		Yii::import('ext.phpexcel.Classes.PHPExcel', true);
		$objPHPExcel = new PHPExcel();
		//$activeSheet = $objPHPExcel->getActiveSheet();
		spl_autoload_register(array('YiiBase','autoload'));
		return $objPHPExcel;
		//return new PHPExcel;
	}
}
