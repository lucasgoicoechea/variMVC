<?php
class Tarjeta extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'tarjetas';
	}
	public function rules() {
		return array (
				array (
						'numero, titular,id_tipo_tarjeta',
						'required' 
				),
				array (
						'numero',
						'length',
						'max' => 80 
				),
				array (
						'titular',
						'length',
						'max' => 255 
				),
				array (
						'id_tarjeta, numero, titular,id_tipo_tarjeta',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'tipoTarjeta' => array (
						self::BELONGS_TO,
						'TipoTarjeta',
						'id_tipo_tarjeta' 
				) 
		);
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function attributeLabels() {
		return array (
				'id_tarjeta' => Yii::t ( 'app', 'Id Tarjeta' ),
				'numero' => Yii::t ( 'app', 'Numero' ),
				'titular' => Yii::t ( 'app', 'Titular' ),
				'id_tipo_tarjeta' => Yii::t ( 'app', 'Tipo Tarjeta' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_tarjeta', $this->id_tarjeta );
		
		$criteria->compare ( 'numero', $this->numero, true );
		
		$criteria->compare ( 'titular', $this->titular, true );
		
		$criteria->compare ( 'id_tipo_tarjeta', $this->id_tipo_tarjeta, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function getDescripcion() {
		return $this->numero.' - '.$this->titular;
	}
}
