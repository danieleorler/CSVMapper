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

class ExcelFile extends File {

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

        return $objPHPExcel;
    }
}