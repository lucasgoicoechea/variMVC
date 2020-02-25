<?php

class TipoComprobante extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tipocomprobante';
	}

	public function rules()
	{
		return array(
			array('Nombre', 'required'),
			array('Codigo', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>36),
			array('id_tipo_comprobante, Codigo, Nombre,formulario,iva_iibb_fijados', 'safe'//, 'on'=>'search'
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
			'id_tipo_comprobante' => Yii::t('app', 'Id Tipo Comprobante'),
			'Codigo' => Yii::t('app', 'Codigo'),
			'Nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_comprobante',$this->id_tipo_comprobante);

		$criteria->compare('Codigo',$this->Codigo);

		$criteria->compare('Nombre',$this->Nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFormularioSegunTipo($idTipoComprobante){
		$model=TipoComprobante::model()->find('id_tipo_comprobante='.$idTipoComprobante);
		if ($model != null) {
			return $model->formulario;
		}
	}
	public function getDescripcion(){
			return $this->Nombre;
	}
}
