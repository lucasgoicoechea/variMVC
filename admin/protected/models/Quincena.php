<?php

class Quincena extends CActiveRecord
{
	public $id_cuenta= null;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'quincenas';
	}

	public function rules()
	{
		return array(
			array('id_quincenal, Fecha,id_proveedor, id_obra', 'required'),
			array('id_proveedor, id_obra, horas_extras, dias_trabajados, nro_secuencia_quincena, id_quincenal, Indice, id_empresa', 'numerical', 'integerOnly'=>true),
			array('horas, efectivo, adelantos, extras, Final, subtotal, viaticos, movilidad, descuentos_adelantos', 'length', 'max'=>10),
			array('Quincena', 'length', 'max'=>110),
			array('id_quincenal, Fecha,id_gasto,id_quincena, id_proveedor, horas, efectivo, adelantos, id_obra, extras, horas_extras, dias_trabajados, Final, subtotal, viaticos, movilidad, descuentos_adelantos, nro_secuencia_quincena, Quincena, id_quincenal, Indice, Fecha, id_empresa', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'personal' => array (
				self::BELONGS_TO,
				'Personal',
				'id_proveedor'
			),
			'obra' => array (
				self::BELONGS_TO,
				'Obra',
				'id_obra'
			),
			'quincenal' => array (
				self::BELONGS_TO,
				'Quincenal',
				'id_quincenal'
			),
				'gasto' => array (
						self::BELONGS_TO,
						'Gasto',
						'id_gasto'
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
			'id_quincena' => Yii::t('app', 'Id Quincena'),
			'id_proveedor' => Yii::t('app', 'Personal'),
			'horas' => Yii::t('app', 'Horas'),
			'efectivo' => Yii::t('app', 'Efectivo'),
			'adelantos' => Yii::t('app', 'Adelantos'),
			'id_obra' => Yii::t('app', 'Id Obra'),
			'extras' => Yii::t('app', 'Extras'),
			'horas_extras' => Yii::t('app', 'Horas Extras'),
			'dias_trabajados' => Yii::t('app', 'Dias Trabajados'),
			'Final' => Yii::t('app', 'Final'),
			'subtotal' => Yii::t('app', 'Subtotal'),
			'viaticos' => Yii::t('app', 'Viaticos'),
			'movilidad' => Yii::t('app', 'Movilidad'),
			'descuentos_adelantos' => Yii::t('app', 'Descuentos Adelantos'),
			'nro_secuencia_quincena' => Yii::t('app', 'Nro Secuencia Quincena'),
			'Quincena' => Yii::t('app', 'Quincena'),
			'id_quincenal' => Yii::t('app', 'Id Quincenal'),
			'Indice' => Yii::t('app', 'Indice'),
			'Fecha' => Yii::t('app', 'Fecha'),
			'id_empresa' => Yii::t('app', 'Id Empresa'),
		);
	}

	public function calcularImportes(){
		$this->subtotal = $this->viaticos +  $this->movilidad + $this->efectivo + $this->adelantos + $this->extras ;
		$this->Final = $this->subtotal - $this->descuentos_adelantos ;
	}
	public function formatearMoneda(){
		$this->Final = LGHelper::functions ()->formatNumber ( $this->Final );
		
		$this->viaticos = LGHelper::functions ()->formatNumber ( $this->viaticos );
		$this->movilidad = LGHelper::functions ()->formatNumber ( $this->movilidad );
		$this->efectivo = LGHelper::functions ()->formatNumber ( $this->efectivo );
		$this->adelantos = LGHelper::functions ()->formatNumber ( $this->adelantos );
		$this->extras =LGHelper::functions ()->formatNumber ( $this->extras );
		$this->subtotal = LGHelper::functions ()->formatNumber ( $this->subtotal );

		$this->descuentos_adelantos = LGHelper::functions ()->formatNumber ( $this->descuentos_adelantos );
		
	}
	public function calcularFinal(){
		$viaticos = LGHelper::functions ()->unformatNumber ( $this->viaticos );
		$movilidad = LGHelper::functions ()->unformatNumber ( $this->movilidad );
		$efectivo = LGHelper::functions ()->unformatNumber ( $this->efectivo );
		$adelantos = LGHelper::functions ()->unformatNumber ( $this->adelantos );
		$extras =LGHelper::functions ()->unformatNumber ( $this->extras );
		$subtotal = $viaticos +$movilidad+$efectivo+$adelantos+$extras;
		$descuentos_adelantos = LGHelper::functions ()->unformatNumber ( $this->descuentos_adelantos );
		$Final = $subtotal - $descuentos_adelantos;
		return $Final;
	}
	public function calcularSubtotal(){
		$viaticos = LGHelper::functions ()->unformatNumber ( $this->viaticos );
		$movilidad = LGHelper::functions ()->unformatNumber ( $this->movilidad );
		$efectivo = LGHelper::functions ()->unformatNumber ( $this->efectivo );
		$adelantos = LGHelper::functions ()->unformatNumber ( $this->adelantos );
		$extras =LGHelper::functions ()->unformatNumber ( $this->extras );
		$subtotal = $viaticos +$movilidad+$efectivo+$adelantos+$extras;
		return $subtotal;
	}
    public function desformatearMoneda(){
		$this->viaticos = LGHelper::functions ()->unformatNumber ( $this->viaticos );
		$this->movilidad = LGHelper::functions ()->unformatNumber ( $this->movilidad );
		$this->efectivo = LGHelper::functions ()->unformatNumber ( $this->efectivo );
		$this->adelantos = LGHelper::functions ()->unformatNumber ( $this->adelantos );
		$this->extras =LGHelper::functions ()->unformatNumber ( $this->extras );
		$this->subtotal = $this->viaticos +$this->movilidad+$this->efectivo+$this->adelantos+$this->extras;
		$this->descuentos_adelantos = LGHelper::functions ()->unformatNumber ( $this->descuentos_adelantos );
		$this->Final = $this->subtotal - $this->descuentos_adelantos;
	}
	public function afterFind() {
		$this->formatearMoneda();
		$this->Fecha= LGHelper::functions ()->displayFecha ( $this->Fecha );
		return parent::afterFind ();
	}
	public function save() {
		$this->desformatearMoneda();
		//$this->Fecha= LGHelper::functions ()->undisplayFecha ( $model->Fecha );
		return parent::save ();
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_quincena',$this->id_quincena);

		$criteria->compare('id_proveedor',$this->id_proveedor);

		$criteria->compare('horas',$this->horas,true);

		$criteria->compare('efectivo',$this->efectivo,true);

		$criteria->compare('adelantos',$this->adelantos,true);

		$criteria->compare('id_obra',$this->id_obra);

		$criteria->compare('extras',$this->extras,true);

		$criteria->compare('horas_extras',$this->horas_extras);

		$criteria->compare('dias_trabajados',$this->dias_trabajados);

		$criteria->compare('Final',$this->Final,true);

		$criteria->compare('subtotal',$this->subtotal,true);

		$criteria->compare('viaticos',$this->viaticos,true);

		$criteria->compare('movilidad',$this->movilidad,true);

		$criteria->compare('descuentos_adelantos',$this->descuentos_adelantos,true);

		$criteria->compare('nro_secuencia_quincena',$this->nro_secuencia_quincena);

		$criteria->compare('Quincena',$this->Quincena,true);

		$criteria->compare('t.id_quincenal',$this->id_quincenal);

		$criteria->compare('Indice',$this->Indice);

		$criteria->compare('Fecha',$this->Fecha,true);

		$criteria->compare('id_empresa',$this->id_empresa);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function nulearImportes(){
	   $this->Final = null;
	   $this->subtotal = null;
	   $this->adelantos = null;
	   $this->viaticos = null;
	   $this->movilidad = null;
	   $this->descuentos_adelantos = null;
	}

	public function getNroSecuenciaQuincena($idquincienal){
        $criteria = new CDbCriteria ();
			$criteria->addCondition(' id_quincenal='.$idquincienal);
			$model = new Quincena();
			$models = $model->find( $criteria );
			return $models->nro_secuencia_quincena+1;
	}

	public function getCuenta(){
		if($this->gasto!==null)
			return $this->gasto->getPago()->cuenta;
		return Cuenta::model()->findByPk(35); //cuenta sueldos id=35
	}

	public function searchOrderQuincena(){
		
		$criteria=new CDbCriteria;

		$criteria->compare('id_quincena',$this->id_quincena);

		$criteria->compare('id_proveedor',$this->id_proveedor);

		$criteria->compare('horas',$this->horas,true);

		$criteria->compare('efectivo',$this->efectivo,true);

		$criteria->compare('adelantos',$this->adelantos,true);

		$criteria->compare('id_obra',$this->id_obra);

		$criteria->compare('extras',$this->extras,true);

		$criteria->compare('horas_extras',$this->horas_extras);

		$criteria->compare('dias_trabajados',$this->dias_trabajados);

		$criteria->compare('Final',$this->Final,true);

		$criteria->compare('subtotal',$this->subtotal,true);

		$criteria->compare('viaticos',$this->viaticos,true);

		$criteria->compare('movilidad',$this->movilidad,true);

		$criteria->compare('descuentos_adelantos',$this->descuentos_adelantos,true);

		$criteria->compare('nro_secuencia_quincena',$this->nro_secuencia_quincena);

		$criteria->compare('Quincena',$this->Quincena,true);

		$criteria->compare('t.id_quincenal',$this->id_quincenal);

		$criteria->compare('Indice',$this->Indice);

		$criteria->compare('Fecha',$this->Fecha,true);

		$criteria->with = array('quincenal');
		//$criteria->compare('id_empresa',$this->id_empresa);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'quincenal.anio DESC, quincenal.mes  DESC, quincenal.quincena DESC',
			),
			'pagination' => array (
					'pageSize' => 50 
			) 
		));
	}
}
