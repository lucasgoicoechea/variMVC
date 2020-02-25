<?php
class BuscadorGuia extends CWidget {
	public function init() {
		$model = new BuscadorGuiaForm ();
		$this->render ( 'buscadorGuia', array (
				'model' => $model 
		) );
	}
	public function run() {
	}
}