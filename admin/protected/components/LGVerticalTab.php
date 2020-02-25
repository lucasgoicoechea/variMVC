<?php
/*
 * <pre> $this->widget('application.components.Relation', array( 'model' => 'Post', 'relation' => 'user' 'fields' => 'username' // show the field "username" of the parent element )); </pre> Full Example: <pre> $this->widget('application.components.Relation', array( 'model' => 'Post', 'field' => 'Userid', 'style' => 'ListBox', 'parentObjects' => Parentmodel::model()->findAll('userid = 17'), 'groupParentsBy' => 'city', 'relation' => 'user', 'relatedPk' => 'id_of_user', 'fields' => array( 'username', 'username.group.groupid' ), 'delimiter' => ' -> ', // default: ' | ' 'returnTo' => 'model/create', 'addButtonLink' => 'othercontroller/otheraction', // default: '' 'showAddButton' => 'click here to add a new User', // default: '' 'htmlOptions' => array('style' => 'width: 100px;') )); </pre> @author Lucas Goicoechea <lucasgoicoechea@gmail.com> @version 1.0rc3 @since 1.1
 */
class LGVerticalTab extends CWidget {
	
	// this Variable holds an instance of the Object
	public $tagIdContent = 1; // rand(10,100);
	public $showTabs = true;
	public $openForm = false;
	public $altForm = 'Agregar nuevo elemento a la lista';
	public $tagIdContentForm = 'form';
	public $tagTitle = 'XXXXX';
	public $tagNameTabs = 'div';
	public $tagNameContentTabs = 'div';
	public $tagCssClassPublic = 'titulo';
	public $tagCssClassApply = 'collapsed';
	public $tagCssClassContentPublic = 'contenedor-tabla';
	public $expandedTab = true;
	public $tagIdContentPrefix = 'tab-content-';
	public $imgUrlAnimated = NULL;
	public function init() {
		$this->expandedTab = LGHelper::functions ()->openTab ( $this->tagIdContent );
		$functionCambioCss = "function () {
		if ($( '#" . $this->tagIdContentPrefix . $this->tagIdContent . 'tab' . "' ).hasClass('" . $this->tagCssClassApply . "')) 
		$( '#" . $this->tagIdContentPrefix . $this->tagIdContent . 'tab' . "' ).removeClass('" . $this->tagCssClassApply . "');
		else $( '#" . $this->tagIdContentPrefix . $this->tagIdContent . 'tab' . "' ).addClass('" . $this->tagCssClassApply . "');
		}";
		
		if ($this->showTabs !== false) {
			// formo el tab que se clickea
			echo "<" . $this->tagNameTabs;
			echo " style='cursor: pointer' ";
			echo ' id="' . $this->tagIdContentPrefix . $this->tagIdContent . 'tab' . '" ';
			if ($this->expandedTab)
				echo ' class="' . $this->tagCssClassPublic . '" ';
			else {
				echo ' class="' . $this->tagCssClassPublic . ' ' . $this->tagCssClassApply . '" ';
			}
			echo " onclick=\"$( '#" . $this->tagIdContentPrefix . $this->tagIdContent . "' ).slideToggle( 'slow'," . $functionCambioCss . ")\" ";
			echo ">";
			echo $this->tagTitle;
			
			echo "</" . $this->tagNameTabs . ">";
			// formo el contenedor que se expande
			echo "<" . $this->tagNameContentTabs;
			echo ' class="' . $this->tagCssClassContentPublic . '" ';
			if (! $this->expandedTab)
				echo ' style="display:none" ';
			echo ' id="' . $this->tagIdContentPrefix . $this->tagIdContent . '"';
			echo ">";
			if ($this->openForm){
				echo "<img src='" . Yii::app ()->theme->baseUrl . "/img/icons/add.png' ";
				echo " alt='".$this->altForm."' ";
				echo " style='cursor: pointer' ";
				/*echo ' id="' . $this->tagIdContentPrefix . $this->tagIdContent . 'tab' . '" ';
				 if ($this->expandedTab)
					echo ' class="' . $this->tagCssClassPublic . '" ';
				else {
				echo ' class="' . $this->tagCssClassPublic . ' ' . $this->tagCssClassApply . '" ';
				}*/
				echo " onclick=\"$( '#" . $this->tagIdContentForm . "' ).slideToggle( 'slow')\" ";
				echo ">";
			}
		}
	}
	public function run() {
		if ($this->showTabs !== false) {
			echo "</" . $this->tagNameTabs . ">";
		}
	}
}

