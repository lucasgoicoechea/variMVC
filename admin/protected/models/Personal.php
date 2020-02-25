<?php

class Personal extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'personal';
	}

	public function rules()
	{
		return array(
			array(' Fecha_Ingreso', 'required'),
			array('Codigo, id_categoria_mano_obra, id_empresa, Pantalon, Camisa, Botin, id_obra, id_proveedor', 'numerical', 'integerOnly'=>true),
			array('Apellido, Nombre', 'length', 'max'=>43),
			array('TipoDoc, provincia', 'length', 'max'=>18),
			array('NumDoc', 'length', 'max'=>17),
			array('CUIL', 'length', 'max'=>34),
			array('Domicilio, Piso', 'length', 'max'=>30),
			array('Nro', 'length', 'max'=>13),
			array('Dpto, Banco_Fondo_Desempleo', 'length', 'max'=>16),
			array('Localidad, ObraSocial', 'length', 'max'=>28),
			array('codigo_postal', 'length', 'max'=>4),
			array('Nacion', 'length', 'max'=>9),
			array('estado_civil', 'length', 'max'=>12),
			array('codigo_area', 'length', 'max'=>7),
			array('Telefono', 'length', 'max'=>32),
			array('Numero_Libreta', 'length', 'max'=>35),
			array('Numero_Fondo_Desempleo', 'length', 'max'=>11),
			array('Asignacion_Familiar', 'length', 'max'=>3),
			array('id_proveedor,Codigo, activo, Apellido, Nombre, TipoDoc, NumDoc, CUIL, Domicilio, Nro, Piso, Dpto, Localidad, codigo_postal, provincia, Nacion, id_categoria_mano_obra, estado_civil, codigo_area, Telefono, id_empresa, Numero_Libreta, Banco_Fondo_Desempleo, Numero_Fondo_Desempleo, Asignacion_Familiar, ObraSocial, Pantalon, Camisa, Botin, id_obra, id_proveedor, Fecha_Ingreso, Fecha_Nacimiento, Fecha_ropa, Fecha_Baja', 'safe'),//, 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
				'categoria' => array (
						self::BELONGS_TO,
						'CategoriaManoObra',
						'id_categoria_mano_obra'
				),
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'Codigo' => Yii::t('app', 'Cod'),
			'Apellido' => Yii::t('app', 'Apellido'),
			'Nombre' => Yii::t('app', 'Nombre'),
			'TipoDoc' => Yii::t('app', 'Tipo Doc'),
			'NumDoc' => Yii::t('app', 'Num Doc'),
			'CUIL' => Yii::t('app', 'Cuil'),
			'Domicilio' => Yii::t('app', 'Domicilio'),
			'Nro' => Yii::t('app', 'Nro'),
			'Piso' => Yii::t('app', 'Piso'),
			'Dpto' => Yii::t('app', 'Dpto'),
			'Localidad' => Yii::t('app', 'Localidad'),
			'codigo_postal' => Yii::t('app', 'Codigo Postal'),
			'provincia' => Yii::t('app', 'Provincia'),
			'Nacion' => Yii::t('app', 'Nacion'),
			'id_categoria_mano_obra' => Yii::t('app', 'Id Categoria Mano Obra'),
			'estado_civil' => Yii::t('app', 'Estado Civil'),
			'codigo_area' => Yii::t('app', 'Codigo Area'),
			'Telefono' => Yii::t('app', 'Telefono'),
			'id_empresa' => Yii::t('app', 'Id Empresa'),
			'Numero_Libreta' => Yii::t('app', 'Numero Libreta'),
			'Banco_Fondo_Desempleo' => Yii::t('app', 'Banco Fondo Desempleo'),
			'Numero_Fondo_Desempleo' => Yii::t('app', 'Numero Fondo Desempleo'),
			'Asignacion_Familiar' => Yii::t('app', 'Asignacion Familiar'),
			'ObraSocial' => Yii::t('app', 'Obra Social'),
			'Pantalon' => Yii::t('app', 'Pantalon'),
			'Camisa' => Yii::t('app', 'Camisa'),
			'Botin' => Yii::t('app', 'Botin'),
			'id_obra' => Yii::t('app', 'Id Obra'),
			'id_proveedor' => Yii::t('app', 'Id Proveedor'),
			'Fecha_Ingreso' => Yii::t('app', 'Ingreso'),
			'Fecha_Nacimiento' => Yii::t('app', 'Nacimiento'),
			'Fecha_ropa' => Yii::t('app', 'Fecha Ropa'),
			'Fecha_Baja' => Yii::t('app', 'Fecha Baja'),
		);
	}
	public function crearProveedorSetearId(){
		$provedor = new Proveedor();
		$provedor->Nombre=$this->Nombre.' '.$this->Apellido;
		$provedor->Telefono =$this->Telefono;
		$provedor->Direccion = 'Ciudad: '.$this->Localidad.',Direccion: '.$this->Domicilio.', nro'.$this->Nro; 
		$provedor->Cuit = $this->CUIL;
		$provedor->id_tipo_gasto=2; //mano de obra HARDCODE
		$provedor->id_categoria_iva=2; //responsable no inscripto HARDCODE
		$provedor->id_moneda =1; 
        $id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_proveedor`) as `max` FROM `proveedores` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$provedor->id_proveedor = $id_lead_new;
		$this->id_proveedor = $id_lead_new;
		return $provedor->save();
	}
	public function nulear(){
		$this->id_empresa = null;
		$this->Botin = null;
		$this->Camisa = null;
		$this->Pantalon = null;
	}
	public function getCategoria(){
		return $this->categoria->Nombre.' - '.$this->categoria->ValorHora.' $ ValorHora';
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		
		$criteria->compare('Codigo',$this->Codigo);
		$criteria->compare('activo',$this->activo,true);
		
		$criteria->compare('Apellido',$this->Apellido,true);

		$criteria->compare('Nombre',$this->Nombre,true);

		$criteria->compare('TipoDoc',$this->TipoDoc,true);

		$criteria->compare('NumDoc',$this->NumDoc,true);

		$criteria->compare('CUIL',$this->CUIL,true);

		$criteria->compare('Domicilio',$this->Domicilio,true);

		$criteria->compare('Nro',$this->Nro,true);

		$criteria->compare('Piso',$this->Piso,true);

		$criteria->compare('Dpto',$this->Dpto,true);

		$criteria->compare('Localidad',$this->Localidad,true);

		$criteria->compare('codigo_postal',$this->codigo_postal,true);

		$criteria->compare('provincia',$this->provincia,true);

		$criteria->compare('Nacion',$this->Nacion,true);

		$criteria->compare('id_categoria_mano_obra',$this->id_categoria_mano_obra);

		$criteria->compare('estado_civil',$this->estado_civil,true);

		$criteria->compare('codigo_area',$this->codigo_area,true);

		$criteria->compare('Telefono',$this->Telefono,true);

		$criteria->compare('id_empresa',$this->id_empresa);

		$criteria->compare('Numero_Libreta',$this->Numero_Libreta,true);

		$criteria->compare('Banco_Fondo_Desempleo',$this->Banco_Fondo_Desempleo,true);

		$criteria->compare('Numero_Fondo_Desempleo',$this->Numero_Fondo_Desempleo,true);

		$criteria->compare('Asignacion_Familiar',$this->Asignacion_Familiar,true);

		$criteria->compare('ObraSocial',$this->ObraSocial,true);

		$criteria->compare('Pantalon',$this->Pantalon,true);

		$criteria->compare('Camisa',$this->Camisa,true);

		$criteria->compare('Botin',$this->Botin,true);

		$criteria->compare('id_obra',$this->id_obra,true);

		$criteria->compare('id_proveedor',$this->id_proveedor,true);

		$criteria->compare('Fecha_Ingreso',$this->Fecha_Ingreso,true);

		$criteria->compare('Fecha_Nacimiento',$this->Fecha_Nacimiento,true);

		$criteria->compare('Fecha_ropa',$this->Fecha_ropa,true);

		$criteria->compare('Fecha_Baja',$this->Fecha_Baja,true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
				'pagination' => array (
						'pageSize' => 30
				) 
		));
	}
	public  function getDescripcion() {
		$apellido  = $this->Apellido!=null?$this->Apellido:'';
		$nombre = $this->Nombre!=null?$this->Nombre:'';
		return $apellido.', '.$nombre;
	}
}
