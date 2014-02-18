<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcelFile
 *
 * @author agottardi
 */

namespace CSVMapper\Source;

use PHPExcel_IOFactory;
use PHPExcel_Cell;

class ExcelFile extends File {

    private $rowNumber = 1;
    private $columnsAllowed = null;
    
    public function getColumnsAllowed() {
        if (empty($this->columnsAllowed)) {
            return FALSE;
        } else {
            return $this->columnsAllowed;
        }
    }

    public function setColumnsAllowed($columnsAllowed) {
        $this->columnsAllowed = $columnsAllowed;
    }

    public function openFile($path) {
        $inputFileName = $path;
        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);
        $this->rowNumber = 1;
        return $objPHPExcel;
    }

    public function getFileColumns() {
        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        return $highestColumnIndex;
    }

    public function getRawRow() {

        $values = array();
        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestColumnIndex = $this->getFileColumns();

        
        for ($col = 0; $col <= $highestColumnIndex-1; $col++) {
            
            $cell = $objWorksheet->getCellByColumnAndRow($col, $this->rowNumber);
            $cellValue = $cell->getValue();
            
            array_push($values, $cellValue);
        }

        $this->rowNumber++;
        
        return $values;
    }

    public function hasRow() {

        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

        $highestRow = $objWorksheet->getHighestRow(); // e.g 'F'
                
        if ($highestRow == 1 && $objWorksheet->getCellByColumnAndRow(0, 1)->getValue() == null) {
            return false;
        } else if ($highestRow >= $this->rowNumber) {
            return true;
        }
            
        return false;
        
    }

    public function reset() {
        $this->rowNumber = 1;
    }
    
    public function close() {
        
        $objPHPExcel = $this->getHandler();
        
        if (!empty($objPHPExcel)) {
            $objPHPExcel->disconnectWorksheets();
            unset($objPHPExcel);
            
        }
        $this->handler = null;
    }

}
