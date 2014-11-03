<?php

namespace CSVMapper\Reader;

use CSVMapper\Parser\Parser;
use CSVMapper\Source\AbstractSource;
use CSVMapper\Exception\WrongColumnsNumberException;

/**
 * Description of Reader
 *
 * @author danorler
 */
class Reader
{

    private $file = null;
    private $parser = null;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(AbstractSource $file)
    {
        $this->file = $file;
        $this->isFileOk();
    }

    public function getParser()
    {
        return $this->parser;
    }

    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    private function isFileOk()
    {
        $this->file->checkProperty('folder');
        $this->file->checkProperty('name');
        $this->checkColumnsNumber();
    }

    private function checkColumnsNumber()
    {
        $fileColumns = $this->file->getColumnsCount();
        $allowedColumns = $this->file->getColumnsAllowed();
        if ($allowedColumns && $fileColumns != $allowedColumns)
        {
            $this->file->close();
            throw new WrongColumnsNumberException(sprintf("Expected %d columns, found %d!", $allowedColumns, $fileColumns), 1);
        }
    }

    public function getNextRow()
    {
        $rawRow = $this->file->getRowAsArray();
        if(!empty($rawRow))
        {
            return $this->parser->parse($rawRow);
        }
        else
        {
            return null;
        }
    }

    public function hasNextRow()
    {
        $hasRow = $this->file->hasRow();
        return $hasRow;
    }

    public function close()
    {
        $this->file->close();
    }

}
