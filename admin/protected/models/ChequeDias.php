<?php

class ChequeDias extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'cheque_dias';
	}

	public function rules()
	{
		return array(
			array('id_cheque_dias, descripcion, cantidad', 'required'),
			array('id_cheque_dias, cantidad', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>80),
			array('id_cheque_dias, descripcion, cantidad', 'safe', 'on'=>'search'),
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
			'id_cheque_dias' => Yii::t('app', 'Id Cheque Dias'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'cantidad' => Yii::t('app', 'Cantidad'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_cheque_dias',$this->id_cheque_dias);

		$criteria->compare('descripcion',$this->descripcion,true);

		$criteria->compare('cantidad',$this->cantidad);
		$criteria->order = ' t.cantidad ';
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
