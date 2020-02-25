<?php
/**
 * @created LGOICOECHEA para generar los excel
 */
class LGoicoExcel {
	public $phpExcelTmp;
	public $titleTmp;
	
	function __construct() {
		Yii::import ( 'ext.phpexcel.XPHPExcel' );
		Yii::import ( 'ext.phpexcel.Classes.PHPExcel.IOFactory' );
	}
	
	public function writeSheetTemplateWtihOutData($template, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles) {
		/*12-02-17
		$phpexcel_root=Yii::getPathOfAlias('application.extensions.phpexcel');
		require_once $phpexcel_root.'/XPHPExcel.php';
		require_once $phpexcel_root.'/PHPExcel/IOFactory.php';*/
		
		$objPHPExcel2 = XPHPExcel::createPHPExcel ();
		$objReader2 = PHPExcel_IOFactory::createReader ( 'Excel2007' );

		Yii::log ( 'LGOICOEXCEL2', CLogger::LEVEL_WARNING, 'EXCEL' );
		Yii::log ( 'LGOICOEXCEL:'.Yii::app ()->basePath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . "phpexcel" . DIRECTORY_SEPARATOR . "dp-template" . DIRECTORY_SEPARATOR . $template , CLogger::LEVEL_WARNING, 'EXCEL' );
		try{
			$objPHPExcel2 = $objReader2->load ( Yii::app ()->basePath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . "phpexcel" . DIRECTORY_SEPARATOR . "dp-template" . DIRECTORY_SEPARATOR . $template );
		}
		catch (Exception $e){
		Yii::log ($e->getMessage(), CLogger::LEVEL_WARNING, 'EXCEL' );
		}
		// $objPHPExcel->getProperties ()->setCreator ( $autor )->setLastModifiedBy ( $autor )->setTitle ( "Office 2007 XLSX Test Document" )->setSubject ( "Office 2007 XLSX Test Document" )->setDescription ( "Test document for Office 2007 XLSX, generated using PHP classes." )->setKeywords ( "office 2007 openxml php" )->setCategory ( $title );

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel2->setActiveSheetIndex ( 0 );
		$nTitles = count ( $titles );
		if ($nTitles > 0) // AGREGA TITULOS Y SUBTITULOS
{
			$rowTitle = 1;
			foreach ( $titles as $title ) {
				$rowTitle ++;
				$style = array (
						'alignment' => array (
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						),
						'font' => array (
								'bold' => true,
								'color' => array (
										'rgb' => 'CCCCCC' 
								),
								'size' => 14,
								'name' => 'Verdana' 
						),
						'borders' => array (
								'allborders' => array (
										'style' => 'thin' 
								) 
						) 
				); // PHPExcel_Style_Border::BORDER_THIN
				
				$range = 'A' . $rowTitle . ':' . 'M' . $rowTitle;
				$objPHPExcel2->getActiveSheet ()->setCellValue ( 'A' . $rowTitle, $title, true );
				$objPHPExcel2->getActiveSheet ()->getRowDimension ( $rowTitle )->setRowHeight ( 25 );
				$objPHPExcel2->getActiveSheet ()->mergeCells ( $range );
				$objPHPExcel2->getActiveSheet ()->getStyle ( $range )->applyFromArray ( $style );
			}
		}
		
		// agrego los headers
		$column = 0;
		// $column = LGoicoExcel::renderHeaders ( $objPHPExcel, $headers, $fromDataRow, $column );
		// Rename worksheet
		$objPHPExcel2->getActiveSheet ()->setTitle ( $titleSheet );
		foreach ( range ( 'A', 'Z' ) as $columnID ) {
			$objPHPExcel2->getActiveSheet ()->getColumnDimension ( $columnID )->setAutoSize ( true );
		}
		Yii::log ( 'LGOICOEXCEL', CLogger::LEVEL_WARNING, 'EXCEL' );
		return $objPHPExcel2;
	}
	public function writeSheetTemplate($template, $data, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles) {
		$objPHPExcel2 = XPHPExcel::createPHPExcel ();
		$objReader2 = PHPExcel_IOFactory::createReader ( 'Excel2007' );
		$objPHPExcel2 = $objReader2->load ( Yii::app ()->basePath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . "phpexcel" . DIRECTORY_SEPARATOR . "dp-template" . DIRECTORY_SEPARATOR . $template );
		// $objPHPExcel->getProperties ()->setCreator ( $autor )->setLastModifiedBy ( $autor )->setTitle ( "Office 2007 XLSX Test Document" )->setSubject ( "Office 2007 XLSX Test Document" )->setDescription ( "Test document for Office 2007 XLSX, generated using PHP classes." )->setKeywords ( "office 2007 openxml php" )->setCategory ( $title );
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel2->setActiveSheetIndex ( 0 );
		
		$n = count ( $data );
		$nTitles = count ( $titles );
		if ($nTitles > 0) // AGREGA TITULOS Y SUBTITULOS
{
			$rowTitle = 1;
			foreach ( $titles as $title ) {
				$rowTitle ++;
				$style = array (
						'alignment' => array (
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						),
						'font' => array (
								'bold' => true,
								'color' => array (
										'rgb' => 'CCCCCC' 
								),
								'size' => 14,
								'name' => 'Verdana' 
						),
						'borders' => array (
								'allborders' => array (
										'style' => 'thin' 
								) 
						) 
				); // PHPExcel_Style_Border::BORDER_THIN
				
				$range = 'A' . $rowTitle . ':' . 'M' . $rowTitle;
				$objPHPExcel2->getActiveSheet ()->setCellValue ( 'A' . $rowTitle, $title, true );
				$objPHPExcel2->getActiveSheet ()->getRowDimension ( $rowTitle )->setRowHeight ( 'auto' );
				$objPHPExcel2->getActiveSheet ()->mergeCells ( $range );
				$objPHPExcel2->getActiveSheet ()->getStyle ( $range )->applyFromArray ( $style );
			}
		}
		
		// agrego los headers
		$column = 0;
		// $column = LGoicoExcel::renderHeaders ( $objPHPExcel, $headers, $fromDataRow, $column );
		
		if ($n > 0) {
			$rowCount = $fromDataRow; // arranco abajo de los headers TODO ver cuanto
			$rowData = 0;
			for($rowCount; $rowCount < ($fromDataRow + $n); ++ $rowCount) {
				LGoicoExcel::renderRow ( $objPHPExcel2, $data, $rowData, $headers, $rowCount );
				$rowData ++;
			}
		}
		
		// Rename worksheet
		$objPHPExcel2->getActiveSheet ()->setTitle ( $titleSheet );
		foreach ( range ( 'A', 'Z' ) as $columnID ) {
			$objPHPExcel2->getActiveSheet ()->getColumnDimension ( $columnID )->setAutoSize ( true );
		}
		return $objPHPExcel2;
	}
	public function createSheetExcelTemplate($template, $data, $headers, $autor, $title, $titleSheet, $fromDataRow = 1, $titles) {
		$objPHPExcel12 = $this->writeSheetTemplate ( $template, $data, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		$worksheet12 = $objPHPExcel12->getActiveSheet ();
		$this->phpExcelTmp->addExternalSheet ( $worksheet12 );
	}
	public function createSheetExcelTemplateWithoutData($template,$headers, $autor, $title, $titleSheet, $fromDataRow = 1, $titles) {
		$objPHPExcel11 = $this->writeSheetTemplateWtihOutData($template, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles);
		$worksheet11 = $objPHPExcel11->getActiveSheet ();
		$this->phpExcelTmp->addExternalSheet ( $worksheet11 );
	}
	public function createExcelTemplate($template, $data, $headers, $autor, $title, $titleSheet, $fromDataRow = 1, $titles) {
		$objPHPExcel = $this->writeSheetTemplate ( $template, $data, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		$this->phpExcelTmp = $objPHPExcel;
		$this->titleTmp = $title;
	}
	public function createExcelTemplateWithoutData($template, $headers, $autor, $title, $titleSheet, $fromDataRow = 1, $titles) {
		$objPHPExcel = $this->writeSheetTemplateWtihOutData ( $template, $headers, $autor, $title, $titleSheet, $fromDataRow, $titles );
		$this->phpExcelTmp = $objPHPExcel;
		$this->titleTmp = $title;
		Yii::log ( 'LGOICOEXCEL3', CLogger::LEVEL_WARNING, 'EXCEL' );
	}
	public function downloadXLS() {
		// Redirect output to a clientâ€™s web browser (Excel5)
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . $this->titleTmp . '.xlsx"' );
		header ( 'Cache-Control: max-age=0' );
		// If you're serving to IE 9, then the following may be needed
		header ( 'Cache-Control: max-age=1' );
		
		// If you're serving to IE over SSL, then the following may be needed
		header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
		header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
		header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
		header ( 'Pragma: public' ); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->phpExcelTmp, 'Excel2007' );
		$objWriter->save ( 'php://output' );
		Yii::app ()->end ();
	}
	public function renderHeaders($objPHPExcel, $headers, $fromDataRow, $column = 0) {
		$objPHPExcel->getActiveSheet ()->getRowDimension ( $fromDataRow )->setRowHeight ( 'auto' );
		foreach ( $headers as $header ) // AGREGA LOS HEADERS DE LOS DAT
{
			if (is_array ( $header )) {
				$value = $header ['header'];
				
				$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $fromDataRow, $value );
				$objPHPExcel->getActiveSheet ()->getStyleByColumnAndRow ( $column, $fromDataRow, $column, $fromDataRow )->getFont ()->setBold ( true );
				if (is_array ( $header ['field'] )) {
					// merge para atras a fromDatarow+1
					// salto una linea de fromDataRow+1
					// consult count de $headers , y mergeo de
					// de ($column+ count de $header['field']) a count de $headers
					// y mergeo el padre por count de $header['field']
					for($i = 0; $i <= $column - 1; $i ++) {
						$objPHPExcel->getActiveSheet ()->mergeCellsByColumnAndRow ( $i, $fromDataRow, $i, $fromDataRow + 1 );
					}
					for($i = $column + count ( $header ['field'] ); $i <= count ( $headers ) + 1; $i ++) {
						$objPHPExcel->getActiveSheet ()->mergeCellsByColumnAndRow ( $i, $fromDataRow, $i, $fromDataRow + 1 );
					}
					$objPHPExcel->getActiveSheet ()->mergeCellsByColumnAndRow ( $column, $fromDataRow, $column + count ( $header ['field'] ) - 1, $fromDataRow );
					$column = LGoicoExcel::renderHeaders ( $objPHPExcel, $header ['field'], $fromDataRow + 1, $column );
				} else {
					$column ++;
				}
			} else {
				// Yii::log ( "HEADER:" .$header , CLogger::LEVEL_WARNING, 'EXCEL' );
				$value = $header;
				$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $fromDataRow, $value );
				$objPHPExcel->getActiveSheet ()->getStyleByColumnAndRow ( $column, $fromDataRow, $column, $fromDataRow )->getFont ()->setBold ( true );
				$column ++;
			}
		}
		return $column;
	}
	public function renderRow($objPHPExcel, $data, $row, $headers, $rowCount, $column = 0) {
		//Yii::log ( "ROW DATA:" . $row, CLogger::LEVEL_WARNING, 'EXCEL-DATA' );
		foreach ( $headers as $header ) {
			if (is_array ( $header )) {
				if (is_array ( $header ['field'] )) {
					$column = LGoicoExcel::renderRow ( $objPHPExcel, $data, $row, $header ['field'], $rowCount, $column );
				} elseif (strpos ( $header ['field'], '::' ) !== false) {
					//Yii::log ( "FIELD COMPUESTO:" . $header ['field'], CLogger::LEVEL_WARNING, 'EXCEL-DATA' );
					$partes = explode ( '::', $header ['field'] );
					$value = CHtml::value ( $data [$row]->{$partes [0]}, $partes [1] );
					$cell = $objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $rowCount, strip_tags ( $value ) );
					$column ++;
				} else {
					//Yii::log ( "FIELD SIMPLE:" . $header ['field'], CLogger::LEVEL_WARNING, 'EXCEL-DATA' );
					$value = CHtml::value ( $data [$row], $header ['field'] );
					$cell = $objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $rowCount, strip_tags ( $value ) );
					$column ++;
				}
			} else {
				//Yii::log ( "FIELD PURO:" . $header, CLogger::LEVEL_ERROR, 'EXCEL-DATA' );
				$value = CHtml::value ( $data [$row], $header );
				$cell = $objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $rowCount, strip_tags ( $value ) );
				$column ++;
			}
		}
		return $column;
	}
	public function writeSummary($label,$value,$rowCount, $column = 0, $horizontalAling = true){
		$this->phpExcelTmp->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $rowCount, strip_tags ( $label ) );

		$style = array (
				'alignment' => array (
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'font' => array (
						'bold' => true,
						'color' => array (
								'rgb' => 'AAAAAA'
						),
						'size' => 10,
						'name' => 'Arial'
				),
				'borders' => array (
						'allborders' => array (
								'style' => 'thin'
						)
				)
		); // PHPExcel_Style_Border::BORDER_THIN
		if ($horizontalAling){
			$this->phpExcelTmp->getActiveSheet ()->setCellValueByColumnAndRow ( $column+1, $rowCount, strip_tags ( $value ) );
			$this->phpExcelTmp->getActiveSheet ()->getStyleByColumnAndRow($column+1, $rowCount,$column+1, $rowCount)->applyFromArray ( $style );
		}
		else {
			$this->phpExcelTmp->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $rowCount+1, strip_tags ( $value ) );
			$this->phpExcelTmp->getActiveSheet ()->getStyleByColumnAndRow($column, $rowCount+1,$column, $rowCount+1)->applyFromArray ( $style );
		}		
	}
	public function writeCell($value,$row,$column){
		$this->phpExcelTmp->getActiveSheet ()->setCellValueByColumnAndRow ( $column, $row, strip_tags ( $value ) );
	}
	public function renderRowCDataColumn($objPHPExcel, $data, $row, $headers) {
		$a = 0;
		foreach ( $headers as $n => $column ) {
			if ($column instanceof CLinkColumn) {
				if ($column->labelExpression !== null)
					$value = $column->evaluateExpression ( $column->labelExpression, array (
							'data' => $data [$row],
							'row' => $row 
					) );
				else
					$value = $column->label;
			} elseif ($column instanceof CButtonColumn)
				$value = ""; // Dont know what to do with buttons
			elseif ($column->value !== null)
				$value = $this->evaluateExpression ( $column->value, array (
						'data' => $data [$row] 
				) );
			elseif ($column->name !== null) {
				// $value=$data[$row][$column->name];
				$value = CHtml::value ( $data [$row], $column->name );
				$value = $value === null ? "" : $column->grid->getFormatter ()->format ( $value, 'raw' );
			}
			
			$a ++;
			$cell = $objPHPExcel->getActiveSheet ()->setCellValue ( $this->columnName ( $a ) . ($row + 2), strip_tags ( $value ), true );
			if (is_callable ( $this->onRenderDataCell ))
				call_user_func_array ( $this->onRenderDataCell, array (
						$cell,
						$data [$row],
						$value 
				) );
		}
	}
	public function createExcel($data, $headers, $autor, $title, $titleSheet, $fromDataRow = 1, $titles) {
		//Yii::import ( 'ext.phpexcel.XPHPExcel' );
		$objPHPExcel = XPHPExcel::createPHPExcel ();
		$objPHPExcel->getProperties ()->setCreator ( $autor )->setLastModifiedBy ( $autor )->setTitle ( "Office 2007 XLSX Test Document" )->setSubject ( "Office 2007 XLSX Test Document" )->setDescription ( "Test document for Office 2007 XLSX, generated using PHP classes." )->setKeywords ( "office 2007 openxml php" )->setCategory ( $title );
		
		$n = count ( $data );
		$nTitles = count ( $titles );
		if ($nTitles > 0) // AGREGA TITULOS Y SUBTITULOS
			{
			$rowTitle = 1;
			foreach ( $titles as $title ) {
				$rowTitle ++;
				$style = array (
						'alignment' => array (
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						),
						'font' => array (
								'bold' => true,
								'color' => array (
										'rgb' => 'CCCCCC' 
								),
								'size' => 14,
								'name' => 'Verdana' 
						),
						'borders' => array (
								'allborders' => array (
										'style' => 'thin' 
								) 
						) 
				); // PHPExcel_Style_Border::BORDER_THIN
				
				$range = 'A' . $rowTitle . ':' . 'M' . $rowTitle;
				$objPHPExcel->getActiveSheet ()->setCellValue ( 'A' . $rowTitle, $title, true );
				$objPHPExcel->getActiveSheet ()->getRowDimension ( $rowTitle )->setRowHeight ( 'auto' );
				$objPHPExcel->getActiveSheet ()->mergeCells ( $range );
				$objPHPExcel->getActiveSheet ()->getStyle ( $range )->applyFromArray ( $style );
			}
		}
		
		// $s = "Line1\nLine2";
		// $objPHPExcel->getActiveSheet()->setCellValue('A15', $s);
		// $objPHPExcel->getActiveSheet()->getStyle('A15')
		// ->getAlignment()
		// ->setWrapText(true);
		// $objPHPExcel->getActiveSheet()->freezePane('D15');
		
		// agrego los headers
		$column = 0;
		$column = LGoicoExcel::renderHeaders ( $objPHPExcel, $headers, $fromDataRow, $column );
		
		if ($n > 0) {
			$rowCount = $fromDataRow + 2; // arranco abajo de los headers TODO ver cuanto
			for($rowCount; $rowCount < ($fromDataRow + 1 + $n); ++ $rowCount)
				LGoicoExcel::renderRow ( $objPHPExcel, $data, $fromDataRow + $n - $rowCount, $headers, $rowCount );
		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet ()->setTitle ( $titleSheet );
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		foreach ( range ( 'A', 'Z' ) as $columnID ) {
			$objPHPExcel->getActiveSheet ()->getColumnDimension ( $columnID )->setAutoSize ( true );
		}
		
		// Redirect output to a clientâ€™s web browser (Excel5)
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . $title . '.xlsx"' );
		header ( 'Cache-Control: max-age=0' );
		// If you're serving to IE 9, then the following may be needed
		header ( 'Cache-Control: max-age=1' );
		
		// If you're serving to IE over SSL, then the following may be needed
		header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
		header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
		header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
		header ( 'Pragma: public' ); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		$objWriter->save ( 'php://output' );
		Yii::app ()->end ();
	}
	public function addSubtitleBlock($subtitle, $indexRow, $mergeColumn, $countHeaders) {
		$style = array (
				'alignment' => array (
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				),
				'borders' => array (
						'allborders' => array (
								'style' => 'slantDashDot' 
						) 
				) 
		);
		$objPHPExcel = $this->phpExcelTmp;
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 0, $indexRow, $subtitle );
		if ($mergeColumn) {
			$objPHPExcel->getActiveSheet ()->mergeCellsByColumnAndRow ( 0, $indexRow, $countHeaders, $indexRow );
			// $objPHPExcel->getActiveSheet ()->getRowDimension ( $rowTitle )->setRowHeight ( 'auto' );
			$objPHPExcel->getActiveSheet ()->getStyleByColumnAndRow ( 0, $indexRow, $countHeaders, $indexRow )->applyFromArray ( $style );
		}
	}
	public function addDataExcel($data, $headers, $indexRow) {
		$n = count ( $data );
		$rowCount = $indexRow;
		
		if ($n > 0) {
			$objPHPExcel = $this->phpExcelTmp;
			$rowData = 0;
			for($rowCount; $rowCount < ($indexRow + $n); ++ $rowCount) {
				LGoicoExcel::renderRow ( $objPHPExcel, $data, $rowData, $headers, $rowCount );
				$rowData ++;
			}
		}
		return $rowCount + 2;
	}
	public function copyRows($rowFrom, $rowTo) {
		//LGoicoExcel::copyRowFull ( $wsSheet, $wsSheet, $rowFrom, $rowTo );
		//hoja, fila desde, fila destino, cantindad filas, cantidad columnas
		LGoicoExcel::copyRowsWithMerge($this->phpExcelTmp->getActiveSheet(), $rowFrom, $rowTo, 1, 22);
	}
	public function copyRowFull($ws_from, $ws_to, $row_from, $row_to) {
		$ws_to->getRowDimension ( $row_to )->setRowHeight ( $ws_from->getRowDimension ( $row_from )->getRowHeight () );
		$lastColumn = $ws_from->getHighestColumn ();
		++ $lastColumn;
		for($c = 'A'; $c != $lastColumn; ++ $c) {
			$cell_from = $ws_from->getCell ( $c . $row_from );
			$cell_to = $ws_to->getCell ( $c . $row_to );
			$cell_to->setXfIndex ( $cell_from->getXfIndex () ); // black magic here
			$cell_to->setValue ( $cell_from->getValue () );
		}
	}
	public function  copyRowsWithMerge($sheet, $srcRow, $dstRow, $height, $width) {
		for($row = 0; $row < $height; $row ++) {
			for($col = 0; $col < $width; $col ++) {
				$cell = $sheet->getCellByColumnAndRow ( $col, $srcRow + $row );
				$style = $sheet->getStyleByColumnAndRow ( $col, $srcRow + $row );
				$dstCell = PHPExcel_Cell::stringFromColumnIndex ( $col ) . ( string ) ($dstRow + $row);
				$sheet->setCellValue ( $dstCell, $cell->getValue () );
				$sheet->duplicateStyle ( $style, $dstCell );
			}
			$h = $sheet->getRowDimension ( $srcRow + $row )->getRowHeight ();
			$sheet->getRowDimension ( $dstRow + $row )->setRowHeight ( $h );
		}
	}
	
	function setAutoFilter() {
		$objPHPExcel = $this->phpExcelTmp;
		/*$objPHPExcel->getActiveSheet()->setAutoFilter(
				$objPHPExcel->getActiveSheet()
				->calculateWorksheetDimension()
		);*/
		$objPHPExcel->getActiveSheet()->setAutoFilter('A4:J400');
	}
	public function setActiveSheet($nroSheet) {
		$this->phpExcelTmp->setActiveSheetIndex($nroSheet);
	}
}
?>