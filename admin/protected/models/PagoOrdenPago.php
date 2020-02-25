<?php

class PagoOrdenPago extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pago_orden_pago';
	}

	public function rules()
	{
		return array(
		array('id_pago, id_orden_pago', 'required'),
		array('id_pago, id_orden_pago', 'numerical', 'integerOnly'=>true),
		array('id_pago_orden_pago, id_pago, id_orden_pago', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(

				'pago' => array (
		self::BELONGS_TO,
						'Pago',
						'id_pago'
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
			'id_pago_orden_pago' => Yii::t('app', 'Pago Orden Pago'),
			'id_pago' => Yii::t('app', 'Pago'),
			'id_orden_pago' => Yii::t('app', 'Orden Pago'),
		);
	}

	public function searchWithPago($idPago) {
		$results = PagoOrdenPago::model()->searchWithPagoOO($idPago);
		if ($results == null) {
			return null;
		}
		$dataProvider = new CArrayDataProvider ( $results, array (
				'keyField' => 'id_pago_orden_pago',
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
	public function searchWithPagoOO($idPago) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_pago=' . $idPago;
		$criteria->order = ' id_pago_orden_pago desc ';
		$results = PagoOrdenPago::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	
	
	public function getIDProveedorPorOP($idOP){
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_orden_pago=' . $idOP;
		$criteria->order = ' id_pago_orden_pago desc ';
		$criteria->limit = 1;
		$results = PagoOrdenPago::model ()->find ( $criteria );
		if ($results == null) {
			return null;
		}
		$pago = Pago::model()->find ( 'id_pago='.$results->id_pago );
		return $pago->id_proveedor;
	} 

	public function getUltimaOP($idPago) {
			$criteria = new CDbCriteria ();
		$criteria->condition = ' id_pago=' . $idPago;
		$criteria->order = ' id_pago_orden_pago desc ';
		$criteria->limit = 1;
		$results = PagoOrdenPago::model ()->find ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	public function searchWithOrdenPagoOO($idOrdenPago) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_orden_pago=' . $idOrdenPago;
		$criteria->order = ' id_pago_orden_pago desc ';
		$results = PagoOrdenPago::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_pago_orden_pago',$this->id_pago_orden_pago);

		$criteria->compare('id_pago',$this->id_pago);

		$criteria->compare('id_orden_pago',$this->id_orden_pago);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	//function marcarComoPagadasOP($idPago,$idCuenta) {
	function marcarComoPagadasOP($idPago) {
		$ops = PagoOrdenPago::model()->searchWithPagoOO($idPago);
		if (sizeof ( $ops) > 0) {
			foreach ($ops as $op){
				//OrdenPago::model()->ponerPagada($op->ordenPago->id_orden_pago,$idCuenta);
				OrdenPago::model()->ponerPagada($op->ordenPago->id_orden_pago);
			}}
	}
	function marcarComoNoPagadasOP($idPago) {
		$ops = PagoOrdenPago::model()->searchWithPagoOO($idPago);
		if (sizeof ( $ops) > 0) {
			foreach ($ops as $op){
				//OrdenPago::model()->ponerPagada($op->ordenPago->id_orden_pago,$idCuenta);
				OrdenPago::model()->ponerNoPagada($op->ordenPago->id_orden_pago);
			}}
	}
	

	function sacarOPsdePago($idPago) {
		$ops = PagoOrdenPago::model()->searchWithPagoOO($idPago);
		if (sizeof ( $ops) > 0) {
			foreach ($ops as $op){
				OrdenPago::model()->sacarEnPago($op->ordenPago->id_orden_pago);
				$op->delete();
			}}
	}
}
