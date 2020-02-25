<?php

class FormaPago extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'forma_pago';
	}

	public function rules()
	{
		return array(
			array('Codigo, Nombre', 'required'),
			array('Codigo', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>40),
			array('id_forma, Codigo, Nombre', 'safe', 'on'=>'search'),
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
			'id_forma' => Yii::t('app', 'Id Forma'),
			'Codigo' => Yii::t('app', 'Codigo'),
			'Nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_forma',$this->id_forma);

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('Nombre',$this->Nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
