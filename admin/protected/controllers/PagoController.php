<?php
class PagoController extends Controller {
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
								'create',
								'update',
								'admin',
								'agregarOrdenPago',
								'deleteOrdenPago',
								'agregarCheque',
								'agregarTransferenciaPago',
								'agregarEfectivoPago',
								'deleteCheque',
								'actualizarTotalesGrales',
								'agregarTarjetaPago',
								'imprimirPago',
									'modificarCheque',
								'anularCheque',
								'reemplazarCheque',
								'calcularFecha' ,
								'delete'
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
	public function actionAgregarOrdenPago() {
		$model = new PagoOrdenPago ();
		if (isset ( $_GET ['id_pago'] ))
			$model->id_pago = $_GET ['id_pago'];
		if (isset ( $_POST ['PagoOrdenPago'] ))
			$model->attributes = $_POST ['PagoOrdenPago'];
		$ordenPago = new OrdenPago ();
		$ordenPago->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['OrdenPago'] ))
			$ordenPago->attributes = $_GET ['OrdenPago'];
		if (! isset ( $_GET ['refresh'] )) {
			// $model= UsuariosEntrevistas::model()->findByPk($_GET['id']);
			if (isset ( $_POST ['orden-pago-grid_c0'] )) {
				$seleccionados = $_POST ['orden-pago-grid_c0'];
				$exito = true;
				foreach ( $seleccionados as $idOPgrid ) {
					$modelOP = new PagoOrdenPago ();
					$modelOP->id_pago = $model->id_pago;
					$modelOP->id_orden_pago = $idOPgrid;
					$exito = $modelOP->save ();
					if ($exito) {
						OrdenPago::model ()->agregarEnPago ( $modelOP->id_orden_pago );
					}
					if (! $exito) {
						Yii::app ()->user->setFlash ( 'mensaje', $modelOP->getErrors () );
						$errores = '';
						foreach ( $modelOP->getErrors () as $error )
							$errores = $errores . ' ' . $error;
						return $errores . $model->id_pago;
					}
				}
				echo "Ordenes de Pago agregadas";
				Yii::app ()->end ();
			}
			if (! empty ( $_GET ['asDialog'] ))
				$this->layout = '//layouts/main';
			$this->render ( 'adminOrdenPago', array (
					'ordenPago' => $ordenPago,
					'id_pago' => $model->id_pago,
					'model' => $model,
					'urlOperationAction' => 'pago/agregarOrdenPago/' . $_GET ['id_pago'],
					'grillaPosgrados' => 'list_ordenes_pago',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$resultadosEntrev = PagoOrdenPago::model ()->searchWithPago ( $model->id_pago );
			$montoTotalOP = 0.00;
			if ($resultadosEntrev != null) {
				$this->widget ( 'zii.widgets.CListView', array (
						'dataProvider' => $resultadosEntrev,
						// 'ajaxUpdate' => 'cv-id',
						'summaryText' => '<div class="header"> Cantidad de Ordenes de Pago	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
						// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
						'itemView' => '_viewOrdenPago',
						// 'viewData' => array( 'data' => null ),
						'ajaxUpdate' => false,
						// 'enablePagination'=>true
						'pager' => array (
								'header' => 'Ir a', // text before it
								'maxButtonCount' => 28 
						) 
				) );
				$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $model->id_pago );
				foreach ( $resultados as $value ) {
					$montoTotalOP = $montoTotalOP + $value->ordenPago->getMonto ();
				}
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalOP ) . '</b></div></div>';
			} else {
				echo "NO POSEE ORDENES DE PAGO SELECCIONADAS";
				$montoTotalOP = 0.00;
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber(  $montoTotalOP)  . '</b></div></div>';
			}
		}
	}
	public function actionAgregarTransferenciaPago() {
		$model = new TransferenciaPago ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$montoTotalTransferencias = Pago::model ()->getTotalMontoTransfenrencia ( $_GET ['id_pago'] );
			echo '<div class="contenedor-fila">			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - PAGOS CON TRANSFERENCIAS</label></b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalTransferencias) . '</b>
			</div>		</div>';
		} else {
			if (isset ( $_GET ['TransferenciaPago'] )) {
				$model->attributes = $_GET ['TransferenciaPago'];
				if (isset ( $_GET ['id_pago'] ))
					$model->id_pago = $_GET ['id_pago'];
				if ($model->save ())
					echo "Transferencia Registrada";
				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}
	public function actionModificarCheque() {
		$model = new Cheque ();
		if (isset ( $_GET ['id_pago'] ))
			$idPago = $_GET ['id_pago'];
		else
			echo "ALGO SIN ID PAGO";
		if (isset ( $_GET ['id_cheque'] )) {
			$model = Cheque::model ()->findbyPk ( $_GET ['id_cheque'] );
		}
		if ($model === null) {
			echo "ALGO SIN ID CHEQUE";
			//throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		} else {
			// $model->a_la_orden= $_GET['Cheque[a_la_orden]'];
			$model->attributes = $_GET ['Cheque'];
			$model->Importe = LGHelper::functions ()->unformatNumber($_GET ['Cheque']['Importe']);
			// echo $idPago;
			if ($model->save ()) {
				$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $idPago );
				$montoTotalCheque = 0.00;
				if ($resultadosEntrev != null) {
					$this->widget ( 'zii.widgets.CListView', array (
							'dataProvider' => $resultadosEntrev,
							'summaryText' => '<div class="header"> Cantidad de Cheques: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
							'itemView' => '_viewCheque',
							'ajaxUpdate' => false,
							'pager' => array (
									'header' => 'Ir a', // text before it
									'maxButtonCount' => 28 
							) 
					) );
					$resultados = PagoCheque::model ()->searchWithPagoOO ( $idPago );
					foreach ( $resultados as $value ) {
						if (! $value->cheque->anulado) {
							$montoTotalCheque = $montoTotalCheque + LGHelper::functions ()->unformatNumber( $value->cheque->Importe);
						}
					}
				}
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalCheque ) . '</b></div></div>';
			} else
				echo 'Error al modificar el Cheque: ' . $model->errors ();
		}
	}
	public function actionAgregarTarjetaPago() {
		$model = new TarjetaPago ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$montoTotalTarjeta = Pago::model ()->getTotalMontoTarjeta ( $_GET ['id_pago'] );
			echo '<div class="contenedor-fila">			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - PAGOS CON TARJETA</label></b> <b>$ ' .LGHelper::functions ()->formatNumber( $montoTotalTarjeta) . '</b>
			</div>		</div>';
		} else {
			if (isset ( $_GET ['TarjetaPago'] )) {
				$model->attributes = $_GET ['TarjetaPago'];
				$model->fecha_pago = LGHelper::functions()->undisplayFecha($_GET ['TarjetaPago']['fecha_pago']);
				if (isset ( $_GET ['id_pago'] ))
					$model->id_pago = $_GET ['id_pago'];
				if ($model->save ())
					echo "Pago con Tarjeta Registrado";
				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}
	public function actionCalcularFecha() {
		$model = new Cheque ();
		if (isset ( $_GET ['Cheque'] )) {
			$model->attributes = $_GET ['Cheque'];
			$hoy = $model->FechaPago = LGHelper::functions()->undisplayFecha($model->FechaEmision);
			$dias = $model->chequeDias->cantidad;
			// $result = $hoy->format('Y-m-d H:i:s' );
			$fechaFinal = LGHelper::functions ()->sumasdiasemana ( $hoy, $dias );
			$model->FechaPago = LGHelper::functions()->displayFecha($fechaFinal);
			return $this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
					'model' => '$model',
					'name' => 'Cheque[FechaPago]',
					'language' => 'es',
					'value' => $model->FechaPago,
					'htmlOptions' => array (
							'size' => 10,
							'style' => 'width:90px !important' 
					),
					'options' => array (
							'showButtonPanel' => true,
							'changeYear' => true,
							
					) 
			) );
			;
		}
	}
	public function actionAgregarEfectivoPago() {
		$model = new EfectivoPago ();
		if (isset ( $_GET ['refresh'] ) && $_GET ['refresh'] == true) {
			$montoTotalEfectivo = Pago::model ()->getTotalMontoEfectivo ( $_GET ['id_pago'] );
			echo '<div class="contenedor-fila">			<div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - PAGOS EN EFECTIVO</label></b> <b>$ ' . LGHelper::functions ()->formatNumber($montoTotalEfectivo) . '</b>
			</div>		</div>';
		} else {
			if (isset ( $_GET ['EfectivoPago'] )) {
				$model->attributes = $_GET ['EfectivoPago'];
				if (isset ( $_GET ['id_pago'] ))
					$model->id_pago = $_GET ['id_pago'];
				if ($model->save ())
					echo "Pago en Efectivo Registrado";
				else
					echo "Fallo al Registrar, motivo: " . print_r ( $model->getErrors () );
			} // debo pegarle los atributos impore, cuenta, cbu, etc
				  // y guardar luego actualiza la grilla
		}
	}
	public function actionAgregarCheque() {
		$model = new PagoCheque ();
		if (isset ( $_GET ['id_pago'] ))
			$model->id_pago = $_GET ['id_pago'];
		if (isset ( $_POST ['PagoCheque'] ))
			$model->attributes = $_POST ['PagoCheque'];
		$cheque = new Cheque ();
		$cheque->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Cheque'] ))
			$cheque->attributes = $_GET ['Cheque'];
		if (! isset ( $_GET ['refresh'] )) {
			if (isset ( $_POST ['cheque-grid_c0'] )) {
				$seleccionados = $_POST ['cheque-grid_c0'];
				$exito = true;
				foreach ( $seleccionados as $idChequegrid ) {
					$modelCheque = new PagoCheque ();
					$modelCheque->id_pago = $model->id_pago;
					$modelCheque->id_cheque = $idChequegrid;
					$exito = $modelCheque->save ();
					if ($exito) {
						Cheque::model ()->agregarEnPago ( $modelCheque->id_cheque, $modelCheque->id_pago );
					}
					if (! $exito) {
						Yii::app ()->user->setFlash ( 'mensaje', $modelCheque->getErrors () );
						$errores = '';
						foreach ( $modelOP->getErrors () as $error )
							$errores = $errores . ' ' . $error;
						return $errores . $model->id_pago;
					}
				}
				echo "Cheques agregados al Pago";
				Yii::app ()->end ();
			}
			if (! empty ( $_GET ['asDialog'] ))
				$this->layout = '//layouts/main';
			$this->render ( 'adminCheques', array (
					'cheque' => $cheque,
					'id_pago' => $_GET ['id_pago'],
					'model' => $model,
					'urlOperationAction' => 'pago/agregarCheque/' . $_GET ['id_pago'],
					'grillaPosgrados' => 'list_cheques',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$this->redibujarListaCheques ();
		}
	}
	public function actionReemplazarCheque() {
		$model = new PagoCheque ();
		$chequeOriginal = new Cheque ();
		if (isset ( $_GET ['id_pago'] ))
			$model->id_pago = $_GET ['id_pago'];
			// cheque original
		if (isset ( $_GET ['id_cheque'] ))
			$chequeOriginal = Cheque::model ()->findByPk ( $_GET ['id_cheque'] );
		else {
			echo $_GET ['id_cheque'];
			Yii::app ()->end ();
		}
		if (isset ( $_POST ['PagoCheque'] ))
			$model->attributes = $_POST ['PagoCheque'];
		$cheque = new Cheque ();
		$cheque->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Cheque'] ))
			$cheque->attributes = $_GET ['Cheque'];
		if (! isset ( $_GET ['refresh'] )) {
			// $model= UsuariosEntrevistas::model()->findByPk($_GET['id']);
			if (isset ( $_POST ['cheque-grid_c0'] )) {
				$seleccionados = $_POST ['cheque-grid_c0'];
				$exito = true;
				foreach ( $seleccionados as $idChequegrid ) {
					$modelCheque = new PagoCheque ();
					$modelCheque->id_pago = $model->id_pago;
					$modelCheque->id_cheque = $idChequegrid;
					$exito = $modelCheque->save ();
					if ($exito) {
						Cheque::model ()->agregarEnPago ( $modelCheque->id_cheque, $modelCheque->id_pago );
						Cheque::model ()->copiarParaReemplazo ( $chequeOriginal, $modelCheque->cheque );
					}
					if (! $exito) {
						Yii::app ()->user->setFlash ( 'mensaje', $modelCheque->getErrors () );
						$errores = '';
						foreach ( $modelOP->getErrors () as $error )
							$errores = $errores . ' ' . $error;
						return $errores . $model->id_pago;
					}
				}
				Cheque::model ()->anularCheque ( $chequeOriginal->id_cheque );
				echo "Cheques agregados al Pago";
				Yii::app ()->end ();
			}
			// if (! empty ( $_GET ['asDialog'] ))
			$this->layout = '//layouts/main';
			$this->render ( 'adminCheques', array (
					'cheque' => $cheque,
					'id_pago' => $_GET ['id_pago'],
					'model' => $model,
					'urlOperationAction' => 'pago/reemplazarCheque/id_pago/' . $_GET ['id_pago'] . '/id_cheque/' . $_GET ['id_cheque'],
					// 'urlOperationAction' => 'pago/reemplazarCheque/' . $_GET ['id_pago'],
					'grillaPosgrados' => 'list_cheques',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$this->redibujarListaCheques ();
		}
	}
	public function actionDeleteCheque() {
		$modelo = null;
		$model = new PagoCheque ();
		if (! isset ( $_GET ['refresh'] )) {
			if ($modelo === null) {
				if (isset ( $_GET ['id'] ))
					$modelo = PagoCheque::model ()->findbyPk ( $_GET ['id'] );
				if ($modelo === null)
					throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
			}
			if ($modelo != null) {
				$model = Pago::model ()->findbyPk ( $modelo->id_pago );
				$caja = Caja::model ()->getUltimaCaja ();
				if ($caja->id_caja!=$modelo->caja_id) {  //si la caja no es la caja abierta
					BajaMedioPago::saveBajaChequePago($modelo->id_pago,$modelo->id_cheque,$model->$id_cuenta,$modelo->monto,$caja->id_caja);
				}
				$modelo->delete ();
				Cheque::model ()->sacarEnPago ( $modelo->id_cheque );
			}
			$this->layout = '//layouts/main';
			$this->render ( 'deleteCheque', array (
					// 'ordenPago' => $ordenPago,
					'id_pago' => $model->id_pago,
					'model' => $model,
					'mensaje' => 'Cheque QUITADO DEL PAGO, presione Actualizar para ver la información',
					'urlOperationAction' => 'pago/deleteCheque/' . $_GET ['id'],
					'grillaPosgrados' => 'list_cheques',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$this->redibujarListaCheques ();
		}
	}
	public function actionAnularCheque() {
		$modelo = null;
		$model = new PagoCheque ();
		if (! isset ( $_GET ['refresh'] )) {
			if ($modelo === null) {
				if (isset ( $_GET ['id'] ))
					$modelo = PagoCheque::model ()->findbyPk ( $_GET ['id'] );
				if ($modelo === null)
					throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
			}
			if ($modelo != null) {
				$model = Pago::model ()->findbyPk ( $modelo->id_pago );
				// $modelo->delete ();
				Cheque::model ()->anularCheque ( $modelo->id_cheque );
			}
			$this->layout = '//layouts/main';
			$this->render ( 'deleteCheque', array (
					// 'ordenPago' => $ordenPago,
					'id_pago' => $model->id_pago,
					'model' => $model,
					'mensaje' => 'Cheque ANULADO CON EXITO, presione Actualizar para ver la información',
					'urlOperationAction' => 'pago/deleteCheque/' . $_GET ['id'],
					'grillaPosgrados' => 'list_cheques',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$this->redibujarListaCheques ();
		}
	}
	public function redibujarListaCheques() {
		$resultadosEntrev = PagoCheque::model ()->searchWithPago ( $_GET ['id_pago'] );
		if ($resultadosEntrev != null) {
			$this->widget ( 'zii.widgets.CListView', array (
					'dataProvider' => $resultadosEntrev,
					// 'ajaxUpdate' => 'cv-id',
					'summaryText' => '<div class="header"> Cantidad de Cheques	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
					// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
					'itemView' => '_viewCheque',
					// 'viewData' => array( 'data' => null ),
					'ajaxUpdate' => false,
					// 'enablePagination'=>true
					'pager' => array (
							'header' => 'Ir a', // text before it
							'maxButtonCount' => 28 
					) 
			) );
			$montoTotalCheque = 0.00;
			$resultados = PagoCheque::model ()->searchWithPagoOO ( $_GET ['id_pago'] );
			foreach ( $resultados as $value ) {
				if (! $value->cheque->anulado) {
					$montoTotalCheque = $montoTotalCheque + LGHelper::functions ()->unformatNumber($value->cheque->Importe);
				}
			}
			echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalCheque ) . '</b></div></div>';
		} else {
			echo "NO POSEE ORDENES DE PAGO SELECCIONADAS";
			$montoTotalCheque = 0.00;
			echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - CHEQUES</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalCheque ) . '</b></div></div>';
		}
	}
	public function actionActualizarTotalesGrales() {
		$idPago = $_GET ['id_pago'];
		$this->actualizarTotalesGrales ( $idPago );
	}
	public function actualizarTotalesGrales($idPago) {
		$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $idPago );
		$montoTotalPAGAR = 0.00;
		if (sizeof ( $resultados ) > 0) {
			foreach ( $resultados as $value ) {
				$montoTotalPAGAR = $montoTotalPAGAR + $value->ordenPago->getMonto ();
			}
		}
		$montoTotalPAGADO = Pago::model ()->getMontoPagadoID ( $idPago );
		
		echo '<div class="contenedor-fila">	<div style="background: white; border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 350px; text-align: center; padding: 5px;"
			class="contenedor-columna">
			<b><label>TOTAL A PAGAR</label></b> <b>$ ' . $montoTotalPAGAR  . '</b>
				</div>	<div
					style="background: white; border-radius: 25px; border: 2px solid rgb(115, 173, 33); width: 350px; text-align: center; padding: 5px;"
					class="contenedor-columna">
					<b><label>TOTAL PAGADO</label></b> <b>$ ' . $montoTotalPAGADO  . '</b>
				</div>	</div>	</div>';
	}
	public function actionDeleteOrdenPago() {
		$modelo = null;
		$model = new PagoOrdenPago ();
		if (! isset ( $_GET ['refresh'] )) {
			if ($modelo === null) {
				if (isset ( $_GET ['id'] ))
					$modelo = PagoOrdenPago::model ()->findbyPk ( $_GET ['id'] );
				if ($modelo === null)
					throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
			}
			if ($modelo != null) {
				$model = Pago::model ()->findbyPk ( $modelo->id_pago );
				$modelo->delete ();
				OrdenPago::model ()->sacarEnPago ( $modelo->id_orden_pago );
			}
			$this->layout = '//layouts/main';
			$this->render ( 'deleteOrdenPago', array (
					// 'ordenPago' => $ordenPago,
					'id_pago' => $model->id_pago,
					'model' => $model,
					'urlOperationAction' => 'pago/deleteOrdenPago/' . $_GET ['id'],
					'grillaPosgrados' => 'list_ordenes_pago',
					'conFormulario' => true,
					'htmloptionscheck' => array (
							'style' => "width: 100px" 
					) 
			), false );
		} else {
			$resultadosEntrev = PagoOrdenPago::model ()->searchWithPago ( $_GET ['id_pago'] );
			$montoTotalOP = 0.00;
			if ($resultadosEntrev != null) {
				$this->widget ( 'zii.widgets.CListView', array (
						'dataProvider' => $resultadosEntrev,
						// 'ajaxUpdate' => 'cv-id',
						'summaryText' => '<div class="header"> Cantidad de Ordenes de Pago	: ' . $resultadosEntrev->getTotalItemCount () . '</div>',
						// 'template'=>'{items}<span style="float:right;font-style:italic;font-size:11px;" >'. $resultados->getTotalItemCount() . 'items</span>{pager}',
						'itemView' => '_viewOrdenPago',
						// 'viewData' => array( 'data' => null ),
						'ajaxUpdate' => false,
						// 'enablePagination'=>true
						'pager' => array (
								'header' => 'Ir a', // text before it
								'maxButtonCount' => 28 
						) 
				) );
				$resultados = PagoOrdenPago::model ()->searchWithPagoOO ( $_GET ['id_pago'] );
				foreach ( $resultados as $value ) {
					$montoTotalOP = $montoTotalOP + $value->ordenPago->getMonto ();
				}
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalOP ) . '</b></div></div>';
			} else {
				echo "NO POSEE ORDENES DE PAGO SELECCIONADAS";
				$montoTotalOP = 0.00;
				echo '<div class="contenedor-fila"><div
				style="border-radius: 25px; border: 2px solid rgb(173, 45, 33); width: 650px; text-align: center; padding: 5px;"
				class="contenedor-columna-90">
				<b><label>MONTO TOTAL - ORDEN DE PAGO</label> </b> <b>$ ' . LGHelper::functions ()->formatNumber( $montoTotalOP ) . '</b></div></div>';
			}
		}
	}
	public function actionCreate() {
		$model = new Pago ();
		$id_lead_last = Yii::app ()->db->createCommand ( "SELECT MAX(`id_pago`) as `max` FROM `pagos` WHERE 1" )->queryScalar ();
		$id_lead_new = $id_lead_last + 1;
		$model->numero = $id_lead_new;
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Pago'] )) {
			$model->attributes = $_POST ['Pago'];
			$model->pagado = 0;
			$model->fecha_cobro = LGHelper::functions()->undisplayFecha($model->fecha_cobro);
			$model->fecha_emision = LGHelper::functions()->undisplayFecha($model->fecha_emision);
			if ($model->save ()){
				$newOP = OrdenPago::model ()->crearNuevaOP ( $model->id_pago );
				$newOP->id_cuenta = $model->id_cuenta;
				// Crear un numero de OP
				if ($newOP->save ()) {
					//crear nueva OP-Pago
					$pagoOP = new PagoOrdenPago ();
					$pagoOP->id_orden_pago = $newOP->id_orden_pago;
					$pagoOP->id_pago = $model->id_pago;
					if ($pagoOP->save ()) {
						$this->redirect ( array (
								'update',
								'id' => $model->id_pago 
						) );
					}
				}
			}
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	public function actionUpdate() {
		AdministradoresAccesos::model()->validateAcceso('pago/create');
		$model = $this->loadModel ();
		
		$this->performAjaxValidation ( $model );
		
		if (isset ( $_POST ['Pago'] )) {
			$model->attributes = $_POST ['Pago'];
			$model->fecha_cobro = LGHelper::functions()->undisplayFecha($model->fecha_cobro);
			$model->fecha_emision = LGHelper::functions()->undisplayFecha($model->fecha_emision);
			$modelOLD = Pago::model ()->findbyPk ( $model->id_pago );
			if ($modelOLD->id_cuenta!=$model->id_cuenta) {
				$modelOLD->cambiarCuentaMediosPago($model->id_cuenta);
			}
			if ($model->save ()) {
				//if ($model->pagado)
				if ($model->id_cuenta!=1) //1 -FACT A PAGAR
					//PagoOrdenPago::model ()->marcarComoPagadasOP ( $model->id_pago,$model->id_cuenta );
					PagoOrdenPago::model ()->marcarComoPagadasOP ( $model->id_pago);
				else 
					PagoOrdenPago::model ()->marcarComoNoPagadasOP ( $model->id_pago);
				$this->redirect ( array (
						'view',
						'id' => $model->id_pago 
				) );
			}
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionDelete() {
		if (Yii::app ()->request->isPostRequest) {
			$model = $this->loadModel ();
			$resultados=$model->getGastos();
			if (sizeof ( $resultados ) > 0) {
				foreach ( $resultados as $value ) {
					$value->borrarGastoConOPyPagos(); 
			        //PagoOrdenPago::model ()->sacarOPsdePago ( $model->id_pago );
				}
			}	
			$model->delete ();
			
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, Yii::t ( 'app', 'Invalid request. Please do not repeat this request again.' ) );
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Pago' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionAdmin() {
		$model = new Pago ( 'search' );
		if (isset ( $_GET ['Pago'] ))
			$model->attributes = $_GET ['Pago'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	public function actionImprimirPago() {
		$model = $this->loadModel ();
		$titulo = 'IMPRESION PAGO';
		$html = $this->renderPartial ( 'impresionPago', array (
				'titulo' => $titulo,
				'model' => $model 
		), true );
		LGHelper::functions ()->generarPDF ( $html, $titulo );
		exit ();
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Pago::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		return $this->_model;
	}
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'pago-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
