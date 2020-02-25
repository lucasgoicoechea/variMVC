<?php

class CategoriaIVA extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'categoria_iva';
	}

	public function rules()
	{
		return array(
			array('id_categoria_iva, descripcion, exento', 'required'),
			array('id_categoria_iva, exento', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>200),
			array('id_categoria_iva, descripcion, exento,porcentaje_iva, codigo_afip', 'safe', 'on'=>'search'),
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
			'id_categoria_iva' => Yii::t('app', 'Id Categoria Iva'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'exento' => Yii::t('app', 'Exento'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_categoria_iva',$this->id_categoria_iva);

		$criteria->compare('descripcion',$this->descripcion,true);

		$criteria->compare('exento',$this->exento);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
