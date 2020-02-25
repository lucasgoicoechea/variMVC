<?php

class RetencionPercepcion extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'retencion_percepcion';
	}

	public function rules()
	{
		return array(
			array('descripcion, es_porcentaje', 'required'),
			array('es_porcentaje', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>120),
			array('id_retencion_percepcion, descripcion, es_porcentaje', 'safe'
					//, 'on'=>'search'
					),
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
			'id_retencion_percepcion' => Yii::t('app', 'Id Retencion Percepcion'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'es_porcentaje' => Yii::t('app', 'Es Porcentaje'),
		);
	}
public function getDescripcionAbreviada(){
	return $this->descripcion;
}
// public function getImpuestosFijos(){
// 	return RetencionPercepcion::model()->find('impuesto_fijo=1');
// }
public function getAlicuota($valor){
	return $this->es_porcentaje?'% '.$valor:'$ '.$valor;
}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_retencion_percepcion',$this->id_retencion_percepcion);

		$criteria->compare('descripcion',$this->descripcion,true);

		$criteria->compare('es_porcentaje',$this->es_porcentaje);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
