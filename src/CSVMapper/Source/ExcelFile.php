<?php

/**
 * Description of ExcelFile
 *
 * @author agottardi
 */

namespace CSVMapper\Source;

use PHPExcel_IOFactory;
use PHPExcel_Cell;

class ExcelFile extends AbstractSource
{

    private $rowNumber = 1;

    public function open()
    {
        $inputFileName = $this->getPath();
        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);
        $this->rowNumber = 1;
        return $objPHPExcel;
    }

    public function getColumnsCount()
    {
        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        return $highestColumnIndex;
    }

    public function getRowAsArray()
    {
        $values = array();
        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestColumnIndex = $this->getColumnsCount();


        for ($col = 0; $col <= $highestColumnIndex - 1; $col++)
        {

            $cell = $objWorksheet->getCellByColumnAndRow($col, $this->rowNumber);
            $cellValue = $cell->getValue();

            array_push($values, $cellValue);
        }

        $this->rowNumber++;

        return $values;
    }

    public function hasRow()
    {

        $objPHPExcel = $this->getHandler();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

        $highestRow = $objWorksheet->getHighestRow(); // e.g 'F'

        if ($highestRow == 1 && $objWorksheet->getCellByColumnAndRow(0, 1)->getValue() == null)
        {
            return false;
        }
        else if ($highestRow >= $this->rowNumber)
        {
            return true;
        }

        return false;
    }

    public function reset()
    {
        $this->rowNumber = 1;
    }

    public function close()
    {

        $objPHPExcel = $this->getHandler();

        if (!empty($objPHPExcel))
        {
            $objPHPExcel->disconnectWorksheets();
            unset($objPHPExcel);
        }
        $this->handler = null;
    }

}
