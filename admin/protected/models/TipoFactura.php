<?php

class TipoFactura extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipo_factura';
	}

	public function rules()
	{
		return array(
			array('nombre, secuencia', 'required'),
			array('secuencia', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>80),
			array('id_tipo_factura, nombre, secuencia', 'safe', 'on'=>'search'),
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
			'id_tipo_factura' => Yii::t('app', 'Id Tipo Factura'),
			'nombre' => Yii::t('app', 'Nombre'),
			'secuencia' => Yii::t('app', 'Secuencia'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_factura',$this->id_tipo_factura);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('secuencia',$this->secuencia);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public static function getTipoA() {
		return 1;
	}
	public static function getTipoB() {
		return 2;
	}
	
}
