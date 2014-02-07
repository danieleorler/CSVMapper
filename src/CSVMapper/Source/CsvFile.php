<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper\Source;

/**
 * Description of CsvFile
 *
 * @author danorler
 */
class CsvFile extends File
{
    private $separator;
    private $columnsAllowed;
    
    public function getSeparator()
    {
        return $this->separator;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }
    
    public function getColumnsAllowed()
    {
        return $this->columnsAllowed;
    }

    public function setColumnsAllowed($columnsAllowed)
    {
        $this->columnsAllowed = $columnsAllowed;
    }

}
