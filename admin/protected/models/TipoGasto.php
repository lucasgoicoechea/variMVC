<?php

class TipoGasto extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipogasto';
	}

	public function rules()
	{
		return array(
			array('nombre, codigo', 'required'),
			array('nombre', 'length', 'max'=>50),
			array('codigo', 'length', 'max'=>11),
			array('nombre, id_tipo_gasto, codigo', 'safe', 'on'=>'search'),
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
			'nombre' => Yii::t('app', 'Nombre'),
			'id_tipo_gasto' => Yii::t('app', 'Id Tipo Gasto'),
			'codigo' => Yii::t('app', 'Codigo'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('id_tipo_gasto',$this->id_tipo_gasto);

		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 24	 
				) 
		) );
		}
}
