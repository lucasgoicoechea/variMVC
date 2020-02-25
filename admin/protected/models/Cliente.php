<?php
class Cliente extends CActiveRecord {
	public $id_provincia = 24;
	public $id_partido = 1;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'clientes';
	}
	public function rules() {
		return array (
				array (
						'nombre, telefono, fax,id_categoria_iva',
						'required' 
				),
				array (
						'codigo, id_localidad, id_moneda',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'nombre',
						'length',
						'max' => 62 
				),

				array (
						'cuit',
						'length',
						'max' => 15
				),
				array (
						'telefono, fax',
						'length',
						'max' => 100 
				),

				array (
						'direccion,responsable',
						'length',
						'max' => 180
				),
				array (
						'id_cliente, codigo, nombre, telefono, fax, id_localidad, id_moneda,id_categoria_iva,cuit,direccion,responsable',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'localidad' => array (
						self::BELONGS_TO,
						'Localidad',
						'id_localidad'
				),
				'moneda' => array (
						self::BELONGS_TO,
						'Moneda',
						'id_moneda' 
				),
				'cobros' => array (
						self::HAS_MANY,
						'Cobro',
						'id_cliente' 
				),
				'obras' => array (
						self::HAS_MANY,
						'Obra',
						'id_cliente' 
				) ,
				'categoriaIVA' => array (
						self::BELONGS_TO,
						'CategoriaIVA',
						'id_categoria_iva' 
				),
		);
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function attributeLabels() {
		return array (
				'id_cliente' => Yii::t ( 'app', 'Id Cliente' ),
				'codigo' => Yii::t ( 'app', 'Codigo' ),
				'nombre' => Yii::t ( 'app', 'Nombre' ),
				'telefono' => Yii::t ( 'app', 'Telefono' ),
				'fax' => Yii::t ( 'app', 'Fax' ),
				'id_localidad' => Yii::t ( 'app', 'Id Localidad' ),
				'id_moneda' => Yii::t ( 'app', 'Id Moneda' ) ,
				'direccion' => Yii::t ( 'app', 'Dirección' ),
				'responsable' => Yii::t ( 'app', 'Responsable' )
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cliente', $this->id_cliente );
		
		$criteria->compare ( 'codigo', $this->codigo );
		
		$criteria->compare ( 'nombre', $this->nombre, true );
		
		$criteria->compare ( 'telefono', $this->telefono, true );
		
		$criteria->compare ( 'fax', $this->fax, true );
		
		$criteria->compare ( 'id_localidad', $this->id_localidad );
		
		$criteria->compare ( 'id_moneda', $this->id_moneda );
		$criteria->order = "FIELD(nombre, 'ASC')";
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	
	public function getDescripcion() {
		return $this->codigo.' - '.$this->nombre;
	}
	public function getCiudades($defaultPartido = 67) {
		if (isset ( $this->id_localidad ) && $this->id_localidad != 0)
			$defaultPartido = $this->localidad->c_id_partido;
		$localidades = Localidad::model ()->findAll ( " c_id_partido=?", array (
				$defaultPartido
		) );
		return CHtml::listData ( $localidades, "c_id", "d_descripcion" );
	}
	public function getProvincias() {
		$provincias = Provincia::model ()->findAll ();
		return CHtml::listData ( $provincias, "c_id", "d_descripcion" );
	}
	public function getPartidos($defaultProvincia = 24) {
		$partidos = Partido::model ()->findAll ( " c_id_provincia=?", array (
				$defaultProvincia
		) );
		return CHtml::listData ( $partidos, "c_id", "d_descripcion" );
	}
	function getCiudadDescripcion() {
		$provincias = Localidad::model ()->findByPk ( $this->id_localidad);
		if ($provincias == null)
			return "";
		return $provincias->d_descripcion;
	}
}
