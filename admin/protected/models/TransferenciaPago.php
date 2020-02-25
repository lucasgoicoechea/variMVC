<?php
class TransferenciaPago extends CActiveRecord {
	
	public $fecha_cobro = null;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'transferencia_pago';
	}
	public function rules() {
		return array (
				array (
						//'id_cuenta_banco, referencia, monto, cbu_destino, id_pago',
						'id_cuenta_banco, id_pago',
						'required' 
				),
				array (
						'id_cuenta_banco, id_pago',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'referencia, cbu_destino',
						'length',
						'max' => 60 
				),
				array (
						'monto',
						'length',
						'max' => 10 
				),
				array (
						'asentado,id_transferencia_pago, id_cuenta_banco, referencia, monto, cbu_destino, id_pago,caja_id',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cuentaBanco' => array (
						self::BELONGS_TO,
						'CuentaBanco',
						'id_cuenta_banco' 
				),
				'pago' => array (
						self::BELONGS_TO,
						'Pago',
						'id_pago' 
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
	public function getUrlDelete() {
		$url = Yii::app ()->createUrl ( 'transferenciaPago/delete', array (
				'id' => $this->id_transferencia_pago 
		) );
		return $url;
	}
	public function attributeLabels() {
		return array (
				'id_transferencia_pago' => Yii::t ( 'app', 'Transferencia Pago' ),
				'id_cuenta_banco' => Yii::t ( 'app', 'Cuenta Banco' ),
				'referencia' => Yii::t ( 'app', 'Referencia' ),
				'monto' => Yii::t ( 'app', 'Monto' ),
				'cbu_destino' => Yii::t ( 'app', 'Cbu Destino' ),
				'id_pago' => Yii::t ( 'app', 'Pago' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_transferencia_pago', $this->id_transferencia_pago );
		
		$criteria->compare ( 'id_cuenta_banco', $this->id_cuenta_banco );
		
		$criteria->compare ( 'referencia', $this->referencia, true );
		
		$criteria->compare ( 'monto', $this->monto, true );
		
		$criteria->compare ( 'cbu_destino', $this->cbu_destino, true );
		
		$criteria->compare ( 'id_pago', $this->id_pago );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function searchWithPago($idPago) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'id_pago', $idPago );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
	public function searchWithPagoOO($idPago) {
		return TransferenciaPago::model ()->findAll ( 'id_pago=' . $idPago );
	}
	public function getTransferenciaFechaCuentaID($fecha, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1  and  id_cuenta=' . $idCuenta;
		$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagos = Pago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$result = $result + Pago::model ()->getTotalMontoTransfenrencia ( $pago->id_pago );
			}
		}
		return $result;
	}
	public function getTransferenciaCajaIDCuentaID($id_caja, $idCuenta) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		//$criteria->condition = ' pagado=1  and  id_cuenta=' . $idCuenta.' and caja_id='.$id_caja;
		$criteria->condition = ' caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagost = TransferenciaPago::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $pagost ) > 0) {
			foreach ( $pagost as $trans ) {
				if ($trans->pago->id_cuenta==$idCuenta) 
					$result = $result + LGHelper::functions ()->unformatNumber( $trans->monto); 
			}
		}
		return $result;
	}
	public function searchByEntreFechaSinPaginar ( $fechaDesde, $fechaHasta ) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1 ';
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fechaDesde, $fechaHasta );
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
		$transf = array ();
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$transfe = TransferenciaPago::model ()->searchWithPagoOO ( $pago->id_pago );
				if (sizeof ( $transfe ) > 0) {
					foreach ( $transfe as $tran ) {
						$tran->fecha_cobro= LGHelper::functions()->displayFecha($pago->fecha_cobro);
						$transf [] = $tran;
					}
				}
			}
			$dataProvider = new CArrayDataProvider ( $transf, array (
					'id' => 'nameThisProvider',
					'keyField' => 'id_transferencia_pago',
					'pagination' => false
			) );
		} else return null;
		// 		$dataProvider =  new CArrayDataProvider('TransferenciaPago');
		// 		$dataProvider->setData($transf);
		return $dataProvider;
	}
	public function searchByCajaID ( $cajaid) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' caja_id= '.$cajaid.' ';
		$transfe = TransferenciaPago::model ()->findAll ( $criteria );
		if (sizeof ( $transfe ) > 0) {
			foreach ( $transfe as $tran ) {
				$tran->fecha_cobro= LGHelper::functions()->displayFecha($tran->fecha_cobro);
				$transf [] = $tran;
			}
			$dataProvider = new CArrayDataProvider ( $transf, array (
					'id' => 'nameThisProvider',
					'keyField' => 'id_transferencia_pago',
					'pagination' => array (
							'pageSize' => 10
					)
			) );
		} else return null;
		return $dataProvider;
	}
	public function searchByEntreFecha ( $fechaDesde, $fechaHasta ) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1 ';
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fechaDesde, $fechaHasta );
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
		$transf = array ();
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$transfe = TransferenciaPago::model ()->searchWithPagoOO ( $pago->id_pago );
				if (sizeof ( $transfe ) > 0) {
					foreach ( $transfe as $tran ) {
						$tran->fecha_cobro= LGHelper::functions()->displayFecha($pago->fecha_cobro);
						$transf [] = $tran;
					}
				}
			}
			$dataProvider = new CArrayDataProvider ( $transf, array (
					'id' => 'nameThisProvider',
					'keyField' => 'id_transferencia_pago',
					'pagination' => array (
							'pageSize' => 10 
					) 
			) );
		} else return null;
// 		$dataProvider =  new CArrayDataProvider('TransferenciaPago');
// 		$dataProvider->setData($transf);
		return $dataProvider;
	}
	public function searchByFecha($fecha) {
		// son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		$criteria->condition = ' pagado=1 ';
		$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$pagos = Pago::model ()->findAll ( $criteria );
		$transf = array ();
		if (sizeof ( $pagos ) > 0) {
			foreach ( $pagos as $pago ) {
				$transfe = TransferenciaPago::model ()->searchWithPagoOO ( $pago->id_pago );
				if (sizeof ( $transfe ) > 0) {
					foreach ( $transfe as $tran ) {
						$transf [] = $tran;
					}
				}
			}
			$dataProvider = new CArrayDataProvider ( $transf, array (
					'id' => 'nameThisProvider',
					'keyField' => 'id_transferencia_pago',
					'pagination' => array (
							'pageSize' => 10
					)
			) );
		} else return null;
		// 		$dataProvider =  new CArrayDataProvider('TransferenciaPago');
		// 		$dataProvider->setData($transf);
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
