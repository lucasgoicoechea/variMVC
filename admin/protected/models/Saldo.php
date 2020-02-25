<?php

class Saldo extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'saldos';
	}

	public function rules()
	{
		return array(
			array('Fecha, Hora, id_saldos', 'required'),
			array('id_cuenta, id_saldos', 'numerical', 'integerOnly'=>true),
			array('SaldoBanco, SaldoEfectivo', 'length', 'max'=>12),
			array('id_cuenta, SaldoBanco, SaldoEfectivo, Fecha, Hora, id_saldos', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'cuenta' => array(self::BELONGS_TO, 'Cuenta', 'id_cuenta'),
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
			'id_cuenta' => Yii::t('app', 'Id Cuenta'),
			'SaldoBanco' => Yii::t('app', 'Saldo Banco'),
			'SaldoEfectivo' => Yii::t('app', 'Saldo Efectivo'),
			'Fecha' => Yii::t('app', 'Fecha'),
			'Hora' => Yii::t('app', 'Hora'),
			'id_saldos' => Yii::t('app', 'Id Saldos'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_cuenta',$this->id_cuenta);

		$criteria->compare('SaldoBanco',$this->SaldoBanco,true);

		$criteria->compare('SaldoEfectivo',$this->SaldoEfectivo,true);

		$criteria->compare('Fecha',$this->Fecha,true);

		$criteria->compare('Hora',$this->Hora,true);

		$criteria->compare('id_saldos',$this->id_saldos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
