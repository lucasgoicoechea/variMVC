<?php

class PagoContrato extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pago_contrato';
	}

	public function rules()
	{
		return array(
			array('id_pago_contrato, id_pago, id_contratos, fecha_log', 'required'),
			array('id_pago_contrato, id_pago, id_contratos', 'numerical', 'integerOnly'=>true),
			array('usuario_log', 'length', 'max'=>60),
			array('id_pago_contrato, id_pago, id_contratos, usuario_log, fecha_log', 'safe', 'on'=>'search'),
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
			'id_pago_contrato' => Yii::t('app', 'Id Pago Contrato'),
			'id_pago' => Yii::t('app', 'Id Pago'),
			'id_contratos' => Yii::t('app', 'Id Contratos'),
			'usuario_log' => Yii::t('app', 'Usuario Log'),
			'fecha_log' => Yii::t('app', 'Fecha Log'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_pago_contrato',$this->id_pago_contrato);

		$criteria->compare('id_pago',$this->id_pago);

		$criteria->compare('id_contratos',$this->id_contratos);

		$criteria->compare('usuario_log',$this->usuario_log,true);

		$criteria->compare('fecha_log',$this->fecha_log,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
