<?php
class Proveedor extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'proveedores';
	}
	public function rules() {
		return array (
				array (
						'Nombre, id_tipo_gasto, id_categoria_iva, id_moneda',
						'required' 
				),
				array (
						'id_tipo_gasto, id_categoria_iva, id_moneda',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Nombre',
						'length',
						'max' => 70 
				),
				array (
						'Telefono, Celular, Fax, Direccion, Contacto, E_Mail,telefono_dos, telefono_tres,telefono_cuatro',
						'length',
						'max' => 100 
				),
				array (
						'Cuit',
						'length',
						'max' => 30 
				),
				array (
						'SubTipo',
						'length',
						'max' => 60 
				),
				array (
						'id_proveedor, Nombre, Telefono, Celular, Fax, Direccion, Contacto, Cuit, E_Mail, SubTipo, id_tipo_gasto, id_categoria_iva, id_moneda,telefono_dos, telefono_tres,telefono_cuatro',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cheques' => array (
						self::HAS_MANY,
						'Cheque',
						'id_proveedor' 
				),
				'contratos' => array (
						self::HAS_MANY,
						'ContratoCabecera',
						'id_proveedor' 
				),
				'gastos' => array (
						self::HAS_MANY,
						'Gasto',
						'id_proveedor' 
				),
				'ordenesCompras' => array (
						self::HAS_MANY,
						'OrdenCompra',
						'id_proveedor' 
				),
				'presupuestos' => array (
						self::HAS_MANY,
						'Presupuesto',
						'id_proveedor' 
				),
				'categoriaIVA' => array (
						self::BELONGS_TO,
						'CategoriaIVA',
						'id_categoria_iva' 
				),
				'moneda' => array (
						self::BELONGS_TO,
						'Moneda',
						'id_moneda' 
				),
				'tipoGasto' => array (
						self::BELONGS_TO,
						'TipoGasto',
						'id_tipo_gasto' 
				),
				'recibos' => array (
						self::HAS_MANY,
						'Recibo',
						'id_proveedor' 
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
				'id_proveedor' => Yii::t ( 'app', 'Nro. Proveedor' ),
				'Nombre' => Yii::t ( 'app', 'Nombre' ),
				'Telefono' => Yii::t ( 'app', 'Telefono' ),
				'telefono_dos' => Yii::t ( 'app', 'Telefono #2' ),
				'telefono_tres' => Yii::t ( 'app', 'Telefono #3' ),
				'telefono_cuatro' => Yii::t ( 'app', 'Telefono #4' ),
				'Celular' => Yii::t ( 'app', 'Celular' ),
				'Fax' => Yii::t ( 'app', 'Fax' ),
				'Direccion' => Yii::t ( 'app', 'Direccion' ),
				'Contacto' => Yii::t ( 'app', 'Contacto' ),
				'Cuit' => Yii::t ( 'app', 'Cuit' ),
				'E_Mail' => Yii::t ( 'app', 'E Mail' ),
				'SubTipo' => Yii::t ( 'app', 'Sub Tipo' ),
				'id_tipo_gasto' => Yii::t ( 'app', 'Id Tipo Gasto' ),
				'id_categoria_iva' => Yii::t ( 'app', 'Id Categoria Iva' ),
				'id_moneda' => Yii::t ( 'app', 'Id Moneda' ) 
		);
	}
	public function getDescripcion(){
		$nombre = $this->Nombre!=null?$this->Nombre:'';
		$telefono = $this->Telefono!=null?$this->Telefono:'';
		$nombre = $nombre.'( '.$telefono.')';
		return $nombre;
	}

	public function getDescripcionShort(){
		$id = $this->id_proveedor;
		$nombre = $this->Nombre!=null?$this->Nombre:'';
		$nombre = $id.'-'.$nombre;
		return $nombre;
	}
	public function borrar($id){
		$prov = Proveedor::findByPk($id)->delete();
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		
		$criteria->compare ( 'Telefono', $this->Telefono, true );
		
		$criteria->compare ( 'Celular', $this->Celular, true );
		
		$criteria->compare ( 'Fax', $this->Fax, true );
		
		$criteria->compare ( 'Direccion', $this->Direccion, true );
		
		$criteria->compare ( 'Contacto', $this->Contacto, true );
		
		$criteria->compare ( 'Cuit', $this->Cuit, true );
		
		$criteria->compare ( 'E_Mail', $this->E_Mail, true );
		
		$criteria->compare ( 'SubTipo', $this->SubTipo, true );
		
		$criteria->compare ( 'id_tipo_gasto', $this->id_tipo_gasto );
		
		$criteria->compare ( 'id_categoria_iva', $this->id_categoria_iva );
		
		$criteria->compare ( 'id_moneda', $this->id_moneda );
		
		$criteria->order = "Nombre";
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 30 
				) 
		) );
	}
}
