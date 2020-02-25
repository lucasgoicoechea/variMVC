<?php

class Rubro extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'rubros';
	}

	public function rules()
	{
		return array(
			array('nombre', 'required'),
			array('Codigo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			array('Codigo, nombre, id_rubro', 'safe', 'on'=>'search'),
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
			'Codigo' => Yii::t('app', 'Codigo'),
			'nombre' => Yii::t('app', 'Nombre'),
			'id_rubro' => Yii::t('app', 'Id Rubro'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('id_rubro',$this->id_rubro);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
