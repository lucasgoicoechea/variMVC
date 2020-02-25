<?php

class MedioPago extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'medios_pago';
	}

	public function rules()
	{
		return array(
			array('nombre, codigo', 'required'),
			array('codigo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>60),
			array('id_medios_pago, nombre, codigo', 'safe', 'on'=>'search'),
		);
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
			'id_medios_pago' => Yii::t('app', 'Id Medios Pago'),
			'nombre' => Yii::t('app', 'Nombre'),
			'codigo' => Yii::t('app', 'Codigo'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_medios_pago',$this->id_medios_pago);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('codigo',$this->codigo);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
