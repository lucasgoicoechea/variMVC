<?php
class UsuariosForm extends CFormModel {
	// public static $types=array("Operation","Task","Role");
	public $usuario;
	public $dni = null;
	public $apellido_nombre_like = null;
	public $fecha_ingreso_desde = null;
	public $fecha_ingreso_hasta = null;
	public $anio_egreso_desde = null;
	public $anio_egreso_hasta = null;
	public $id_carrera = null;
	public $id_facultad = null;
	public $idEstudioNivel = null;
	public $idEstadoCarrera = null;
	public $solo_emails = false;
	public $idsUsuariosSearch = '';
	public function buildSearcher() {
		$this->usuario = new Usuarios ();
		$this->usuario->unsetAttributes ();
	}
	public function rules() {
		return array (
				array (
						'dni,	apellido_nombre_like,fecha_ingreso_desde,fecha_ingreso_hasta,anio_egreso_desde,anio_egreso_hasta,id_carrera,id_facultad,idEstudioNivel,idEstadoCarrera,solo_emails',
						'safe' 
				) 
		);
	}
	public function generatedCriteriaSearch() {
		$criteria = new CDbCriteria ();
		if ($this->apellido_nombre_like != null) {
			$criteria->addSearchCondition ( 't.nombre', $this->apellido_nombre_like, true, 'OR', 'LIKE' );
			$criteria->addSearchCondition ( 't.apellido', $this->apellido_nombre_like, true, 'OR', 'LIKE' );
		}
		
		$criteria->join = '';
		
		if ($this->fecha_ingreso_desde != null)
			$criteria->compare ( 't.fecha_ingreso', '>=' . $this->fecha_ingreso_desde, true );
		if ($this->fecha_ingreso_hasta != null)
			$criteria->compare ( 't.fecha_ingreso', '<=' . $this->fecha_ingreso_hasta, true );
		
		if ($this->anio_egreso_desde != null)
			$criteria->compare ( 't.ano_egreso', '>=' . $this->anio_egreso_desde, true );
		if ($this->anio_egreso_hasta != null)
			$criteria->compare ( 't.ano_egreso', '<=' . $this->anio_egreso_hasta, true );
		
		if ($this->id_carrera != null) {
			$criteria->join = $criteria->join . 'LEFT JOIN ' . UsuariosEstudios::model ()->tableName () . ' gc ON gc.id_usuario=t.id';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . Titulos::model ()->tableName () . ' tit ON gc.id_titulo = tit.id ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . Carreras::model ()->tableName () . ' carr ON carr.id_titulo=tit.id ';
			// $criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true));
			$criteria->addCondition ( 'carr.id = ' . $this->id_carrera ); //
		}
		
		if ($this->id_facultad != null) {
			if ($this->id_carrera == null) {
				$criteria->join = $criteria->join . 'LEFT JOIN ' . UsuariosEstudios::model ()->tableName () . ' gc ON gc.id_usuario=t.id';
				$criteria->join = $criteria->join . ' LEFT JOIN ' . Titulos::model ()->tableName () . ' tit ON gc.id_titulo = tit.id ';
				$criteria->join = $criteria->join . ' LEFT JOIN ' . Carreras::model ()->tableName () . ' carr ON carr.id_titulo=tit.id ';
			}
			$criteria->addCondition ( 'carr.id_facultad = ' . $this->id_facultad ); //
		}
		
		if ($this->idEstudioNivel != null) {
			$criteria->join = $criteria->join . ' LEFT JOIN ' . UsuariosEstudios::model ()->tableName () . ' userest ON userest.id_usuario=t.id ';
			$criteria->addCondition ( ' userest.id_nivel = ' . $this->idEstudioNivel ); //
		}
		
		if ($this->idEstadoCarrera != null) {
			if ($this->idEstudioNivel == null) {
				$criteria->join = $criteria->join . ' LEFT JOIN ' . UsuariosEstudios::model ()->tableName () . ' userest ON userest.id_usuario=t.id ';
			}
			$criteria->addCondition ( ' userest.id_estado_carrera = ' . $this->idEstadoCarrera ); //
		}
		
		/*
		 * if ($this->id_posgrado!=null){ $criteria->join = $criteria->join.'LEFT JOIN '.GraduadosPosgrados::model()->tableName().' gp ON gp.id_graduado=t.id'; //$criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true)); $criteria->addCondition('gp.id_posgrado = '.$this->id_posgrado); // } if ($this->id_facultad_posgrado!=null){ if ($this->id_posgrado==null){ $criteria->join = $criteria->join.' LEFT JOIN '.GraduadosPosgrados::model()->tableName().' gp ON gp.id_graduado=t.id'; } $criteria->join = $criteria->join.' LEFT JOIN '.Posgrados::model()->tableName().' postg ON postg.id_posgrado=gp.id_posgrado '; $criteria->addCondition('postg.id_facultad = '.$this->id_facultad_posgrado); // }
		 */
		return $criteria;
	}
	public function searchFreeFilters() {
		$criteria = $this->generatedCriteriaSearch ();
		$dataProvider = $this->usuario->searchByCriteria ( $criteria );
		$this->idsUsuariosSearch = '';
		$data = LGHelper::functions ()->getAllkeysDataProvider ( $dataProvider, 'id' );
		foreach ( $data as $ky ) {
			$this->idsUsuariosSearch = $this->idsUsuariosSearch . ',' . $ky;
		}
		if (count ( $this->idsUsuariosSearch ) > 0)
			$this->idsUsuariosSearch = substr ( $this->idsUsuariosSearch, 1, strlen ( $this->idsUsuariosSearch ) );
		return $dataProvider;
	}
	
	
	public function findWithIds($rowIndex) {
		/*
		 * $criteria=new CDbCriteria; $criteria->addInCondition('id', explode(',',$this->idsUsuariosSearch)); $dataProvider = Usuarios::model()->searchByCriteriaIds($criteria);
		 */
		$dataProvider = Usuarios::model ()->searchByCriteriaIds ( $this->idsUsuariosSearch, $rowIndex );
		return $dataProvider;
	}
	public function searchFreeFiltersMails() {
		$criteria = $this->generatedCriteriaSearch ();
		return $this->usuario->searchByCriteriaBasic ( $criteria );
	}
	public function validando($attribute, $params) {
		if ($this->$attribute == "test")
			$this->addError ( $attribute, "Esto no puede ser test." );
	}
}