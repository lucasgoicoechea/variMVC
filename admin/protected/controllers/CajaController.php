<?php
class CajaController extends Controller {
	public $layout = '//layouts/column2';
	private $_model;
	public function filters() {
		return array (
				'accessControl' 
		);
	}
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'index',
								'view' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'admin',
								'create',
								'update',
								'listarMovsDiarios',
								'cerrarCaja',
								'cierreDiariosCaja',
								'cierreDiariosCajaLink',
								'cierreDiariosCajaFecha',
								'movsDiariosEntreFechas',
								'calendarioCajas',
								'calendarEvents',
								'cierreDiariosCajaAnteriores',
								'imprimirCierreDiario',
								'imprimirCierreDiarioFechas',
								'deshacerUltimoCierre',
								'generarCajasHasta' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'delete' 
						),
						'users' => array (
								'admin' 
						) 
				),
				array (
						'deny',
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionView() {
		$this->render ( 'view', array (
				'model' => $this->loadModel () 
		) );
	}
	public function actionCreate() {
		$model = new Caja ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Caja'] )) {
			$model->attributes = $_POST ['Caja'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_caja 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Caja'] )) {
			$model->attributes = $_POST ['Caja'];
			
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id_caja 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionCerrarCaja() {
		// $id = $_GET ['id_caja'];
		$caja = Caja::model ()->getUltimaCaja ();
		$id = $caja->id_caja;
		// debe cerrar la caja y
		// llenar la tabla de acumulados
		// con los saldos
		Caja::model ()->updateByPk ( $id, array (
				"cerrada" => 1 
		) );
		$caja = Caja::model ()->findByPK ( $id );
		if ($caja != null) {
			$_POST ['Caja'] ['fecha'] = LGHelper::functions ()->displayFecha ( $caja->fecha );
			$this->redirect ( array (
					'caja/cierreDiariosCaja' 
			)
			// 'fecha' => $_POST ['Caja'] ['fecha']
			 );
			// $this->actionCierreDiariosCaja();
		}
	}
	public function actionDeshacerUltimoCierre() {
		Caja::deshacerUltimoCierre ();
		$this->redirect ( 'calendarioCajas' );
	}
	public function actionCierreDiariosCajaAnteriores($idCaja) {
		$caja = Caja::model ()->getByID ( $idCaja );
		$anteriores = $caja->getAnterioresPendientes ();
		
		foreach ( $anteriores as $anterior ) {
			Caja::model ()->updateByPk ( $anterior->id_caja, array (
					"cerrada" => 1 
			) );
			$cajaAnt = Caja::model ()->getCajaAnterior ( $anterior );
			CuentaSaldosAcumulado::model ()->calcularSaldosAcumulados ( $cajaAnt, $anterior->id_caja, $anterior );
		}
		$this->redirect ( 'calendarioCajas' );
	}
	public function actionCierreDiariosCajaFecha($fecha = null) {
		$model = Caja::model ()->getUltimaCaja ();
		if (isset ( $_POST ['Caja'] ['fecha'] )) {
			$_POST ['Caja'] ['fecha'] = LGHelper::functions ()->undisplayFecha ( $_POST ['Caja'] ['fecha'] );
			$model = Caja::model ()->getPorFecha ( $_POST ['Caja'] ['fecha'] );
		}
		$facturasNoCobradas = '';
		if (strlen ( $cajasAntAbiertas ) < 3) { // no tiene cajas
			$facturasNoCobradas = $model->facturasPendientes ();
		}
		$this->render ( 'movsDiarios', array (
				'model' => $model,
				'cierresPendientes' => $cajasAntAbiertas,
				'facturasPendientes' => $facturasNoCobradas 
		) );
	}
	public function actionCalendarioCajas() {
		$this->render ( 'calendarioCajas', array () )

		;
	}
	public function actionCierreDiariosCaja() { // getFacturasPendientes
		$this->layout = "//layouts/column1";
		$model = new Caja ();
		// $model = Caja::model ()->getPorFecha ( CTimestamp::formatDate ( 'Y-m-d' ) );
		$fechaCajaErrores = '';
		if (isset ( $_POST ['Caja'] ['fecha'] )) {
			$_POST ['Caja'] ['fecha'] = LGHelper::functions ()->undisplayFecha ( $_POST ['Caja'] ['fecha'] );
			$model = Caja::model ()->getPorFechaOrNull ( $_POST ['Caja'] ['fecha'] );
			if ($model == null) {
				$fechaCajaErrores = "FECHA DE CAJA: <B>" . LGHelper::functions ()->displayFecha ( $_POST ['Caja'] ['fecha'] ) . "</B> , <br>NO tiene Caja Abierta para esa Fecha o la Fecha es superior a la última Caja Abierta";
				$model = Caja::model ()->getUltimaCaja ();
			}
		} else
			$model = Caja::model ()->getUltimaCaja ();
			// $cajasAntAbiertas = $model->cajasAnterioresPendientes ();
		
		$facturasNoCobradas = '';
		$facturasNoCobradas = $model->facturasPendientes ();
		$this->render ( 'movsDiarios', array (
				'model' => $model,
				'errorFechaCaja' => $fechaCajaErrores,
				'facturasPendientes' => $facturasNoCobradas 
		) );
	}
	public function actionCierreDiariosCajaLink($idCaja) {
		$this->layout = "//layouts/column1";
		$model = Caja::model ()->getByID ( $idCaja );
		$cajasAntAbiertas = '';

		if ($model->id_caja != null) {
			if (isset ( $_POST ['Caja'] ['fecha'] )) {
				$_POST ['Caja'] ['fecha'] = LGHelper::functions ()->undisplayFecha ( $_POST ['Caja'] ['fecha'] );
				$model = Caja::model ()->getPorFechaOrNull ( $_POST ['Caja'] ['fecha'] );
				if ($model == null) {
					$fechaCajaErrores = "FECHA DE CAJA: <B>" . LGHelper::functions ()->displayFecha ( $_POST ['Caja'] ['fecha'] ) . "</B> , <br>NO tiene Caja Abierta para esa Fecha o la Fecha es superior a la última Caja Abierta";
					$model = Caja::model ()->getUltimaCaja ();
				}
			} else
				$model = Caja::model ()->getUltimaCaja ();
		}
		$facturasNoCobradas = '';
		$facturasNoCobradas = $model->facturasPendientes ();
		$this->render ( 'movsDiarios', array (
				'model' => $model,
				'cierresPendientes' => $cajasAntAbiertas,
				'facturasPendientes' => $facturasNoCobradas,
				'errorFechaCaja' => '' 
		) );
	}
	public function actionListarMovsDiarios() {
		$model = new Caja ();
		
		if (isset ( $_POST ['Caja'] ['fecha'] )) {
			$_POST ['Caja'] ['fecha'] = LGHelper::functions ()->undisplayFecha ( $_POST ['Caja'] ['fecha'] );
			$model = Caja::model ()->getPorFecha ( $_POST ['Caja'] ['fecha'] );
			echo $this->renderPartial ( '_movsDiarios', array (
					'model' => $model 
			) );
		}
		
		$this->renderPartial ( 'fechaSinCierreCaja', array (
				'model' => $model 
		) );
	}
	public function actionMovsDiariosEntreFechas() {
		$this->layout = "//layouts/column1";
		$model = new Caja ();
		if (isset ( $_POST ['Caja'] )) {
			$model->attributes = $_POST ['Caja'];
			$model->validate ();
		}
		$this->render ( 'movsDiariosFechas', array (
				'model' => $model 
		) );
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$this->loadModel ()->delete ();
			
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Caja' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Caja ( 'search' );
		if (isset ( $_GET ['Caja'] ))
			$model->attributes = $_GET ['Caja'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Caja::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'caja-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionGenerarCajasHasta(){
		Caja::generarCajas(CTimestamp::formatDate ( 'Y-m-d ' ));
		exit;
	}
	public function actionCalendarEvents() {
		$cajas = Caja::model ()->findAll ();
		foreach ( $cajas as $caja ) {
			$items [] = array (
					'title' => $caja->cerrada ? 'CERRADA' : 'CERRAR CAJA',
					'start' => $caja->fecha,
					'allDay' => true,
					'color' => $caja->cerrada ? '#CC0000' : '#1ab31a',
					'allDay' => true,
					'url' => Yii::app ()->createUrl ( 'caja/cierreDiariosCajaLink', array (
							'idCaja' => $caja->id_caja 
					) ) 
			);
			if (! $caja->cerrada) {
				$items [] = array (
						'title' => '<Cerrar Todo Anterior>',
						'start' => $caja->fecha,
						'allDay' => true,
						'color' => 'gray',
						'allDay' => true,
						'url' => Yii::app ()->createUrl ( 'caja/cierreDiariosCajaAnteriores', array (
								'idCaja' => $caja->id_caja 
						) ) 
				);
			}
		}
		/*
		 * $items[]=array(
		 * 'title'=>'Meeting',
		 * 'start'=>'2016-11-23',
		 * 'color'=>'#CC0000',
		 * 'allDay'=>true,
		 * 'url'=>'http://anyurl.com'
		 * );
		 * $items[]=array(
		 * 'title'=>'Meeting reminder',
		 * 'start'=>'2016-11-19',
		 * 'end'=>'2016-11-22',
		 *
		 * // can pass unix timestamp too
		 * // 'start'=>time()
		 *
		 * 'color'=>'blue',
		 * );*
		 */
		
		echo CJSON::encode ( $items );
		Yii::app ()->end ();
	}
	/* nueva action */
	public function actionImprimirCierreDiario() {
		$model = Caja::model ()->getByID ( $_GET ['id_caja'] );
		$titulo = 'IMPRESION MOVIMIENTOS DIARIOS - Caja día:' . LGHelper::functions ()->displayFecha ( $model->fecha );
		//$html = $this->renderPartial ( 'impresionMovsDiarios', array (
		$cajasAnt = $model->cajasAnterioresPendientes ();
		$htmls = array();
		$html = $this->renderPartial ( 'impresionCierreCaja', array (
				'model' => $model,
				'titulo' => $titulo,
				'cierresPendientes' => $cajasAnt 
		), true );
		$htmls[] = $html;
		$htmls[] = $this->renderPartial ( 'impresionCierreCajaGastos', array (
				'model' => $model,
				'titulo' => $titulo,
				'cierresPendientes' => $cajasAnt
		), true );
		$htmls[] = $this->renderPartial ( 'impresionCierreCajaTransferencias', array (
				'model' => $model,
				'titulo' => $titulo,
				'cierresPendientes' => $cajasAnt
		), true );
		$style = file_get_contents(Yii::app()->request->hostInfo.'/'.Yii::app()->theme->baseUrl.'/css/estilos-min.css');
		Yii::import('application.vendors.mpdf.*');
		Yii::setPathOfAlias('mpdf',Yii::getPathOfAlias('application.vendors.mpdf'));
		LGHelper::functions ()->generarPDFLandscapePages ( $htmls, $titulo,$style );
		exit ();
	}
	public function actionImprimirCierreDiarioFechas() {
		$model = new Caja ();
		$titulo = 'IMPRESION MOVIMIENTOS DIARIOS -';
		if (isset ( $_GET ['fechaDesde'] ) && strlen ( $_GET ['fechaDesde'] ) > 5) {
			$model->fechaDesde = $_GET ['fechaDesde'];
			$titulo = $titulo . ' desde Fecha: ' . LGHelper::functions ()->displayFecha ( $model->fechaDesde );
		} else
			$titulo = $titulo . ' desde Inicio de Activades, ';
		if (isset ( $_GET ['fechaHasta'] ) && strlen ( $_GET ['fechaHasta'] ) > 5) {
			$model->fechaHasta = $_GET ['fechaHasta'];
			$titulo = $titulo . ' hasta Fecha: ' . LGHelper::functions ()->displayFecha ( $model->fechaHasta );
		} else
			$titulo = $titulo . ' hasta la fecha Actual.';
		if (isset ( $_GET ['id_obra'] ) && strlen ( $_GET ['id_obra'] ) > 1) {
			$model->id_obra = $_GET ['id_obra'];
			// $model->validate ();
		}
		if (isset ( $_GET ['id_obra'] ) && strlen ( $_GET ['id_obra'] ) > 1) {
			$titulo = $titulo . ' <br> (Para la Obra:' . $model->obra->getDescripcion () . ')';
		}
		$contenido = $this->renderPartial ( 'impresionMovsDiariosFechasContent', array (
				'model' => $model,
				'titulo' => $titulo,
				'cierresPendientes' => $model->cajasAnterioresPendientes () 
		), true );
		$html = $this->renderPartial ( 'impresionMovsDiariosFechas', array (
				'titulo' => $titulo,
				'model' => $model,
				'contenido' => $contenido 
		), true );
		LGHelper::functions ()->generarPDFLandscape ( $html, $titulo );
		exit ();
	}
}
