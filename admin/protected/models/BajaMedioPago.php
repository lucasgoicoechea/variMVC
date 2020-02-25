<?php

class BajaMedioPago extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'baja_medio_pago';
	}

	
	public function rules()
	{
		return array(
			array('id_pago, monto,tipo_medio_pago', 'required'),
			array('id_pago', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>10),
			array('tipo_medio_pago,id_baja_medio_pago,n_id_medio_pago, id_pago, monto,observacion,caja_id_origen,id_cuenta', 'safe'),
					//'on'=>'search'),
		);
	}

	public function relations() {
		return array (
	
				'formaPago' => array (
						self::BELONGS_TO,
						'FormaPago',
						'id_forma_pago'
				),
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta'
				),
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra'
				),			'pago' => array (
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

		//$criteria->compare('id_efectivo_pago',$this->id_efectivo_pago);

		//$criteria->compare('id_pago',$this->id_pago);

		//$criteria->compare('monto',$this->monto,true);
		//$criteria->compare('observacion',$this->observacion,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	
	public function searchWithPagoOO($idPago)
	{
		return EfectivoPAgo::model()->findAll('id_pago='.$idPago);
	}
	
	public function getBajaMedioPagoCajaIDCuentaID($id_caja, $idCuenta) {
		//son bajas pagos qu estan la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = 'id_cuenta='.$idCuenta.' and caja_id='.$id_caja;
		$cheq = BajaMedioPago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $cheq) > 0) {
			foreach ( $cheq as $pagoc ) {
					$result = $result + LGHelper::functions ()->unformatNumber ($pagoc->monto);
			}
		}
		return $result;
	}
	
	public static function  saveBajaEfectivoPago($efectivo_pago,$id_cuenta){
		$model=new BajaMedioPago();
		$model->tipo_medio_pago = 'EfectivoPago';
		$model->n_id_medio_pago=$efectivo_pago->id_efectivo_pago;
	    $model->id_pago=$efectivo_pago->id_pago; 
		$model->monto = $efectivo_pago->monto;
		$model->observacion=$efectivo_pago->detalle;
		$model->caja_id_origen=$efectivo_pago->caja_id;
		$model->id_cuenta=$id_cuenta;
		$model->save();
	}
	public static function  saveBajaTransferenciaPago($transf_pago,$id_cuenta){
		$model=new BajaMedioPago();
		$model->tipo_medio_pago = 'TransferenciaPago';
		$model->n_id_medio_pago=$transf_pago->id_transferencia_pago;
		$model->id_pago=$transf_pago->id_pago;
		$model->monto = $transf_pago->monto;
		$model->observacion='Cuenta Origen:'.id_cuenta_banco.'-Destino CBU:'.$transf_pago->cbu_destino.'--Referencia'.$transf_pago->referencia;
		$model->caja_id_origen=$transf_pago->caja_id;
		$model->id_cuenta=$id_cuenta;
		$model->save();
	}
	public static function  saveBajaChequePago($id_pago,$id_cheque,$id_cuenta,$monto,$caja_id){
		$model=new BajaMedioPago();
		$model->tipo_medio_pago = 'ChequePago';
		$model->n_id_medio_pago=$id_cheque;
		$model->id_pago=$id_pago;
		$model->monto = $monto;
		$model->caja_id_origen=$caja_id;
		$model->id_cuenta=$id_cuenta;
		$model->save();
	}
	public static function  saveBajaTarjetaPago($tarjeta_pago,$caja_id,$id_cuenta){
		$model=new BajaMedioPago();
		$model->tipo_medio_pago = 'TarjetaPago';
		$model->n_id_medio_pago=$tarjeta_pago->id_tarjeta;
		$model->id_pago=$tarjeta_pago->$id_pago;
		$model->monto = $tarjeta_pago->$monto;
		$model->caja_id_origen=$caja_id;
		$model->observacion=$tarjeta_pago->detalle.'-Fecha Pago:'.$tarjeta_pago->fecha_pago;
		$model->id_cuenta=$id_cuenta;
		$model->save();
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
