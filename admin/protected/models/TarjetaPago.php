<?php

class TarjetaPago extends CActiveRecord
{
    public $fecha_cobro = null;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tarjeta_pago';
	}

	public function rules()
	{
		return array(
			array('id_pago, monto, fecha_pago', 'required'),
			array('id_pago', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>10),
			array('id_tarjeta_pago, id_pago, monto, id_tarjeta,fecha_pago, detalle', 'safe'), //'on'=>'search'),
		);
	}

	public function relations()
	{
		return array('tarjeta' => array (
						self::BELONGS_TO,
						'Tarjeta',
						'id_tarjeta'
				),
				'pago' => array (
						self::BELONGS_TO,
						'Pago',
						'id_pago'
				),
		);
	}

	public function getUrlDelete() {
		$url = Yii::app ()->createUrl ( 'tarjetaPago/delete', array (
				'id' => $this->id_tarjeta_pago,
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
			'id_tarjeta_pago' => Yii::t('app', 'Tarjeta Pago'),
			'id_pago' => Yii::t('app', 'Pago'),
				'id_tarjeta' => Yii::t('app', 'Tarjeta'),
			'monto' => Yii::t('app', 'Monto'),
			'fecha_pago' => Yii::t('app', 'Fecha Pago'),
				'detalle' => Yii::t('app', 'Detalle'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_tarjeta_pago',$this->id_tarjeta_pago);

		$criteria->compare('id_pago',$this->id_pago);

		$criteria->compare('monto',$this->monto,true);

		$criteria->compare('fecha_pago',$this->fecha_pago,true);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('id_tarjeta',$this->id_tarjeta,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function searchWithPago($idPago)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id_pago',$idPago);
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchWithPagoOO($idPago)
	{
		return TarjetaPago::model()->findAll('id_pago='.$idPago);
	}

	public function 	getTarjetasPagoFechaCuentaID($fecha, $idCuenta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1  and  id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagos = Pago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$result = $result + Pago::model()->getTotalMontoTarjeta($pago->id_pago);
			}
		}
		return $result;
	}
	
	public function 	getTarjetasPagoCajaIDCuentaID($id_caja, $idCuenta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$cheq = TarjetaPago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $cheq) > 0) {
			foreach ( $cheq as $pagoc ) {
				if ($pagoc->pago->id_cuenta==$idCuenta) {
					$result = $result + LGHelper::functions ()->unformatNumber ($pagoc->monto);
				}
			}
		}
		return $result;
	}
	
	public function searchByFecha($fecha) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1 ';
		$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagos = Pago::model ()->findAll ( $criteria );
		$transf = array();
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$transfe = TarjetaPago::model()->searchWithPagoOO($pago->id_pago);
				if (sizeof ( $transfe ) > 0) {
					foreach ($transfe as $tran){
						$transf[]=$tran;
					}
				}
			}
		}
		else return null;
		$dataProvider = new CArrayDataProvider ( $transf, array (
				'id' => 'nameThisProvider',
				'keyField' => 'id_tarjeta_pago',
				'pagination' => array (
						'pageSize' => 10
				)
		) );
		return $dataProvider;
	}
	public function searchByCajaID($idcaja) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' caja_id= '.$idcaja.' ';
	    $transfe = TarjetaPago::model()->findAll ( $criteria );
				if (sizeof ( $transfe ) > 0) {
					foreach ($transfe as $tran){
						$transf[]=$tran;
					}
					}
					else return null;
		$dataProvider = new CArrayDataProvider ( $transf, array (
				'id' => 'nameThisProvider',
				'keyField' => 'id_tarjeta_pago',
				'pagination' => array (
						'pageSize' => 10
				)
		) );
		return $dataProvider;
	}
	public function searchByFechas($fechaDesde,$fechaHasta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1 ';
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		if ($fechaDesde==null) {
			//inicio de activades, habrai que sacarlo de la empresa
			$fechaDesde ='2016-09-01';
		}
		if ($fechaHasta==null) {
			$fechaHasta =CTimestamp::formatDate ( 'Y-m-d' );
		}
		$criteria->compare ( 't.fecha_cobro', '>=' . $fechaDesde, true );
		$criteria->compare ( 't.fecha_cobro', '<=' . $fechaHasta, true );
		$pagos = Pago::model ()->findAll ( $criteria );
		$transf = array();
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$transfe = TarjetaPago::model()->searchWithPagoOO($pago->id_pago);
				if (sizeof ( $transfe ) > 0) {
					foreach ($transfe as $tran){
						$tran->fecha_cobro= LGHelper::functions()->displayFecha($pago->fecha_cobro);
						$transf[]=$tran;
					}
				}
			}
		}
		else return null;
		$dataProvider = new CArrayDataProvider ( $transf, array (
				'id' => 'nameThisProvider',
				'keyField' => 'id_tarjeta_pago',
				'pagination' => array (
						'pageSize' => 10
				)
		) );
		return $dataProvider;
	}
	
	public function afterFind() {
		$this->monto= LGHelper::functions ()->formatNumber ($this->monto);
		return parent::afterFind();
	}
	public function save() {
		$this->monto= LGHelper::functions ()->unformatNumber ($this->monto);
		return parent::save();
	}
}
