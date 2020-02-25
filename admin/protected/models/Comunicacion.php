<?php

class Comunicacion extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'comunicacion_interna';
	}

	public function rules()
	{
		return array(
			array('mensaje, id_userslogin_destino', 'required'),
			array('id_userslogin_origen, id_userslogin_destino, leido', 'numerical', 'integerOnly'=>true),
			array('mensaje', 'length', 'max'=>360),
			array('id_comunicacion, mensaje, id_userslogin_origen, id_userslogin_destino, leido', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
				'destinatario' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'id_userslogin_destino'
				),
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
			'id_comunicacion' => Yii::t('app', 'Id Comunicacion'),
			'mensaje' => Yii::t('app', 'Mensaje'),
			'id_userslogin_origen' => Yii::t('app', 'Enviado por:'),
			'id_userslogin_destino' => Yii::t('app', 'Recibido por:'),
			'leido' => Yii::t('app', 'Leido'),
				'fecha_emision'=> Yii::t('app', 'Fecha'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_comunicacion',$this->id_comunicacion);

		$criteria->compare('mensaje',$this->mensaje,true);

		$criteria->compare('id_userslogin_origen',$this->id_userslogin_origen);

		$criteria->compare('id_userslogin_destino',$this->id_userslogin_destino);

		$criteria->compare('leido',$this->leido);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchEnviadasByUser($id_userslogin)
	{
		$criteria=new CDbCriteria;
	
		$criteria->compare('id_comunicacion',$this->id_comunicacion);
	
		$criteria->compare('mensaje',$this->mensaje,true);
	
		$criteria->compare('id_userslogin_origen',$id_userslogin);
	
		$criteria->compare('id_userslogin_destino',$this->id_userslogin_destino);
	
		$criteria->compare('leido',$this->leido);
		
		$criteria->order = ' leido  ';
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchRecibidasByUser($id_userslogin)
	{
		$criteria=new CDbCriteria;
	
		$criteria->compare('id_comunicacion',$this->id_comunicacion);
	
		$criteria->compare('mensaje',$this->mensaje,true);
	
		$criteria->compare('id_userslogin_origen',$this->id_userslogin_origen);
	
		$criteria->compare('id_userslogin_destino',$id_userslogin);
	
		$criteria->compare('leido',$this->leido);
		
		$criteria->order = ' leido  ';
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}
	public function marcaLeida($idComuni){
		Comunicacion::model()->updateByPk
		($idComuni,array("leido"=>1));
	}
	public function getUrlMarcarComoLeido(){
		$url = Yii::app ()->createUrl ( 'comunicacion/marcarLeido', array (
				'id' => $this->id_comunicacion,
		) );
		return $url;
	}
}
