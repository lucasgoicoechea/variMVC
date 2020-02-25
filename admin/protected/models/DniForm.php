<?php
class DniForm extends CFormModel {
	// public static $types=array("Operation","Task","Role");
	public $dni;
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'dni',
						'required'
				),
				array (
						'dni',
						'numerical',
						'integerOnly' => true
				)
		);
	}
}