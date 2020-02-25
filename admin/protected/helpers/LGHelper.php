<?php
class LGHelper {
	public static $_meHelper = NULL;
	public $openTabInstance = NULL;
	public static function functions() {
		if (LGHelper::$_meHelper == NULL)
			LGHelper::$_meHelper = new LGHelper ();
		return LGHelper::$_meHelper;
	}
	public function openTabs() {
		if (LGHelper::functions ()->openTabInstance == NULL)
			if (Yii::app ()->session ['openTabs'] == NULL)
				Yii::app ()->session ['openTabs'] = Yii::app ()->params ['openTabs'];
		LGHelper::functions ()->openTabInstance = Yii::app ()->session ['openTabs'];
		return LGHelper::functions ()->openTabInstance;
	}
	public function openTab($idTab = '0') {
		$arrayIds = LGHelper::functions ()->openTabs ();
		$idsArrray = explode ( ',', $arrayIds ); // LGHelper::functions()->openTabs());
		foreach ( $idsArrray as $term ) {
			if ($term == $idTab)
				return true;
		}
		return false;
	}
	function formatoImporte($valor) {
		// $formatter = new CFormatter;
		// $formatter->numberFormat = array('decimals'=>'2','decimalSeparator'=>',','thousandSeparator'=>'.');
		// return $formatter->number($valor);
		return LGHelper::functions ()->formatNumber ( $valor );
	}
	function sumasdiasemana($fecha, $dias) {
		$datestart = strtotime ( $fecha );
		$datesuma = 15 * 86400;
		$diasemana = date ( 'N', $datestart );
		$totaldias = $diasemana + $dias;
		// $findesemana = intval( $totaldias/5) *2 ;
		$findesemana = 0.00;
		$diasabado = $totaldias % 5;
		if ($diasabado == 6)
			$findesemana ++;
		if ($diasabado == 0)
			$findesemana = $findesemana - 2;
			// $total = (($dias+$findesemana) * 86400)+$datestart ;
		$total = (($dias) * 86400) + $datestart;
		return $twstart = date ( 'Y-m-d', $total );
	}
	public function setTap($tabsId) {
		Yii::app ()->session ['openTabs'] = $tabsId;
		LGHelper::functions ()->openTabInstance = $tabsId;
	}
	public function getYears() {
		$yearNow = date ( "Y" );
		$yearFrom = $yearNow - 100;
		$yearTo = $yearNow + 2;
		$arrYears = array ();
		
		foreach ( range ( $yearFrom, $yearTo ) as $number ) {
			$arrYears [$number] = $number;
		}
		
		$arrYears = array_reverse ( $arrYears, true );
		return $arrYears;
	}
	public function getYearsExisting() {
		$yearNow = date ( "Y" );
		$yearFrom = $yearNow - 100;
		$yearTo = $yearNow;
		$arrYears = array ();
		
		foreach ( range ( $yearFrom, $yearTo ) as $number ) {
			$arrYears [$number] = $number;
		}
		
		$arrYears = array_reverse ( $arrYears, true );
		return $arrYears;
	}
	public function getYearsExistingFrom($aniofrom) {
		$yearNow = date ( "Y" );
		$yearFrom = $aniofrom;
		$yearTo = $yearNow;
		$arrYears = array ();
		
		foreach ( range ( $yearFrom, $yearTo ) as $number ) {
			$arrYears [$number] = $number;
		}
		
		$arrYears = array_reverse ( $arrYears, true );
		return $arrYears;
	}
	public function getDaysResume() {
		$meses = array (
				'Sun' => 'DOM',
				'Mon' => 'LUN',
				'Tue' => 'MAR',
				'Wed' => 'MIE',
				'Thu' => 'JUE',
				'Fri' => 'VIE',
				'Sat' => 'SAB' 
		);
		return $meses;
	}
	public function getMonths() {
		$meses = array (
				"Enero",
				"Febrero",
				"Marzo",
				"Abril",
				"Mayo",
				"Junio",
				"Julio",
				"Agosto",
				"Septiembre",
				"Octubre",
				"Noviembre",
				"Diciembre" 
		);
		$nromes = 0;
		foreach ( $meses as $mes ) {
			$nromes ++;
			$arrMeses [$nromes] = $mes;
		}
		return $arrMeses;
	}
	public function getQuincenas() {
		$meses = array (
				"Primera",
				"Segunda" 
		);
		$nromes = 0;
		foreach ( $meses as $mes ) {
			$nromes ++;
			$arrMeses [$nromes] = $mes;
		}
		return $arrMeses;
	}
	public function getMonthLabel($mesNro) {
		$meses = array (
				"Enero",
				"Febrero",
				"Marzo",
				"Abril",
				"Mayo",
				"Junio",
				"Julio",
				"Agosto",
				"Septiembre",
				"Octubre",
				"Noviembre",
				"Diciembre" 
		);
		return $meses [$mesNro - 1];
	}
	public function getTipoIVA() {
		return array (
				"cf" => "Consumidor Final",
				"ex" => "Exento",
				"mon" => "Monotributo",
				"ri" => "Responsable Inscripto",
				"rno" => "Responsable no inscripto" 
		);
	}
	public function getGeneros() {
		return array (
				"Femenino" => "Femenino",
				"Masculino" => "Masculino" 
		);
	}
	public function enviarMailActivacionPassword($codigoActivacion, $apellido, $nombre, $usuario, $email) {
		$url = "http://www.prolab.unlp.edu.ar/prolabMVC/prolab/usersLogin/reactivacion/";
		$linkActive = $url . $codigoActivacion . '.html';
		$motivo = "PROLAB - Datos de Usuario";
		$cuerpo = "$apellido, $nombre.-\n";
		$cuerpo .= "Estos son sus datos de usuario en PROLAB\n\n";
		$cuerpo .= "Usuario: $usuario\n";
		$cuerpo .= "Activar, click siguiente: " . $linkActive . "\n";
		// $cuerpo.= "Password: $clave\n";
		$cuerpo .= "-------------------------------------\n";
		$cuerpo .= "IMPORTANTE: este es un mail automatico, por lo tanto no responda este correo.\n Muchas gracias, Prolab.";
		
		$to_email = "$email" . ";prolab.empresas@presi.unlp.edu.ar;prolab@presi.unlp.edu.ar"; // destino
		                                                                                      // $to_email = "$email";
		$msg = mail ( $to_email, $motivo, $cuerpo );
	}
	public function uploadToFTP($filename, $Local_Resource, $carpetaDesdeAdmin2) {
		$FTP_User = "www.graduados.unlp.edu.ar";
		$FTP_Pass = "3k2)c=ph";
		$FTP_Host = "www.graduados.unlp.edu.ar";
		$FTP_Root = "/htdocs/admin2/" . $carpetaDesdeAdmin2; // cv/files/";
		                                                     // $filesize = $_FILES['archivo_1']['size'];
		                                                     // if($filesize < $max){ if($filesize > 0){ if((ereg(".jpg", $filename)) || (ereg(".jpeg", $filename)) || (ereg(".JPEG", $filename)) || (ereg(".JPG", $filename))){
		$Connect = @ftp_connect ( $FTP_Host );
		ftp_login ( $Connect, $FTP_User, $FTP_Pass );
		$nombre_archivo = $FTP_Root . $filename;
		// $Local_Resource = $_FILES['archivo_1']['tmp_name'];
		if (ftp_put ( $Connect, $nombre_archivo, $Local_Resource, FTP_BINARY )) {
			return true;
		}
		return false;
	}
	public function getAllkeysDataProvider($dataProvider, $campoId) {
		$keys = array ();
		foreach ( $dataProvider->rawData as $i => $data )
			$keys [$i] = is_object ( $data ) ? $data->{$campoId} : $data [$campoId];
		return $keys;
	}
	public function getMenuData() {
		return Menu::model ()->getTreeItems ( null, false );
	}
	public function downloadHTML2PDF($html) {
		// mPDF
		// $mPDF1 = Yii::app()->ePdf->mpdf();
		$mPDF1 = Yii::app ()->ePdf->mpdf ( 'utf-8', 'A5' );
		$mPDF1->WriteHTML ( $html );
		$mPDF1->Output ();
	}
	public function generarPDFContinuado($html, $titulo, $styleshet = null) {
		LGHelper::$_meHelper->crearPDFContinuado ( $html, $titulo, true, $styleshet,true );
	}
	public function generarPDF($html, $titulo, $styleshet = null) {
		LGHelper::$_meHelper->crearPDF ( $html, $titulo, true, $styleshet );
	}
	public function generarPDFPages($html, $titulo, $styleshet = null) {
		LGHelper::$_meHelper->crearPDFPages ( $html, $titulo, true, $styleshet );
	}
	public function generarPDFLandscape($html, $titulo, $styleshet = null) {
		LGHelper::$_meHelper->crearPDF ( $html, $titulo, false, $styleshet );
	}
	public function generarPDFLandscapePages($html, $titulo, $styleshet = null) {
		LGHelper::$_meHelper->crearPDFPages ( $html, $titulo, false, $styleshet );
	}
	public function crearPDFPages($htmls, $titulo, $portrait = true, $styleshet = null) {
		/*Yii::import('application.vendors.mpdf.*');
		Yii::setPathOfAlias('mpdf',Yii::getPathOfAlias('application.vendors.mpdf'));
		require_once 'mpdf/mpdf.php';
		spl_autoload_unregister ( array (
			'YiiBase',
			'autoload' 
		) );*/
		
		$mPDF1 = null;
		if ($portrait) {
			$mPDF1 = Yii::app ()->ePdf->mpdf ( 'utf-8', 'A4', '', '', 5, 5, 35, 15, 9, 9, 'P' );
		} else {
			$mPDF1 = Yii::app ()->ePdf->mpdf ( 'utf-8', 'A4' );
		}
		//spl_autoload_register(array('YiiBase','autoload'));
		$mPDF1->useOnlyCoreFonts = true;
		$mPDF1->SetTitle ( $titulo );
		$mPDF1->SetAuthor ( "VARI - CONSTRUCCIÓN Y SERVICIOS" );
		$mPDF1->SetWatermarkText ( "VARI - CONSTRUCCIÓN Y SERVICIOS -- Teléfono:   0221 479-5664 " );
		$mPDF1->showWatermarkText = true;
		$mPDF1->watermark_font = 'DejaVuSansCondensed';
		$mPDF1->watermarkTextAlpha = 0.1;
		$mPDF1->SetDisplayMode ( 'fullpage', 'continuous' );
		$mPDF1->setAutoTopMargin = true;
		foreach ( $htmls as $html ) {
			if ($portrait){
				$mPDF1->AddPage ( 'P' );
			}
			else $mPDF1->AddPage ( 'L' );
			if ($styleshet != null) {
				$mPDF1->WriteHTML ( $styleshet, 1 );
			}
			$mPDF1->WriteHTML ( $html );
		}
		$mPDF1->Output ( 'Reporte_' . $titulo . date ( 'YmdHis' ) . '.pdf', 'I' );
	}

	public function crearPDFContinuado($html, $titulo, $portrait = true, $styleshet = null,$continuo=true) {
		LGHelper::$_meHelper->crearPDFContinuado ( $html, $titulo, true, $styleshet,$continuo );
	}
	public function crearPDF($html, $titulo, $portrait = true, $styleshet = null,$continuo=true) {
		/*
		 * Yii::import('application.vendors.mpdf.*');
		 * Yii::setPathOfAlias('mpdf',Yii::getPathOfAlias('application.vendors.mpdf'));
		 * require_once 'mpdf/mpdf.php';
		 * spl_autoload_register(array('YiiBase','autoload'));
		 */
                $mPDF1 = null;
		if ($portrait) {
			$mPDF1 = Yii::app ()->ePdf->mpdf ( 'utf-8', 'A4', '', '', 5, 5, 35, 15, 9, 9, 'P' );
		} else {
			$mPDF1 = Yii::app ()->ePdf->mpdf ( 'utf-8', 'A4' );
			$mPDF1->AddPage ( 'L' );
		}
		// $mPDF1 = Yii::app()->ePdf->mpdf('utf-8','A3');
		// Esto lo pueden configurar como quieren, para eso deben de entrar en la web de MPDF para ver todo lo que permite.
		$mPDF1->useOnlyCoreFonts = true;
		$mPDF1->SetTitle ( $titulo );
		$mPDF1->SetAuthor ( "VARI - CONSTRUCCIÓN Y SERVICIOS" );
		$mPDF1->SetWatermarkText ( "VARI - CONSTRUCCIÓN Y SERVICIOS -- Teléfono: 0221 479-5664 " );
		$mPDF1->showWatermarkText = true;
		$mPDF1->watermark_font = 'DejaVuSansCondensed';
		$mPDF1->watermarkTextAlpha = 0.1;
		if ($continuo){
		    $mPDF1->SetDisplayMode ( 'fullpage', 'continuous' );
		}
		$mPDF1->setAutoTopMargin = true;
		/*
		 * $mPDF1->setAutoBottomMargin = true;
		 * $mPDF1->autoMarginPadding = 4;
		 */
		if ($styleshet != null) {
			$mPDF1->WriteHTML ( $styleshet, 1 );
		}
		$mPDF1->WriteHTML ( $html );
		$mPDF1->Output ( 'Reporte_' . $titulo . date ( 'YmdHis' ) . '.pdf', 'I' );
	}
	public function generarDOC($html) {
		/**
		 * Example of use of HTML to docx converter
		 */
		Yii::import ( 'application.vendors.html2word.*' );
		Yii::setPathOfAlias ( 'phpword', Yii::getPathOfAlias ( 'application.vendors.html2word.phpword' ) );
		
		// Load the files we need:
		require_once 'phpword/PHPWord.php';
		require_once 'simplehtmldom/simple_html_dom.php';
		require_once 'htmltodocx_converter/h2d_htmlconverter.php';
		require_once 'example_files/styles.inc';
		
		// Functions to support this example.
		require_once 'documentation/support_functions.inc';
		
		// HTML fragment we want to parse:
		// $html = file_get_contents('example_files/example_html.html');
		// $html = file_get_contents('test/table.html');
		
		// New Word Document:
		spl_autoload_unregister ( array (
				'YiiBase',
				'autoload' 
		) );
		$phpword_object = new PHPWord ();
		spl_autoload_register ( array (
				'YiiBase',
				'autoload' 
		) );
		$section = $phpword_object->createSection ();
		
		// HTML Dom object:
		$html_dom = new simple_html_dom ();
		// $html_dom->load('<html><body>' . $html . '</body></html>');
		$html_dom->load ( '' . $html . '' );
		// Note, we needed to nest the html in a couple of dummy elements.
		
		// Create the dom array of elements which we are going to work on:
		$html_dom_array = $html_dom->find ( 'html', 0 )->children ();
		
		// We need this for setting base_root and base_path in the initial_state array
		// (below). We are using a function here (derived from Drupal) to create these
		// paths automatically - you may want to do something different in your
		// implementation. This function is in the included file
		// documentation/support_functions.inc.
		$paths = htmltodocx_paths ();
		
		// Provide some initial settings:
		$initial_state = array (
				// Required parameters:
				'phpword_object' => &$phpword_object, // Must be passed by reference.
				                                      // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
				                                      // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
				'base_root' => $paths ['base_root'],
				'base_path' => $paths ['base_path'],
				// Optional parameters - showing the defaults if you don't set anything:
				'current_style' => array (
						'size' => '11' 
				), // The PHPWord style on the top element - may be inherited by descendent elements.
				'parents' => array (
						0 => 'body' 
				), // Our parent is body.
				'list_depth' => 0, // This is the current depth of any current list.
				'context' => 'section', // Possible values - section, footer or header.
				'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
				'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
				'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
				'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
				'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
				'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
				                                  
				// Optional - no default:
				'style_sheet' => htmltodocx_styles_example () 
		); // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.

		
		// Convert the HTML and put it into the PHPWord object
		htmltodocx_insert_html ( $section, $html_dom_array [0]->nodes, $initial_state );
		
		// Clear the HTML dom object:
		$html_dom->clear ();
		unset ( $html_dom );
		
		// Save File
		$h2d_file_uri = tempnam ( '', 'htd' );
		$objWriter = PHPWord_IOFactory::createWriter ( $phpword_object, 'Word2007' );
		$objWriter->save ( $h2d_file_uri );
		
		// Download the file:
		header ( 'Content-Description: File Transfer' );
		header ( 'Content-Type: application/octet-stream' );
		header ( 'Content-Disposition: attachment; filename=example.docx' );
		header ( 'Content-Transfer-Encoding: binary' );
		header ( 'Expires: 0' );
		header ( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header ( 'Pragma: public' );
		header ( 'Content-Length: ' . filesize ( $h2d_file_uri ) );
		ob_clean ();
		flush ();
		$status = readfile ( $h2d_file_uri );
		unlink ( $h2d_file_uri );
		exit ();
	}
	public function generateDOCbyURL($variable_url) {
		$htmltodoc = new HTML_TO_DOC ();
		// echo $variable_url;
		// $htmltodoc->createDoc("reference1.html","test");
		$htmltodoc->createDocFromURL ( $variable_url, "descarga_word", true );
	}
	public function generateDOCByHTML($html, $titulo) {
		$htmltodoc = new HTML_TO_DOC ();
		// echo $variable_url;
		// $htmltodoc->createDoc("reference1.html","test");
		$htmltodoc->createDoc ( $html, $titulo, true );
	}
	// ################# FUNCION Q CONVIERTE LA CANTIDAD DE MESE EN LETRAS PARA EL CONTRATO ##################//
	public function num2letras($num, $fem = true, $dec = true) {
		$matuni [2] = "dos";
		$matuni [3] = "tres";
		$matuni [4] = "cuatro";
		$matuni [5] = "cinco";
		$matuni [6] = "seis";
		$matuni [7] = "siete";
		$matuni [8] = "ocho";
		$matuni [9] = "nueve";
		$matuni [10] = "diez";
		$matuni [11] = "once";
		$matuni [12] = "doce";
		$matuni [13] = "trece";
		$matuni [14] = "catorce";
		$matuni [15] = "quince";
		$matuni [16] = "dieciseis";
		$matuni [17] = "diecisiete";
		$matuni [18] = "dieciocho";
		$matuni [19] = "diecinueve";
		$matuni [20] = "veinte";
		$matunisub [2] = "dos";
		$matunisub [3] = "tres";
		$matunisub [4] = "cuatro";
		$matunisub [5] = "quin";
		$matunisub [6] = "seis";
		$matunisub [7] = "sete";
		$matunisub [8] = "ocho";
		$matunisub [9] = "nove";
		
		$matdec [2] = "veint";
		$matdec [3] = "treinta";
		$matdec [4] = "cuarenta";
		$matdec [5] = "cincuenta";
		$matdec [6] = "sesenta";
		$matdec [7] = "setenta";
		$matdec [8] = "ochenta";
		$matdec [9] = "noventa";
		$matsub [3] = 'mill';
		$matsub [5] = 'bill';
		$matsub [7] = 'mill';
		$matsub [9] = 'trill';
		$matsub [11] = 'mill';
		$matsub [13] = 'bill';
		$matsub [15] = 'mill';
		$matmil [4] = 'millones';
		$matmil [6] = 'billones';
		$matmil [7] = 'de billones';
		$matmil [8] = 'millones de billones';
		$matmil [10] = 'trillones';
		$matmil [11] = 'de trillones';
		
		$num = trim ( ( string ) @$num );
		if (isset ( $num [0] ) && $num [0] == '-') {
			$neg = 'menos ';
			$num = substr ( $num, 1 );
		} else
			$neg = '';
		while ( $num [0] == '0' )
			$num = substr ( $num, 1 );
		if ($num [0] < '1' or $num [0] > 9)
			$num = '0' . $num;
		$zeros = true;
		$punt = false;
		$ent = '';
		$fra = '';
		for($c = 0; $c < strlen ( $num ); $c ++) {
			$n = $num [$c];
			if (! (strpos ( ".,'''", $n ) === false)) {
				if ($punt)
					break;
				else {
					$punt = true;
					continue;
				}
			} elseif (! (strpos ( '0123456789', $n ) === false)) {
				if ($punt) {
					if ($n != '0')
						$zeros = false;
					$fra .= $n;
				} else
					
					$ent .= $n;
			} else
				
				break;
		}
		$ent = '     ' . $ent;
		if ($dec and $fra and ! $zeros) {
			$fin = ' coma';
			for($n = 0; $n < strlen ( $fra ); $n ++) {
				if (($s = $fra [$n]) == '0')
					$fin .= ' cero';
				elseif ($s == '1')
					$fin .= $fem ? ' una' : ' un';
				else
					$fin .= ' ' . $matuni [$s];
			}
		} else
			$fin = '';
		if (( int ) $ent === 0)
			return 'Cero ' . $fin;
		$tex = '';
		$sub = 0;
		$mils = 0;
		$neutro = false;
		while ( ($num = substr ( $ent, - 3 )) != '   ' ) {
			$ent = substr ( $ent, 0, - 3 );
			if (++ $sub < 3 and $fem) {
				$matuni [1] = 'una';
				$subcent = 'as';
			} else {
				$matuni [1] = $neutro ? 'un' : 'uno';
				$subcent = 'os';
			}
			$t = '';
			$n2 = substr ( $num, 1 );
			if ($n2 == '00') {
			} elseif ($n2 < 21)
				$t = ' ' . $matuni [( int ) $n2];
			elseif ($n2 < 30) {
				$n3 = $num [2];
				if ($n3 != 0)
					$t = 'i' . $matuni [$n3];
				$n2 = $num [1];
				$t = ' ' . $matdec [$n2] . $t;
			} else {
				$n3 = $num [2];
				if ($n3 != 0)
					$t = ' y ' . $matuni [$n3];
				$n2 = $num [1];
				$t = ' ' . $matdec [$n2] . $t;
			}
			$n = $num [0];
			if ($n == 1) {
				$t = ' ciento' . $t;
			} elseif ($n == 5) {
				$t = ' ' . $matunisub [$n] . 'ient' . $subcent . $t;
			} elseif ($n != 0) {
				$t = ' ' . $matunisub [$n] . 'cient' . $subcent . $t;
			}
			if ($sub == 1) {
			} elseif (! isset ( $matsub [$sub] )) {
				if ($num == 1) {
					$t = ' mil';
				} elseif ($num > 1) {
					$t .= ' mil';
				}
			} elseif ($num == 1) {
				$t .= ' ' . $matsub [$sub] . '?n';
			} elseif ($num > 1) {
				$t .= ' ' . $matsub [$sub] . 'ones';
			}
			if ($num == '000')
				$mils ++;
			elseif ($mils != 0) {
				if (isset ( $matmil [$sub] ))
					$t .= ' ' . $matmil [$sub];
				$mils = 0;
			}
			$neutro = true;
			$tex = $t . $tex;
		}
		$tex = $neg . substr ( $tex, 1 ) . $fin;
		return ucfirst ( strtoupper ( $tex ) );
	}
	public function dateToTimestamp($date) {
		// el date tiene q ser formato Y-m-d
		$ano = substr ( $date, 0, 4 );
		$mes = substr ( $date, 5, 2 );
		$dia = substr ( $date, 8, 2 );
		$timestamp = mktime ( 0, 0, 0, $mes, $dia, $ano );
		return $timestamp;
	}
	public function reformatDate($date) {
		if ($date == '0000-00-00') {
			$newDate = '00-00-0000';
			return $newDate;
		} elseif ($date == '') {
			return $date;
		} else {
			$newDate = date ( "d-m-Y", strtotime ( $date ) );
			return $newDate;
		}
	}
	
	/*
	 * *This method formats the date to the correct format according to the database
	 */
	public function formatDate($date) {
		if ($date == '00-00-0000') {
			$newDate = '0000-00-00';
			return $newDate;
		} elseif ($date == '') {
			return $date;
		} else {
			$newDate = date ( "Y-m-d", strtotime ( $date ) );
			return $newDate;
		}
	}
	public function displayFecha($fechaD) {
		if ($fechaD == '0000-00-00') {
			return null;
		}
		$fecha_partida = explode ( "-", $fechaD );
		if (strlen ( $fechaD ) > 5) {
			if (substr_count ( $fechaD, '/' ) > 0)
				return $fechaD;
			if (count ( $fecha_partida ) == 3) {
				$anio = $fecha_partida [0];
				$mes = $fecha_partida [1];
				$dia = $fecha_partida [2];
				$fechaD = $dia . "-" . $mes . "-" . $anio;
				$fechaD = date ( "d/m/Y", strtotime ( $fechaD ) ); // CDateTimeParser::parse($this->fechaDesde,'yyyy-mm-dd');
				if ($fechaD == null)
					$this->addError ( 'fecha', 'La fecha es requerida.' );
			}
		}
		return $fechaD;
	}
	public function undisplayFecha($fechaD) {
		if ($fechaD == '0000-00-00') {
			return null;
		}
		if (strlen ( $fechaD ) > 0) {
			if (substr_count ( $fechaD, '-' ) > 0)
				return $fechaD;
			$fecha_partida = explode ( "/", $fechaD );
			$dia = $fecha_partida [0];
			$mes = $fecha_partida [1];
			$anio = $fecha_partida [2];
			$fechaD = $mes . "/" . $dia . "/" . $anio;
			$fechaD = date ( "Y-m-d", strtotime ( $fechaD ) ); // CDateTimeParser::parse($this->fechaDesde,'yyyy-mm-dd');
			if ($fechaD == null)
				$this->addError ( 'fecha', 'La fecha es requerida.' );
		}
		return $fechaD;
	}
	
	/**
	 * and no separator between groups of thousands
	 */
	public $numberFormat = array (
			'decimals' => 2,
			'decimalSeparator' => ',',
			'thousandSeparator' => '.' 
	);
	
	/**
	 *
	 * @param mixed $value
	 *        	the value to be formatted
	 * @return string the formatted result
	 * @see numberFormat
	 *
	 */
	public function formatNumber($value) {
		if ($value === null)
			return null; // new
		if ($value === '')
			return ''; // new
		return number_format ( ( float ) $value, $this->numberFormat ['decimals'], $this->numberFormat ['decimalSeparator'], $this->numberFormat ['thousandSeparator'] );
	}
	
	/*
	 * new function unformatNumber():
	 * turns the given formatted number (string) into a float
	 */
	public function unformatNumber($formatted_number) {
		if ($formatted_number === null)
			return null;
		if ($formatted_number === '')
			return '';
		if (is_float ( $formatted_number ))
			return $formatted_number; // only 'unformat' if parameter is not float already
		
		$value = str_replace ( $this->numberFormat ['thousandSeparator'], '', $formatted_number );
		$value = str_replace ( $this->numberFormat ['decimalSeparator'], '.', $value );
		return ( float ) $value;
	}
	function compararFechas($primera, $segunda) {
		// formato 2017-01-13
		$primera = $primera->format ( 'Y-m-d' );
		$originalDate = "2010-03-21";
		$newDate = date ( "d-m-Y", strtotime ( $originalDate ) );
		$segunda = $segunda->format ( 'Y-m-d' );
		$valoresPrimera = explode ( "-", $primera );
		$valoresSegunda = explode ( "-", $segunda );
		$diaPrimera = $valoresPrimera [2];
		$mesPrimera = $valoresPrimera [1];
		$anyoPrimera = $valoresPrimera [0];
		$diaSegunda = $valoresSegunda [2];
		$mesSegunda = $valoresSegunda [1];
		$anyoSegunda = $valoresSegunda [0];
		$diasPrimeraJuliano = gregoriantojd ( $mesPrimera, $diaPrimera, $anyoPrimera );
		$diasSegundaJuliano = gregoriantojd ( $mesSegunda, $diaSegunda, $anyoSegunda );
		if (! checkdate ( $mesPrimera, $diaPrimera, $anyoPrimera )) {
			// "La fecha ".$primera." no es válida";
			return 0;
		} elseif (! checkdate ( $mesSegunda, $diaSegunda, $anyoSegunda )) {
			// "La fecha ".$segunda." no es válida";
			return 0;
		} else {
			return $diasPrimeraJuliano - $diasSegundaJuliano;
		}
	}
}

