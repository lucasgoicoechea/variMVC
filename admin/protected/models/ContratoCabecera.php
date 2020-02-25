<?php

class ContratoCabecera extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'contrato_cabecera';
	}

	public function rules()
	{
		return array(
			array('id_proveedor, Fecha, Descripcion, Precio, Plazo, id_obra, id_usuario_autorizo, id_usuario_solicito, codigo', 'required'),
			array('id_proveedor, id_obra, id_empresa, id_usuario_autorizo, id_usuario_solicito, codigo', 'numerical', 'integerOnly'=>true),
			array('Descripcion, Acuerdo', 'length', 'max'=>510),
			array('Precio', 'length', 'max'=>12),
			array('Plazo', 'length', 'max'=>20),
			array('usuario_log', 'length', 'max'=>60),
			array('id_contrato_cabecera, id_proveedor, Fecha, Descripcion, Precio, Plazo, Acuerdo, id_obra, id_empresa, id_usuario_autorizo, id_usuario_solicito, codigo, usuario_log, fecha_log', 'safe', 'on'=>'search'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'id_contrato_cabecera' => Yii::t('app', 'Contrato Cabecera'),
			'id_proveedor' => Yii::t('app', 'Proveedor'),
			'Fecha' => Yii::t('app', 'Fecha'),
			'Descripcion' => Yii::t('app', 'Descripcion'),
			'Precio' => Yii::t('app', 'Precio'),
			'Plazo' => Yii::t('app', 'Plazo'),
			'Acuerdo' => Yii::t('app', 'Acuerdo'),
			'id_obra' => Yii::t('app', 'Obra'),
			'id_empresa' => Yii::t('app', 'Empresa'),
			'id_usuario_autorizo' => Yii::t('app', 'Usuario Autorizo'),
			'id_usuario_solicito' => Yii::t('app', 'Usuario Solicito'),
			'codigo' => Yii::t('app', 'Codigo'),
			'usuario_log' => Yii::t('app', 'Usuario Log'),
			'fecha_log' => Yii::t('app', 'Fecha Log'),
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
						'Administradores',
						'id_usuario_autorizo'
				),
				'usuarioSolicito' => array (
						self::BELONGS_TO,
						'Administradores',
						'id_usuario_solicito'
				),
				'gastos' => array (
						self::HAS_MANY,
						'Gasto',
						'id_contrato_cabecera'
				),
				'recibos' => array (
						self::HAS_MANY,
						'Recibo',
						'id_contrato_cabecera'
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

	public function  getDescripcion(){
		return "Fecha:".$this->Fecha." - ".$this->Descripcion;
	}

	public function  getDescripcionCodigo(){
		return "Subcontrato nro.:".$this->codigo. " - Fecha:".$this->Fecha." - ".$this->Descripcion;
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
		$url = Yii::app ()->createUrl ( 'contratoCabecera/imprimirContrato', array (
				'id' => $this->id_contrato_cabecera
		) );
		return $url;
	}
	
	public function search() {
		$criteria = new CDbCriteria ();
	
		$criteria->compare ( 'codigo', $this->codigo );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
	
		$criteria->compare ( 'Fecha', $this->Fecha, true );
	
		$criteria->compare ( 'Descripcion', $this->Descripcion, true );
	
		$criteria->compare ( 'Precio', $this->Precio, true );
	
		$criteria->compare ( 'Plazo', $this->Plazo, true );
	
		$criteria->compare ( 'Acuerdo', $this->Acuerdo, true );
	
		$criteria->compare ( 'id_obra', $this->id_obra );
	
		$criteria->compare ( 'id_empresa', $this->id_empresa );
	
		$criteria->compare ( 'id_usuario_autorizo', $this->id_usuario_autorizo );
	
		$criteria->compare ( 'id_usuario_solicito', $this->id_usuario_solicito );
		$criteria->order = " codigo DESC";
		return new CActiveDataProvider ( get_class ( $this ), array (
				'pagination' => array (
						'pageSize' => 40
				),
				'criteria' => $criteria
		) );
	}

	public function getUsuarioSolicito(){
		$usuario = Administradores::model()->findByPk($this->id_usuario_solicito);
		return $usuario->apellido. ', '.$usuario->nombre;
	}

	public function getUsuarioAutorizo(){
		$usuario = Administradores::model()->findByPk($this->id_usuario_autorizo);
		return $usuario->apellido. ', '.$usuario->nombre;
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
	
	public function getPrecioMasAdicionales(){
		//vuelvo el precio a formato normal
		$precio= LGHelper::functions ()->unformatNumber ($this->Precio);
		$contratos = Contrato::model()->searchWithContrato($this->id_contrato_cabecera);
		foreach ($contratos as $contrato){
			$precio = $precio + LGHelper::functions ()->unformatNumber ($contrato->Precio);
		}
		return $precio;
	}
}
