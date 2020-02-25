<?php
class Contrato extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'contratos';
	}
	public function rules() {
		return array (
				array (
						'id_proveedor, Fecha, Detalle, Plazo, id_obra, id_empresa, id_usuario_autorizo, id_usuario_solicito,id_contrato_cabecera',
						'required' 
				),
				array (
						'id_proveedor, id_obra, id_empresa, id_usuario_autorizo, id_usuario_solicito',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Detalle, Acuerdo',
						'length',
						'max' => 510 
				),
				array (
						'Precio',
						'length',
						'max' => 12 
				),
				array (
						'Plazo',
						'length',
						'max' => 20 
				),
				array (
						'id_contrato,id_contrato_cabecera, id_proveedor, Fecha, Detalle, Precio, Plazo, Acuerdo, id_obra, id_empresa, id_usuario_autorizo, id_usuario_solicito',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'usuarioAutorizo' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'id_usuario_autorizo' 
				),
				'usuarioSolicito' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'id_usuario_solicito' 
				),
				'recibos' => array (
						self::HAS_MANY,
						'Recibo',
						'id_contrato' 
				) 
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
				'id_contrato' => Yii::t ( 'app', 'Contrato' ),
				'id_contrato_cabecera' => Yii::t ( 'app', 'SubContrato' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'Detalle' => Yii::t ( 'app', 'Detalle' ),
				'Precio' => Yii::t ( 'app', 'Precio' ),
				'Plazo' => Yii::t ( 'app', 'Plazo' ),
				'Acuerdo' => Yii::t ( 'app', 'Acuerdo' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_empresa' => Yii::t ( 'app', 'Empresa' ),
				'id_usuario_autorizo' => Yii::t ( 'app', 'Usuario Autorizo' ),
				'id_usuario_solicito' => Yii::t ( 'app', 'Usuario Solicito' ) 
		);
	}
	public function  getDescripcion(){
		return "Fecha:".$this->Fecha." - ".$this->Detalle;
	}
	public function getProveedorDescripcion() {
		$prov = $this->proveedor != null ? $this->proveedor : new Proveedor ();
		return $prov->getDescripcion ();
	}
	
	public function getDescripcionCompleta(){
		$str = trim($this->getDescripcion());
		$str = $str .'-PROVEEDOR: '. trim($this->getProveedorDescripcion());
		$str = $str .'-OBRA: '.	trim($this->obra->getDescripcion());
		return $str;
	}


	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'contrato/imprimirContrato', array (
				'id' => $this->id_contrato
		) );
		return $url;
	}
	
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_contrato', $this->id_contrato );
			$criteria->compare ( 'id_contrato_cabecera', $this->id_contrato_cabecera );
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->compare ( 'Precio', $this->Precio, true );
		
		$criteria->compare ( 'Plazo', $this->Plazo, true );
		
		$criteria->compare ( 'Acuerdo', $this->Acuerdo, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		
		$criteria->compare ( 'id_usuario_autorizo', $this->id_usuario_autorizo );
		
		$criteria->compare ( 'id_usuario_solicito', $this->id_usuario_solicito );
		$criteria->order = "Fecha DESC";
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	

	public function afterFind() {
		$this->Fecha= LGHelper::functions ()->displayFecha($this->Fecha);
		$this->Precio= LGHelper::functions ()->formatNumber ($this->Precio);
		return parent::afterFind();
	}
	public function save() {
		$this->Fecha= LGHelper::functions ()->undisplayFecha($this->Fecha);
		$this->Precio= LGHelper::functions ()->unformatNumber ($this->Precio);
		return parent::save();
	}
	
	public function searchWithContrato($id_contrato) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_contrato_cabecera', $id_contrato );
		$criteria->order = ' id_contrato desc ';
		$results = Contrato::model ()->findAll ( $criteria );
		return $results;
	}
	
	public function getUrlAgregarContrato($id_contrato_cabecera) {
		$url = Yii::app ()->createUrl ( 'contratoCabecera/agregarItemSubcontrato', array (
				'id_contrato_cabecera' => $id_contrato_cabecera
		) );
		return $url;
	}
	
}
