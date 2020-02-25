<?php

class RecuperaCheque extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'recuperacheques';
	}

	public function rules()
	{
		return array(
			array('id_cheque, numero_cheque, id_cuenta_banco, fecha, hora', 'required'),
			array('id_cheque, id_cuenta_banco', 'numerical', 'integerOnly'=>true),
			array('numero_cheque', 'length', 'max'=>50),
			array('id_recuperar_cheque, id_cheque, numero_cheque, id_cuenta_banco, fecha, hora', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idCheque' => array(self::BELONGS_TO, 'Cheques', 'id_cheque'),
			'idCuentaBanco' => array(self::BELONGS_TO, 'Cuentasbancos', 'id_cuenta_banco'),
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
			'id_recuperar_cheque' => Yii::t('app', 'Id Recuperar Cheque'),
			'id_cheque' => Yii::t('app', 'Id Cheque'),
			'numero_cheque' => Yii::t('app', 'Numero Cheque'),
			'id_cuenta_banco' => Yii::t('app', 'Id Cuenta Banco'),
			'fecha' => Yii::t('app', 'Fecha'),
			'hora' => Yii::t('app', 'Hora'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_recuperar_cheque',$this->id_recuperar_cheque);

		$criteria->compare('id_cheque',$this->id_cheque);

		$criteria->compare('numero_cheque',$this->numero_cheque,true);

		$criteria->compare('id_cuenta_banco',$this->id_cuenta_banco);

		$criteria->compare('fecha',$this->fecha,true);

		$criteria->compare('hora',$this->hora,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
