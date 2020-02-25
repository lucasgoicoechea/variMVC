<?php

/**
 * This is the model class for table "transferencia".
 *
 * The followings are the available columns in table 'transferencia':
 * @property integer $id_transferencia
 * @property integer $id_cuenta_origen
 * @property integer $id_cuenta_destino
 * @property string $importe
 */
class Transferencia extends CActiveRecord {
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'transferencia';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'id_cuenta_origen, id_cuenta_destino, importe,fecha',
						'required' 
				),
				array (
						'id_cuenta_origen, id_cuenta_destino',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'importe',
						'length',
						'max' => 10 
				),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'asentado,id_transferencia, id_cuenta_origen, id_cuenta_destino, importe,descripcion',
						'safe',
						//'on' => 'search' 
				) 
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'cuentaOrigen' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta_origen' 
				),
				'cuentaDestino' => array (
						self::BELONGS_TO,
						'Cuenta',
						'id_cuenta_destino' 
				) 
		);
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id_transferencia' => 'Transferencia',
				'id_cuenta_origen' => 'Cuenta Origen',
				'id_cuenta_destino' => 'Cuenta Destino',
				'importe' => 'Importe',
				'descripcion' => 'En concepto de' 
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 *         based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_transferencia', $this->id_transferencia );
		$criteria->compare ( 'id_cuenta_origen', $this->id_cuenta_origen );
		$criteria->compare ( 'id_cuenta_destino', $this->id_cuenta_destino );
		$criteria->compare ( 'importe', $this->importe, true );
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		$criteria->order = ' t.id_transferencia DESC';
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return Transferencia the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getByFechaForCaja($fecha) {
		$criteria = new CDbCriteria ();
		$criteria->addBetweenCondition ( 'fecha', $fecha, $fecha );
		$result = Transferencia::model ()->findAll ( $criteria );
		$resultTmp  = array();
		if (sizeof($result)>0) {
		   foreach ($result as $transf){
		   	$tranOri = new TransferenciaForm();
		   	$tranOri->descripcion = $transf->descripcion;
		   	$tranOri->cuenta = $transf->cuentaOrigen;
		   	$tranOri->id_transferencia =$transf->id_transferencia ;
		   	$tranOri->importe = $num = -1 * abs($transf->importe) ;
		   	$tranDest = new TransferenciaForm();
		   	$tranDest->descripcion = $transf->descripcion;
		   	$tranDest->cuenta = $transf->cuentaDestino;
		   	$tranDest->id_transferencia =$transf->id_transferencia ;
		   	$tranDest->importe = $transf->importe ;
		   	$resultTmp[] =$tranOri;
		   	$resultTmp[] =$tranDest;
		   }	
		}
		return $resultTmp;
	}
	public function getBySaldoCuentaPorFecha($fecha,$cuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' id_cuenta_destino='.$cuenta.'  or  id_cuenta_origen=' . $cuenta;
		$criteria->addBetweenCondition ( 'fecha', $fecha, $fecha );
		$trans = Transferencia::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $trans ) > 0) {
			foreach ( $trans  as $tran) {
				$result = $result + ($tran->id_cuenta_origen==$cuenta?(-1*$tran->importe):$tran->importe);
			}
		}
		return $result;
	}
	
	public function getBySaldoCuentaPorCajaID($id_caja,$cuenta) {
		$criteria = new CDbCriteria ();
		$criteria->condition = ' (id_cuenta_destino='.$cuenta.'  or  id_cuenta_origen=' . $cuenta.') and caja_id='.$id_caja;
		//$criteria->addBetweenCondition ( 'fecha', $fecha, $fecha );
		$trans = Transferencia::model ()->findAll ( $criteria );
		$result = 0.00;
		if (sizeof ( $trans ) > 0) {
			foreach ( $trans  as $tran) {
				$result = $result + ($tran->id_cuenta_origen==$cuenta?(-1*$tran->importe):$tran->importe);
			}
		}
		return $result;
	}
	
	public function getEntreFechasForCaja($fechaDesde, $fechaHasta) {
		$criteria = new CDbCriteria ();
		if ($fechaDesde==null) {
			//inicio de activades, habrai que sacarlo de la empresa
			$fechaDesde ='2016-09-01';			
		}
		if ($fechaHasta==null) {
			$fechaHasta =CTimestamp::formatDate ( 'Y-m-d' );
		}
		//$criteria->addBetweenCondition ( 'fecha', $fechaDesde, $fechaHasta );
		$criteria->compare ( 't.fecha', '>=' . $fechaDesde, true );
		$criteria->compare ( 't.fecha', '<=' . $fechaHasta, true );
		
		$result = Transferencia::model ()->findAll ( $criteria );
		$resultTmp  = array();
		if (sizeof($result)>0) {
			foreach ($result as $transf){
				$tranOri = new TransferenciaForm();
				$tranOri->descripcion = $transf->descripcion;
				$tranOri->fecha = $transf->fecha;
				$tranOri->cuenta = $transf->cuentaOrigen;
				$tranOri->id_transferencia =$transf->id_transferencia ;
				$tranOri->importe = $num = -1 * abs($transf->importe) ;
				$tranDest = new TransferenciaForm();
				$tranDest->descripcion = $transf->descripcion;
				$tranDest->cuenta = $transf->cuentaDestino;
				$tranDest->id_transferencia =$transf->id_transferencia ;
				$tranDest->importe = $transf->importe ;
				$tranDest->fecha = $transf->fecha;
				$resultTmp[] =$tranOri;
				$resultTmp[] =$tranDest;
			}
		}
		return $resultTmp;
	}
	
	public function getUrlImprimir(){
        $url = Yii::app ()->createUrl ( 'transferencia/imprimir', array (
        		'id' => $this->id_transferencia,
        ) );
        return $url;
	}
	
}
