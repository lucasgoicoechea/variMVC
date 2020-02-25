<?php
 
class AsientosMovimientos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'vw_asientos_movimientos';
	}

	public function rules()
	{
		return array(
			array('tipo_asiento, id_tipo_asiento, caja_id,  monto, n_tipo_asiento, id_cuenta', 'required'),
			array('id,tipo_asiento, id_tipo_asiento, caja_id,  monto, n_tipo_asiento, id_cuenta', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'tipoAsiento' => array (
				self::BELONGS_TO,
				'TipoAsiento',
				'id_tipo_asiento' 
			),
			'cuenta' => array (
				self::BELONGS_TO,
				'Cuenta',
				'id_cuenta' 
			)
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
			'id_tipo_asiento' => Yii::t('app', 'Tipo Asiento'),
			'monto' => Yii::t('app', 'Monto'),
			'fecha_log' => Yii::t('app', 'Fecha Asiento'),
			'tipo_asiento' => Yii::t('app', 'Asiento'),
			'n_tipo_asiento' => Yii::t('app', 'Ident.'),
			'id_cuenta' => Yii::t('app', 'Cuenta'),
			
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->order = ' fecha_log desc ';
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 500
				) 
		) );
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
	public function getUrlCrearAsiento(){
		$controllerStr = TipoAsiento::model()->getControllerByTipo($this->id_tipo_asiento);
		$url = Yii::app ()->createUrl ( 'asientoBancario/crearAsiento', array (
			'id_tipo_asiento' => $this->id_tipo_asiento,
			'n_tipo_asiento' =>  $this->n_tipo_asiento
		) );
		return $url;
	}

	
	public function getFecha(){
		return LGHelper::functions ()->displayFecha(LGHelper::functions ()->formatDate($this->fecha_log));
	}
}
