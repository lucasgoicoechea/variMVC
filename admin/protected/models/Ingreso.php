<?php

class Ingreso extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'ingresos';
	}

	public function rules()
	{
		return array(
			array('Nombre', 'required'),
			array('Codigo', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>100),
			array('id_ingreso, Codigo, Nombre', 'safe', 'on'=>'search'),
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
			'id_ingreso' => Yii::t('app', 'Id Ingreso'),
			'Codigo' => Yii::t('app', 'Codigo'),
			'Nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_ingreso',$this->id_ingreso);

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('Nombre',$this->Nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
