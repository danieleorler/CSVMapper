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
    /*
     *  field delimiter
     */

    private $separator = ';';
    /*
     * field enclosure character
     */
    private $enclosure = '"';
 
    public function getSeparator()
    {
        return $this->separator;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getEnclosure()
    {
        return $this->enclosure;
    }

    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
    }

    public function openFile($path)
    {
        $handler = fopen($path, "r");
        return $handler;
    }

    public function close()
    {
        if (!empty($this->handler))
        {
            fclose($this->handler);
        }
        $this->handler = null;
    }

    public function reset()
    {
        if (!empty($this->handler))
        {
            fseek($this->handler, 0);
        }
    }

    public function getFileColumns()
    {
        $fileColumns = count(fgetcsv($this->getHandler(), 0, $this->getSeparator(), $this->getEnclosure()));
        $this->reset();
        return $fileColumns;
    }

    public function getRawRow()
    {
        $rawRow = fgetcsv($this->getHandler(), 0, $this->getSeparator(), $this->getEnclosure());
        return $rawRow;
    }

    public function hasRow()
    {
        return !feof($this->getHandler());
    }

}
