<?php

class PagoCheque extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pago_cheque';
	}

	public function rules()
	{
		return array(
		array('id_pago, id_cheque', 'required'),
		array('id_pago, id_cheque', 'numerical', 'integerOnly'=>true),
		array('id_pago_cheque, id_pago, id_cheque', 'safe', 'on'=>'search'),
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
				'cheque' => array (
						self::BELONGS_TO,
						'Cheque',
						'id_cheque'
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
			'id_pago_cheque' => Yii::t('app', 'Id Pago Cheque'),
			'id_pago' => Yii::t('app', 'Id Pago'),
			'id_cheque' => Yii::t('app', 'Id Cheque'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_pago_cheque',$this->id_pago_cheque);

		$criteria->compare('id_pago',$this->id_pago);

		$criteria->compare('id_cheque',$this->id_cheque);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchWithPago($idPago) {
		$results = PagoCheque::model()->searchWithPagoOO($idPago);
		if ($results == null) {
			return null;
		}
		$dataProvider = new CArrayDataProvider ( $results, array (
				'keyField' => 'id_pago_cheque',
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
		$criteria->order = ' id_pago_cheque desc ';
		$results = PagoCheque::model ()->findAll ( $criteria );
		if ($results == null) {
			return null;
		}
		return $results;
	}
	public function getChequesCajaIDCuentaID($id_caja, $idCuenta) {
		//son pagos qu estan Pagados y tienen fecha cobro la de la caja
		$criteria = new CDbCriteria ();
		//$criteria->condition = ' pagado=1  and  id_cuenta=' . $idCuenta.' and caja_id='.$id_caja;
		$criteria->condition = '  caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha_cobro', $fecha, $fecha );
		$cheq = PagoCheque::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $cheq) > 0) {
			foreach ( $cheq as $pagoc ) {
				if (! $pagoc->cheque->anulado && $pagoc->pago->id_cuenta==$idCuenta) {
					$result = $result + $pagoc->cheque->Importe;
				}
			}
		}
		return $result;
	}
	public function registrarReemplazo($id_chequeReemplazo,$id_pago){
		        $nuevo = new PagoCheque(); 
				$nuevo->id_pago = $id_pago;
				$nuevo->id_cheque = $id_chequeReemplazo;
				$exito = $nuevo->save ();
	}
	
}
