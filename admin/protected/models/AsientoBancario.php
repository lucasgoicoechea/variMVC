<?php

class AsientoBancario extends CActiveRecord
{
	public $saldoReal = 0.00;
	public $chequesAFuturo= 0.00;
	public $saldoActual = 0.00;
	public $saldoRestoApagar= 0.00;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'asiento_bancario';
	}

	
	public function rules()
	{
		return array(
			array('monto,', 'required'),
			array('n_tipo_asiento', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>10),
			array('tipo_asiento,id_asiento_bancario,id_tipo_asiento,n_tipo_asiento, monto,saldo,caja_id,id_cuenta', 'safe'),
					//'on'=>'search'),
		);
	}

	public function relations() {
		return array (
			'tipoAsiento' => array (
				self::BELONGS_TO,
				'TipoAsiento',
				'id_tipo_asiento' 
			),
				'cuenta' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta'
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
			'id_asiento_bancario' => Yii::t('app', 'Asiento Bancario'),
			'id_tipo_asiento' => Yii::t('app', 'Tipo Asiento'),
			'monto' => Yii::t('app', 'Monto'),
			'fecha_log' => Yii::t('app', 'Fecha Asiento'),
			'tipo_asiento' => Yii::t('app', 'Asiento'),
			'n_tipo_asiento' => Yii::t('app', 'Ident.'),
			'id_cuenta' => Yii::t('app', 'Cuenta'),
			'saldo' => Yii::t('app', 'Saldo'),
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

	public function getMovimientoOrigen(){
		$oo = TipoAsiento::model()->getObjectByTipo($this->id_tipo_asiento);
		$mov = $oo->findByPk($this->n_tipo_asiento);
		return $mov;
	}

    public function getUrlVerOrigen(){
		$controllerStr = TipoAsiento::model()->getControllerByTipo($this->id_tipo_asiento);
		$url = Yii::app ()->createUrl ( $controllerStr.'/view', array (
			'id' => $this->n_tipo_asiento 
		) );
		return $url;
	}
	public function getUrlBorrarAsiento(){
		$controllerStr = TipoAsiento::model()->getControllerByTipo($this->id_tipo_asiento);
		$url = Yii::app ()->createUrl ( 'asientoBancario/borrar', array (
			'id' => $this->id_asiento_bancario 
		) );
		return $url;
	}
	public function afterFind() {
		$this->monto= LGHelper::functions ()->formatNumber ($this->monto);
		return parent::afterFind();
	}
	public function save() {
		//$this->monto= LGHelper::functions ()->unformatNumber ($this->monto);
		return parent::save();
	}	
	public function calcularSaldos($dataObjs, $dataMovs ) {
		$this->saldoReal = 0.00;
		$this->saldoActual = 0.00;
		$this->chequesAFuturo = 0.00;
		$this->saldoRestoApagar = 0.00;
		foreach ($dataMovs as $aseintomovs){
			$monto = LGHelper::functions ()->unformatNumber ( $aseintomovs->monto );
			$this->saldoRestoApagar = $this->saldoRestoApagar + ($monto * $aseintomovs->tipoAsiento->multiplicador);
		}
		foreach ( $dataObjs as $asientobaco ) {
			$monto = LGHelper::functions ()->unformatNumber ( $asientobaco->monto );
			$this->saldoReal = $this->saldoReal + ($monto * $asientobaco->tipoAsiento->multiplicador);
			$this->saldoActual = $this->saldoActual + ($monto * $asientobaco->tipoAsiento->multiplicador);
			$this->chequesAFuturo = 0.00;
		}
		$this->saldoReal = LGHelper::functions ()->formatNumber ($this->saldoReal);
		$this->saldoActual = LGHelper::functions ()->formatNumber ($this->saldoActual);
		$this->chequesAFuturo = LGHelper::functions ()->formatNumber ($this->chequesAFuturo);
		$this->saldoRestoApagar = LGHelper::functions ()->formatNumber ($this->saldoRestoApagar);
		
	}

	public function getMonto(){
		$this->monto = LGHelper::functions ()->unformatNumber ( $this->monto  );
		$this->monto = $this->tipoAsiento!=null?($this->monto*$this->tipoAsiento->multiplicador):$this->monto;
		return LGHelper::functions ()->formatNumber ($this->monto);
	}

	public function getFecha(){
		return LGHelper::functions ()->displayFecha(LGHelper::functions ()->formatDate($this->fecha_log));
	}
}
