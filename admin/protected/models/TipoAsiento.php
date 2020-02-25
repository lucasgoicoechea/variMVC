<?php

class TipoAsiento extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipo_asiento';
	}

	public function rules()
	{
		return array(
			array('nombre, codigo', 'required'),
			array('nombre', 'length', 'max'=>50),
			array('codigo', 'length', 'max'=>11),
			array('nombre, id_tipo_asiento, codigo,multiplicador,tabla_origen,controller_name', 'safe'),
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
			'id_tipo_asiento' => Yii::t('app', 'Id Tipo Gasto'),
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



	public static function getObjectByTipo($id){
		$class = TipoAsiento::getControllerByTipo($id);
		//echo $class;
		$zipClass = ucfirst($class);
		//$oo  = new $classname;
		$objZip = new $zipClass();
        //    Retrieve OVERWRITE and CREATE constants from the instantiated zip class
        //    This method of accessing constant values from a dynamic class should work with all appropriate versions of PHP
        //$oo = new ReflectionObject($objZip);
		//echo $classname.$oo==null?'null':$oo->tableName();
		return $objZip;
	}
	
	public static function getControllerByTipo($id){
		$ti= TipoAsiento::model()->findByPk($id);
		return $ti->controller_name;
	}
	
}
