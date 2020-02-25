<?php

class RetencionPercepcionValores extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'retencion_percepcion_valores';
	}

	public function rules()
	{
		return array(
			array('id_retencion_percepcion, valor', 'required'),
			array('id_retencion_percepcion, valor', 'numerical', 'integerOnly'=>true),
			//array('usuario_log', 'length', 'max'=>60),
			array('id_retencion_percepcion_valores, id_retencion_percepcion, valor', 'safe', 'on'=>'search'),
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
			'id_retencion_percepcion_valores' => Yii::t('app', 'Id Retencion Percepcion Valores'),
			'id_retencion_percepcion' => Yii::t('app', 'Id Retencion Percepcion'),
			'valor' => Yii::t('app', 'Valor'),
			'usuario_log' => Yii::t('app', 'Usuario Log'),
			'fecha_log' => Yii::t('app', 'Fecha Log'),
		);
	}

	public function crearNuevaRetPercepValor($id_retencion_percepcion ,$valor){
		$valorREt = new RetencionPercepcionValores();
		$valorREt->id_retencion_percepcion = $id_retencion_percepcion;
		$valorREt->valor = $valor;
		$valorREt->save();
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_retencion_percepcion_valores',$this->id_retencion_percepcion_valores);

		$criteria->compare('id_retencion_percepcion',$this->id_retencion_percepcion);

		$criteria->compare('valor',$this->valor);

		$criteria->compare('usuario_log',$this->usuario_log,true);

		$criteria->compare('fecha_log',$this->fecha_log,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
