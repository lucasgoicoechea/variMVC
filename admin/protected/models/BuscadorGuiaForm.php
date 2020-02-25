<?php
class BuscadorGuiaForm extends CFormModel {
	public $texto = 'Ingreso texto...';
	public function rules() {
		return array (
				array (
						"texto",
						"required" 
				) 
		// rray("description","filter","filter"=>"trim"),
				);
	}
}