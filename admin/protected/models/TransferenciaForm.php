<?php
class TransferenciaForm extends CFormModel {
	// public static $types=array("Operation","Task","Role");
	public $cuenta;
	public $descripcion ;
	public $importe ;
	public $id_transferencia;
	public $fecha;
	public function rules() {
		return array (
				array (
					 
				) 
		);
	}
}