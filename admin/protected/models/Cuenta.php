<?php
class Cuenta extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'cuentas';
	}
	public function rules() {
		return array (
				array (
						'Codigo, Nombre',
						'required' 
				),
				array (
						'Codigo,cerrada',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Nombre',
						'length',
						'max' => 40 
				),
				array (
						'id_cuenta, Codigo, Nombre,es_cobradora,es_administracion,cerrada',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cajas' => array (
						self::HAS_MANY,
						'Caja',
						'id_cuenta' 
				),
				'gastos' => array (
						self::HAS_MANY,
						'Gasto',
						'id_cuenta' 
				),
				'retiroscapital' => array (
						self::HAS_MANY,
						'RetiroCapital',
						'id_cuenta' 
				),
				'saldos' => array (
						self::HAS_ONE,
						'Saldo',
						'id_cuenta' 
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
				'id_cuenta' => Yii::t ( 'app', 'Id Cuenta' ),
				'Codigo' => Yii::t ( 'app', 'Codigo' ),
				'Nombre' => Yii::t ( 'app', 'Nombre' ) ,
				'cerrada' => Yii::t ( 'app', 'CERRADA' ) 
		);
	}
	public function getDescripcion(){
		return $this->Codigo." - ".$this->Nombre;
	}
	public function getCajaChica(){
		//ver bien esto...pq esta HARDCODE
		$criteria = new CDbCriteria ();
		$criteria->condition = ' Codigo=3 ';
		$results = Cuenta::model ()->find ( $criteria );
		return $results;
	}
	public function getCuentaCajaBanco(){
		//HARDCODE
		return 2;
	}
	public function getCuentaFacturasAPagar(){
		//HARDCODE
		return 1;
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		$criteria->compare ( 'cerrada', $this->cerrada);
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20 
				) 
		)
		 );
	}
	
	public function searchCerradas() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		
		$criteria->compare ( 'cerrada', 1 );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20
				)
		)
				);
	}
	
	public function searchAbiertas() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_cuenta', $this->id_cuenta );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		
		$criteria->compare ( 'cerrada', 0 );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20
				)
		)
				);
	}
}
