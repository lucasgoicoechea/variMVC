<?php

class EfectivoPago extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'efectivo_pago';
	}

	
	public function rules()
	{
		return array(
			array('id_pago, monto', 'required'),
			array('id_pago', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>10),
			array('id_efectivo_pago, id_pago, monto,detalle', 'safe'),
					//'on'=>'search'),
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
			'id_efectivo_pago' => Yii::t('app', 'Id Efectivo Pago'),
			'id_pago' => Yii::t('app', 'Id Pago'),
			'monto' => Yii::t('app', 'Monto'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_efectivo_pago',$this->id_efectivo_pago);

		$criteria->compare('id_pago',$this->id_pago);

		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('detalle',$this->detalle,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function getUrlDelete() {
		$url = Yii::app ()->createUrl ( 'efectivoPago/delete', array (
				'id' => $this->id_efectivo_pago,
		) );
		return $url;
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
		return EfectivoPAgo::model()->findAll('id_pago='.$idPago);
	}

	public function getEfectivoPagoFechaCuentaID($fecha, $idCuenta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1  and  id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagos = Pago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$result = $result + Pago::model()->getTotalMontoEfectivo($pago->id_pago);
			}
		}
		return $result;
	}

	
	public function getEfectivoPagoCajaIDCuentaID($id_caja, $idCuenta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$cheq = EfectivoPago::model ()->findAll ( $criteria );
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
	
	
	public function afterFind() {
		$this->monto= LGHelper::functions ()->formatNumber ($this->monto);
		return parent::afterFind();
	}
	public function save() {
		$this->monto= LGHelper::functions ()->unformatNumber ($this->monto);
		return parent::save();
	}	
}
