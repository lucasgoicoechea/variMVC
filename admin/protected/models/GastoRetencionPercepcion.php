<?php

class GastoRetencionPercepcion extends CActiveRecord
{
	public $otroValor;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'gastos_retencion_percepcion';
	}

	public function rules()
	{
		return array(
			array('id_gasto, id_retencion_percepcion, valor', 'required'),
			array('id_gasto, id_retencion_percepcion', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>10),
			array('asentado,id_gasto_retencion_percepcion, id_gasto, id_retencion_percepcion, valor,alicuota', 'safe' 
					,'on'=>'search'
			),
		);
	}

	public function relations()
	{
		return array(
				'retencionPercepcion' => array (
						self::BELONGS_TO,
						'RetencionPercepcion',
						'id_retencion_percepcion'
				),'gasto' => array (
						self::BELONGS_TO,
						'Gasto',
						'id_gasto' 
						),
		);
	}
	public function getUrlDelete() {
		$url = Yii::app ()->createUrl ( 'gastoRetencionPercepcion/delete', array (
				'id' => $this->id_gasto_retencion_percepcion,
		) );
		return $url;
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
			'id_gasto_retencion_percepcion' => Yii::t('app', 'Id Gasto Retencion Percepcion'),
			'id_gasto' => Yii::t('app', 'Gasto'),
			'id_retencion_percepcion' => Yii::t('app', 'Retencion/Percepcion'),
			'valor' => Yii::t('app', 'Valor'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_gasto_retencion_percepcion',$this->id_gasto_retencion_percepcion);

		$criteria->compare('id_gasto',$this->id_gasto);

		$criteria->compare('id_retencion_percepcion',$this->id_retencion_percepcion);

		$criteria->compare('valor',$this->valor,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function searchWithGastoOO($idGasto){
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_gasto=' . $idGasto;
		//$criteria->order = ' id_pago_cheque desc ';
		$results = GastoRetencionPercepcion::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	
	public function searchWithGasto($idGasto)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id_gasto',$idGasto);
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

	public function getValores(){
		return CHtml::listData (RetencionPercepcionValores::model ()->findAll ( "id_retencion_percepcion=1"),'valor','valor');
	}
}
