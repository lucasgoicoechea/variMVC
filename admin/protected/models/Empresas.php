<?php

class Empresas extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'empresa';
	}

	public function rules()
	{
		return array(
			array('nombre, codigo, inicio_actividad, razon_social', 'required'),
			array('id, cuit', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			array('codigo', 'length', 'max'=>6),
			array('razon_social', 'length', 'max'=>200),
			array('email', 'required'),
			array('gerente', 'required'),
			array('id, nombre,email,gerente, codigo, cuit, inicio_actividad, razon_social', 'safe', 'on'=>'search'),
		);
	}

	
	public function getIDCuentaEfectivoOCajaChica(){
		$cajaChica =Cuenta::model()->getCajaChica();
		if ($cajaChica === null) {
			//mando la primera por defecto
			return 1;
		}
		return $cajaChica->id_cuenta;
	} 
	public function relations()
	{
		return array(
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
			'id' => Yii::t('app', 'Id Empresa'),
			'nombre' => Yii::t('app', 'Nombre'),
			'codigo' => Yii::t('app', 'Codigo'),
			'cuit' => Yii::t('app', 'Cuit'),
			'email' => Yii::t('app', 'Email'),
			'gerente' => Yii::t('app', 'Gerente'),
			'inicio_actividad' => Yii::t('app', 'Inicio Actividad'),
			'razon_social' => Yii::t('app', 'Razon Social'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('codigo',$this->codigo,true);

		$criteria->compare('cuit',$this->cuit);

		$criteria->compare('inicio_actividad',$this->inicio_actividad,true);

		$criteria->compare('razon_social',$this->razon_social,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
