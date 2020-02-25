<?php

class Imputacion extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'imputacion';
	}

	public function rules()
	{
		return array(
			array('id_imputacion, Nombre', 'required'),
			array('id_imputacion, Codigo', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>60),
			array('id_imputacion, Codigo, Nombre', 'safe', 'on'=>'search'),
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
			'id_imputacion' => Yii::t('app', 'Id Imputacion'),
			'Codigo' => Yii::t('app', 'Codigo'),
			'Nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_imputacion',$this->id_imputacion);

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('Nombre',$this->Nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
