<?php

class OrdenPagoGasto extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'orden_pago_gasto';
	}

	public function rules()
	{
		return array(
		array('id_orden_pago, id_gasto', 'required'),
		array('id_orden_pago, id_gasto', 'numerical', 'integerOnly'=>true),
		array('id_orden_pago_gasto, id_orden_pago, id_gasto', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
				'gasto' => array (
		self::BELONGS_TO,
						'Gasto',
						'id_gasto'
						),
				'ordenPago' => array (
						self::BELONGS_TO,
						'OrdenPago',
						'id_orden_pago'
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
			'id_orden_pago_gasto' => Yii::t('app', 'Id Orden Pago Gasto'),
			'id_orden_pago' => Yii::t('app', 'Id Orden Pago'),
			'id_gasto' => Yii::t('app', 'Id Gasto'),
		);
	}

	public function searchWithOrdenPago($idOrdenPago) {
		$results = OrdenPagoGasto::model()->searchWithOrdenPagoOO($idOrdenPago);
		if ($results == null) {
			return null;
		}
		$dataProvider = new CArrayDataProvider ( $results, array (
				'keyField' => 'id_orden_pago_gasto',
		/*'sort'=>array(
		 'attributes'=>array(
		 'apellido', 'nombre',
		 //'id'
		 ),
		 ),
		 'pagination'=>array(
		 'pageSize'=>12,
		 ),*/
		) );
		return $dataProvider;
	}
	public function searchWithOrdenPagoSinPaginar($idOrdenPago) {
		$results = OrdenPagoGasto::model()->searchWithOrdenPagoOO($idOrdenPago);
		if ($results == null) {
			return null;
		}
		$dataProvider = new CArrayDataProvider ( $results, array (
				'keyField' => 'id_orden_pago_gasto',
				'pagination'=>false
		) );
		return $dataProvider;
	}
	public function searchWithOrdenPagoOO($idOrdenPago) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_orden_pago=' . $idOrdenPago;
		$criteria->order = ' id_orden_pago_gasto desc ';
		$results = OrdenPagoGasto::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	
	public function searchGastos($idOrdenPago) {
		$criteria = new CDbCriteria ();
		//$criteria->condition = ' id_proveedor=' . $idProveedor;
		$criteria->condition = ' pagada=0';
		$criteria->order = ' id_gasto desc ';
		return new CActiveDataProvider('Gasto', array(
				'criteria' => $criteria,
		));
	}
public function searchOrdenPagoWithGasto($idGasto) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_gasto=' . $idGasto;
		$criteria->order = ' id_orden_pago_gasto desc ';
		$results = OrdenPagoGasto::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_orden_pago_gasto',$this->id_orden_pago_gasto);

		$criteria->compare('id_orden_pago',$this->id_orden_pago);

		$criteria->compare('id_gasto',$this->id_gasto);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	function ponerEnPagadoGastos($idOrdenPago) {
		$ops = OrdenPagoGasto::model()->searchWithOrdenPagoOO($idOrdenPago);
		if (sizeof ( $ops) > 0) {
		foreach ($ops as $op){
			Gasto::model()->ponerPagada($op->gasto->id_gasto);
		}}
	}

	function ponerEnNoPagadoGastos($idOrdenPago) {
		$ops = OrdenPagoGasto::model()->searchWithOrdenPagoOO($idOrdenPago);
		if (sizeof ( $ops) > 0) {
		foreach ($ops as $op){
			Gasto::model()->ponerNoPagada($op->gasto->id_gasto);
		}}
	}

	

	function sacarEnPagadoGastos($idOrdenPago) {
		$ops = OrdenPagoGasto::model()->searchWithOrdenPagoOO($idOrdenPago);
		if (sizeof ( $ops) > 0) {
		foreach ($ops as $op){
			Gasto::model()->sacarEnPago($op->gasto->id_gasto);
			$op->delete();
		}}}
	
}
