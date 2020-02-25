<?php
class Obra extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'obras';
	}
	public function rules() {
		return array (
				array (
						'Nombre, Direccion, id_tipo_obra, id_cliente, id_empresa',
						'required' 
				),
				array (
						'Codigo, id_tipo_obra, Avance, id_cliente, id_empresa',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'Nombre',
						'length',
						'max' => 60 
				),
				array (
						'Direccion, Localidad',
						'length',
						'max' => 100 
				),
				array (
						'Monto, Justiprecio',
						'length',
						'max' => 16 
				),
				array (
						'Detalles',
						'length',
						'max' => 510 
				),
				array (
						'FechaInicio, FechaFin,terminada,muestra_saldos',
						'safe' 
				),
				array (
						'id_obra, Codigo, Nombre, Direccion, Localidad, id_tipo_obra, Monto, FechaInicio, FechaFin, Justiprecio, Avance, Detalles, id_cliente, id_empresa,terminada,notificada,muestra_saldos',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array (
				'cheques' => array (
						self::HAS_MANY,
						'Cheque',
						'id_obra' 
				),
				'cobros' => array (
						self::HAS_MANY,
						'Cobro',
						'id_obra' 
				),
				'contratos' => array (
						self::HAS_MANY,
						'Contrato',
						'id_obra' 
				),
				'gastos' => array (
						self::HAS_MANY,
						'Gasto',
						'id_obra' 
				),
				'cliente' => array (
						self::BELONGS_TO,
						'Cliente',
						'id_cliente' 
				),
				'empresa' => array (
						self::BELONGS_TO,
						'Empresas',
						'id_empresa' 
				),
				'tipoObra' => array (
						self::BELONGS_TO,
						'TipoObra',
						'id_tipo_obra' 
				),
				'ordenesCompras' => array (
						self::HAS_MANY,
						'OrdenCompra',
						'id_obra' 
				),
				'recibos' => array (
						self::HAS_MANY,
						'Recibo',
						'id_obra' 
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
	public function getDescripcion() {
		return $this->Codigo . ' - ' . $this->Nombre;
	}
	public function attributeLabels() {
		return array (
				'id_obra' => Yii::t ( 'app', 'ID' ),
				'Codigo' => Yii::t ( 'app', 'Codigo' ),
				'Nombre' => Yii::t ( 'app', 'Nombre' ),
				'Direccion' => Yii::t ( 'app', 'Direccion' ),
				'Localidad' => Yii::t ( 'app', 'Localidad' ),
				'id_tipo_obra' => Yii::t ( 'app', 'Tipo Obra' ),
				'Monto' => Yii::t ( 'app', 'Monto' ),
				'FechaInicio' => Yii::t ( 'app', 'Fecha Inicio' ),
				'FechaFin' => Yii::t ( 'app', 'Fecha Fin' ),
				'Justiprecio' => Yii::t ( 'app', 'Justiprecio' ),
				'Avance' => Yii::t ( 'app', 'Avance' ),
				'Detalles' => Yii::t ( 'app', 'Detalles' ),
				'id_cliente' => Yii::t ( 'app', 'Cliente' ),
				'id_empresa' => Yii::t ( 'app', 'Empresa' ),
				'terminada' => Yii::t ( 'app', 'Terminada' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		$criteria->compare ( 'Codigo', $this->Codigo );
		
		$criteria->compare ( 'Nombre', $this->Nombre, true );
		
		$criteria->compare ( 'Direccion', $this->Direccion, true );
		
		$criteria->compare ( 'Localidad', $this->Localidad, true );
		
		$criteria->compare ( 'id_tipo_obra', $this->id_tipo_obra );
		
		$criteria->compare ( 'Monto', $this->Monto, true );
		
		$criteria->compare ( 'FechaInicio', $this->FechaInicio, true );
		
		$criteria->compare ( 'FechaFin', $this->FechaFin, true );
		
		$criteria->compare ( 'Justiprecio', $this->Justiprecio, true );
		
		$criteria->compare ( 'Avance', $this->Avance );
		
		$criteria->compare ( 'Detalles', $this->Detalles, true );
		
		$criteria->compare ( 'id_cliente', $this->id_cliente );
		
		$criteria->compare ( 'id_empresa', $this->id_empresa );
		$criteria->compare ( 'terminada', $this->terminada );
		$criteria->order = "FIELD(Codigo, 'DESC')";
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20 
				) 
		) );
	}
	public function revisarTerminadas() {
		$criteria = new CDbCriteria ();
		$criteria->addCondition( 'terminada=0' );
		$criteria->addCondition ( 'notificada=0');
		$fecha = date ( 'Y-m-j' );
		$nuevafecha = strtotime ( '+25 day', strtotime ( $fecha ) );
		$nuevafecha = date ( 'Y-m-j', $nuevafecha );
		$criteria->addCondition ( 'FechaFin<"' .$nuevafecha.'"');
		$results = Obra::model ()->findAll ( $criteria );
		if ($results != null) {
			foreach ($results as $obra){
				$com = new Comunicacion();
				$com->mensaje = 'EN 30 DÍAS FINALIZA OBRA: '.$obra->getDescripcion();
				$com->id_userslogin_destino = 19164;
				$com->id_userslogin_origen =19164;
				$com->save();
				Obra::model()->updateByPk
				($obra->id_obra,array("notificada"=>1));
			}
			
		}
	}
}
