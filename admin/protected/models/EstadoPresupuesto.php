<?php

class EstadoPresupuesto extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'estadospresupuestos';
	}

	public function rules()
	{
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>120),
			array('id_estado_presupuesto, nombre', 'safe', 'on'=>'search'),
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
			'id_estado_presupuesto' => Yii::t('app', 'Id Estado Presupuesto'),
			'nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_estado_presupuesto',$this->id_estado_presupuesto);

		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
