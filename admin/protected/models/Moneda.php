<?php

class Moneda extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'moneda';
	}

	public function rules()
	{
		return array(
			array('id_moneda, nombre, siglas', 'required'),
			array('id_moneda', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>250),
			array('siglas', 'length', 'max'=>20),
			array('id_moneda, nombre, siglas', 'safe', 'on'=>'search'),
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
			'id_moneda' => Yii::t('app', 'Id Moneda'),
			'nombre' => Yii::t('app', 'Nombre'),
			'siglas' => Yii::t('app', 'Siglas'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_moneda',$this->id_moneda);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('siglas',$this->siglas,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
