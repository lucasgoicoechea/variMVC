<?php

class SubRubro extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'subrubros';
	}

	public function rules()
	{
		return array(
			array('Nombre', 'required'),
			array('Codigo, id_rubro', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>50),
			array('id_subrubro, Codigo, Nombre, id_rubro', 'safe', 'on'=>'search'),
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
			'id_subrubro' => Yii::t('app', 'Id Subrubro'),
			'Codigo' => Yii::t('app', 'Codigo'),
			'Nombre' => Yii::t('app', 'Nombre'),
			'id_rubro' => Yii::t('app', 'Id Rubro'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_subrubro',$this->id_subrubro);

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('Nombre',$this->Nombre,true);

		$criteria->compare('id_rubro',$this->id_rubro);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
