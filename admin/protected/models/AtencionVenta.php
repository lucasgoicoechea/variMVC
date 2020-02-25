<?php

class AtencionVenta extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'atencionventa';
	}

	public function rules()
	{
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>45),
			array('id_atencion_venta, nombre', 'safe', 'on'=>'search'),
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
			'id_atencion_venta' => Yii::t('app', 'Id Atencion Venta'),
			'nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_atencion_venta',$this->id_atencion_venta);

		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
