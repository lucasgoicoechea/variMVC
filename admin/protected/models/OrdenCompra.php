<?php
class OrdenCompra extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'ordenes_compra';
	}
	public function rules() {
		return array (
				array (
						'id_obra, id_proveedor,Fecha, Detalle',
						'required' 
				),
				array (
						'id_orden, numero_orden, id_obra, id_proveedor, Impresa, Pagada, id_empresa, id_material',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Cantidad',
						'length',
						'max' => 10 
				),
				array (
						'Detalle',
						'length',
						'max' => 4500 
				),
				array (
						'Atencion, Autorizo, Solicitado, Entrega',
						'length',
						'max' => 100 
				),
				array (
						'Recibe',
						'length',
						'max' => 40 
				),
				array (
						'id_orden, numero_orden, Fecha, id_obra, id_proveedor, Cantidad, Detalle, Atencion, Autorizo, Solicitado, Impresa, Entrega, Recibe, Pagada, id_empresa, id_material',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'material' => array (
						self::BELONGS_TO,
						'Material',
						'id_material' 
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
				'id_orden' => Yii::t ( 'app', 'Orden' ),
				'numero_orden' => Yii::t ( 'app', 'Numero Orden' ),
				'Fecha' => Yii::t ( 'app', 'Fecha' ),
				'id_obra' => Yii::t ( 'app', 'Obra' ),
				'id_proveedor' => Yii::t ( 'app', 'Proveedor' ),
				'Cantidad' => Yii::t ( 'app', 'Cantidad' ),
				'Detalle' => Yii::t ( 'app', 'Detalle' ),
				'Atencion' => Yii::t ( 'app', 'Atencion' ),
				'Autorizo' => Yii::t ( 'app', 'Autorizo' ),
				'Solicitado' => Yii::t ( 'app', 'Solicitado' ),
				'Impresa' => Yii::t ( 'app', 'Impresa' ),
				'Entrega' => Yii::t ( 'app', 'Lugar de Entrega' ),
				'Recibe' => Yii::t ( 'app', 'Recibe' ),
				'Pagada' => Yii::t ( 'app', 'Pagada' ),
				'id_empresa' => Yii::t ( 'app', 'Empresa' ),
				'id_material' => Yii::t ( 'app', 'Material' ) 
		);
	}
	
	public function getUrlImprimir() {
		$url = Yii::app ()->createUrl ( 'ordencompra/imprimirOrden', array (
				'id' => $this->id_orden,
		) );
		return $url;
	}
	
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_orden', $this->id_orden );
		
		$criteria->compare ( 'numero_orden', $this->numero_orden );
		
		$criteria->compare ( 'Fecha', $this->Fecha, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		
		$criteria->compare ( 'Cantidad', $this->Cantidad, true );
		
		$criteria->compare ( 'Detalle', $this->Detalle, true );
		
		$criteria->compare ( 'Atencion', $this->Atencion, true );
		
		$criteria->compare ( 'Autorizo', $this->Autorizo, true );
		
		$criteria->compare ( 'Solicitado', $this->Solicitado, true );
		
		$criteria->compare ( 'Impresa', $this->Impresa );
		
		$criteria->compare ( 'Entrega', $this->Entrega, true );
		
		$criteria->compare ( 'Recibe', $this->Recibe, true );
		
		$criteria->compare ( 'Pagada', $this->Pagada );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		
		$criteria->compare ( 'id_material', $this->id_material );
		
		$criteria->order = ' t.Fecha DESC';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
