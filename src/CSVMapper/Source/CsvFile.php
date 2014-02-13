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
class CsvFile extends File {

    private $separator = null;
    private $columnsAllowed = null;

    public function getSeparator() {
        if (empty($this->separator)) {
            return ";";
        } else {
            return $this->separator;
        }
    }

    public function setSeparator($separator) {
        $this->separator = $separator;
    }

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

    public function openFile($path)
    {
        $handler = fopen($path, "r");
        return $handler;
    }

}
