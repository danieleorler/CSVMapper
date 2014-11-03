<?php

namespace CSVMapper\Source;

/**
 * Description of CsvFile
 *
 * @author danorler
 */

class CsvFile extends AbstractSource
{
    /*
     *  field separator
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

    public function open()
    {
        $handler = fopen($this->getPath(), "r");
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

    public function getColumnsCount()
    {
        $fileColumns = count(fgetcsv($this->getHandler(), 0, $this->getSeparator(), $this->getEnclosure()));
        $this->reset();
        return $fileColumns;
    }

    public function getRowAsArray()
    {
        $rawRow = fgetcsv($this->getHandler(), 0, $this->getSeparator(), $this->getEnclosure());
        return $rawRow;
    }

    public function hasRow()
    {
        return !feof($this->getHandler());
    }

}
