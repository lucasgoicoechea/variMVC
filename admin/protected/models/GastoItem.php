<?php

class GastoItem extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations() {
		return array (
				'obra' => array (
						self::BELONGS_TO,
						'Obra',
						'id_obra' 
				),
				'proveedor' => array (
						self::BELONGS_TO,
						'Proveedor',
						'id_proveedor' 
				),
				'gasto' => array (
					self::BELONGS_TO,
					'Gasto',
					'id_gasto' 
			),	'material' => array (
				self::BELONGS_TO,
				'Material',
				'id_material' 
		),
			);
		}
	public function tableName()
	{
		return 'gasto_items';
	}

	public function rules()
	{
		return array(
			array('id_gasto_item, id_gasto,id_proveedor, id_obra, id_material, valor_unidad, cantidad, valor_final,consumido,usuario_log,fecha_log', 'safe'),
		);
	}

	public function getUrlDelete() {
		$url = Yii::app ()->createUrl ( 'gastoItem/delete', array (
				'id' => $this->id_gasto_item,
		) );
		return $url;
	}
	public function getUrlUpdate() {
		$url = Yii::app ()->createUrl ( 'gastoItem/update', array (
				'id' => $this->id_gasto_item,
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
		
		);
	}

	public function searchWithGasto($id_gasto){
		$criteria=new CDbCriteria;

		$criteria->compare('id_gasto',$id_gasto,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));		
	}

	public function searchWithObraByMaterial($idmaterial){
		/*$criteria=new CDbCriteria;

		$criteria->compare('id_obra',$this->id_obra,true);
		$criteria->compare('id_material',$idmaterial);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));*/
		if ($this->id_obra ==null)
			$gi = GastoItem::model()->findAll(	' id_material='.$idmaterial);
		else
			$gi = GastoItem::model()->findAll(	'id_obra='.$this->id_obra.' and id_material='.$idmaterial);
		return $gi;	
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_gasto_item',$this->id_gasto_item);

		$criteria->compare('id_gasto',$this->id_gasto,true);

		$criteria->compare('id_material',$this->id_material,true);

		$criteria->compare('id_obra',$this->id_obra);

		$criteria->compare('id_proveedor',$this->id_proveedor,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function nulearValores(){
		$this->cantidad = null;
		$this->valor_unidad =null;
		$this->valor_final = null;
		$this->consumido =null;
	}

	public function getDescripcionMaterial(){
		$material = Material::model()->findByPk($this->id_material);
		if ($material != null)
		    return $material->getDescripcionShort();
		return "SIN MATERIAL";
	}

	public function afterFind() {
		// Yii::log ( 'VALOR'.$this->Monto, CLogger::LEVEL_WARNING, 'MONTO-BD' );
		$this->cantidad =LGHelper::functions ()->formatNumber ( $this->cantidad );
		$this->valor_unidad  =LGHelper::functions ()->formatNumber ( $this->valor_unidad );
		$this->valor_final  =LGHelper::functions ()->formatNumber ( $this->valor_final );
		$this->consumido =LGHelper::functions ()->formatNumber ( $this->consumido );
		// Yii::log ( 'VALOR'.$this->Monto, CLogger::LEVEL_WARNING, 'MONTO-FORMAT' );
		return parent::afterFind ();
	}
	public function save() {
		
		$this->cantidad =LGHelper::functions ()->unformatNumber ( $this->cantidad );
		$this->valor_unidad  =LGHelper::functions ()->unformatNumber ( $this->valor_unidad );
		$this->valor_final  =LGHelper::functions ()->unformatNumber ( $this->valor_final );
		$this->consumido =LGHelper::functions ()->unformatNumber ( $this->consumido );
		
		return parent::save ();
	}

	public function searchGastoItemsSinPaginar($gasto) {
		$criteria = new CDbCriteria ();
		$criteria->distinct = true;
		$criteria->compare ( 'id_gasto_item', $this->id_gasto_item );
		$this->gasto=$gasto;
		$this->gasto->FechaAsiento = LGHelper::functions ()->undisplayFecha ( $gasto->FechaAsiento );
		if ($this->gasto->FechaAsiento != null)
			$criteria->compare ( 'gas.FechaAsiento', $this->gasto->FechaAsiento, true );
		
		$criteria->compare ( 'id_obra', $this->id_obra );
		
		if ($this->id_proveedor != null && $this->id_proveedor>0) {
			$criteria->compare ( 'id_proveedor', $this->id_proveedor );
		}
		//$criteria->compare ( 'NumComprobante', $this->NumComprobante, true );
		
		$criteria->compare ( 'gas.Monto', $this->gasto->Monto, true );
		$criteria->compare ( 'gas.pagada', $this->gasto->pagada );
		$criteria->compare ( 'gas.en_orden_pago', $this->gasto->en_orden_pago );
		if ($this->gasto->id_medio_pago != null) {
			$tipoMedioPago = MedioPago::model ()->findByPk ( $this->id_medio_pago );
			$criteria->join = $criteria->join . 'LEFT JOIN ' . Gasto::model ()->tableName () . ' gas ON gas.id_gasto=t.id_gasto ';
			$criteria->join = $criteria->join . 'LEFT JOIN ' . OrdenPagoGasto::model ()->tableName () . ' gc ON gc.id_gasto=t.id_gasto ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . PagoOrdenPago::model ()->tableName () . ' pop ON gc.id_orden_pago = pop.id_orden_pago ';
			$criteria->join = $criteria->join . ' LEFT JOIN ' . $tipoMedioPago->tabla_pk . ' tc ON tc.id_pago=pop.id_pago ';
			// $criteria->with = array('carreras' => array('condition'=>'idCarrera = '.$this->id_carrera,'together'=>true));
			$criteria->addCondition ( 'tc.id_pago IS NOT NULL' ); //
		}
		$this->gasto->fechaDesde = LGHelper::functions ()->undisplayFecha ( $this->gasto->fechaDesde );
		$this->gasto->fechaHasta = LGHelper::functions ()->undisplayFecha ( $this->gasto->fechaHasta );
		if ($this->gasto->fechaDesde != null)
			$criteria->compare ( 'gas.FechaFactura', '>=' . $this->gasto->fechaDesde, true );
		if ($this->gasto->fechaHasta != null)
			$criteria->compare ( 'gas.FechaFactura', '<=' . $this->gasto->fechaHasta, true );
		$this->gasto->fechaAsientoDesde = LGHelper::functions ()->undisplayFecha ($this->gasto->fechaAsientoDesde );
		$this->gasto->fechaAsientoHasta = LGHelper::functions ()->undisplayFecha ( $this->gasto->fechaAsientoHasta );
		if ($this->gasto->fechaAsientoDesde != null)
			$criteria->compare ( 'gas.FechaAsiento', '>=' . $this->gasto->fechaAsientoDesde, true );
		if ($this->gasto->fechaAsientoHasta != null)
			$criteria->compare ( 'gas.FechaAsiento', '<=' . $this->gasto->fechaAsientoHasta, true );
		$criteria->limit = 2000;
		//$criteria->order = ' FechaAsiento asc ';
		$gastos = new CActiveDataProvider ( 'GastoItem', array (
				'criteria' => $criteria,
				'pagination' => false ,
				'sort'=>array(
					    'defaultOrder'=>'id_material DESC',
					  )
				
		)
		 );
		return $gastos;
	}
	public function getProveedorDescripcion() {
		$prov = $this->proveedor != null ? $this->proveedor : new Proveedor ();
		return $prov->getDescripcion ();
	}
}
