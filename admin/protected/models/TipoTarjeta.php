<?php

class TipoTarjeta extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipo_tarjeta';
	}

	public function rules()
	{
		return array(
			array('descripcion', 'required'),
			array('descripcion', 'length', 'max'=>60),
			array('id_tipo_tarjeta, descripcion', 'safe', 'on'=>'search'),
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
			'id_tipo_tarjeta' => Yii::t('app', 'Id Tipo Tarjeta'),
			'descripcion' => Yii::t('app', 'Descripcion'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_tarjeta',$this->id_tipo_tarjeta);

		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
