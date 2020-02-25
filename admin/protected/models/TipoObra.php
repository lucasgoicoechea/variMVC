<?php

class TipoObra extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipoobra';
	}

	public function rules()
	{
		return array(
			array('codigo, nombre', 'required'),
			array('codigo', 'length', 'max'=>11),
			array('nombre', 'length', 'max'=>45),
			array('id_tipo_obra, codigo, nombre', 'safe', 'on'=>'search'),
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
			'id_tipo_obra' => Yii::t('app', 'Id Tipo Obra'),
			'codigo' => Yii::t('app', 'Codigo'),
			'nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_obra',$this->id_tipo_obra);

		$criteria->compare('codigo',$this->codigo,true);

		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
