<?php

/**
 * dynamic sidebar slider on the right side of the browser
 *
 * I refered Rightsidebar extention from yiiframework.com
 * 
 * @author Ramamoorthy <ramamoorthy071@gmail.com>
 * @version 1.0
 * @license BSD
 */
class LeftSidebar extends CWidget {

    public $title = 'LeftSidebar';

   
    public $collapsed = false;

    public function init() {
       $assetFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $publishedAssetsPath = Yii::app()->assetManager->publish($assetFolder);

        Yii::app()->clientScript->registerCssFile($publishedAssetsPath . '/css/leftsidebar.css');
        Yii::app()->clientScript->registerScriptFile($publishedAssetsPath . '/js/leftsidebar.js');

        $js = $this->collapsed ?
                'left_menu.setStartStatus(false);' :
                'left_menu.setStartStatus(true);';
        Yii::app()->clientScript->registerScript('leftMenu', $js, CClientScript::POS_LOAD);

        echo '<div class="left_menu" id="leftmenu">';
        
       echo '<div class="title">' ;
		echo  CHtml::encode($this->title);
        echo '</div>';

        parent::init();
    }

    public function run() {
        parent::run();

        echo '</div>';
    }
}
?>
