<?php

class CategoriaManoObra extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'categoria_mano_obra';
	}

	public function rules()
	{
		return array(
			array('id_categoria, Nombre', 'required'),
			array('id_categoria', 'numerical', 'integerOnly'=>true),
			array('ValorHora', 'numerical'),
			array('Nombre', 'length', 'max'=>60),
			array('id_categoria, Nombre, ValorHora', 'safe', 'on'=>'search'),
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
			'id_categoria' => Yii::t('app', 'Id Categoria'),
			'Nombre' => Yii::t('app', 'Nombre'),
			'ValorHora' => Yii::t('app', 'Valor Hora'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_categoria',$this->id_categoria);

		$criteria->compare('Nombre',$this->Nombre,true);

		$criteria->compare('ValorHora',$this->ValorHora);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
