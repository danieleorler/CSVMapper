<?php

namespace CSVMapper\Reader;

use CSVMapper\Parser\Parser;
use CSVMapper\Source\File;
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

    public function setFile(File $file)
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
        $fileColumns = count(explode($this->file->getSeparator(),fgets($this->file->getHandler())));
        $allowedColumns = $this->file->getColumnsAllowed();
        $this->file->reset();
        if($allowedColumns && $fileColumns != $allowedColumns)
        {
            $this->file->close();
            throw new WrongColumnsNumberException(sprintf("Expected %d columns, found %d!",$allowedColumns,$fileColumns), 1);
        }
    }
    
    public function getNextRow()
    {
        $rawRow = explode($this->file->getSeparator(), fgets($this->file->getHandler()));
        return $this->parser->parse($rawRow);
    }
    
    public function hasNextRow()
    {
        return !feof($this->file->getHandler());
    }
    
    public function close()
    {
        $this->file->close();
    }
}
