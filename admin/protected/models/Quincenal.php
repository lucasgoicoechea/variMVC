<?php

class Quincenal extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'quincenal';
	}

	public function rules()
	{
		return array(
			array('descripcion', 'required'),
			array('anio, mes, quincena', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>80),
			array('id_quincenal, anio, mes, quincena, descripcion', 'safe', 'on'=>'search'),
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
			'id_quincenal' => Yii::t('app', 'Id Quincenal'),
			'anio' => Yii::t('app', 'Anio'),
			'mes' => Yii::t('app', 'Mes'),
			'quincena' => Yii::t('app', 'Quincena'),
			'descripcion' => Yii::t('app', 'Descripcion'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_quincenal',$this->id_quincenal);

		$criteria->compare('anio',$this->anio);

		$criteria->compare('mes',$this->mes);

		$criteria->compare('quincena',$this->quincena);

		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'anio DESC, mes  DESC, quincena',
			),
			'pagination' => array (
					'pageSize' => 50 
			) 

		));
	}

   public function nulear(){
	   $this->anio = null;
	   $this->mes = null;
	   $this->quincena=null;
   }
    public function getDescripcion(){
		$quincenad =$this->quincena==1?'Primera':'Segunda';
		return $quincenad.'-'.$this->mes.'-'.$this->anio;
	}

	public function getUrlQuincenas() {
		$url = Yii::app ()->createUrl ( 'quincena/adminQuincenal', array (
				'id_quincenal' => $this->id_quincenal 
		) );
		return $url;
	}
}
