<?php

namespace CSVMapper\Source;

use CSVMapper\Exception\PropertyMissingException;
use CSVMapper\Exception\ConfigurationMissingException;

abstract class AbstractSource
{

    /*
    * getter and setter for folder
    */
    private $folder = null;

    public function getFolder()
    {
        return $this->folder;
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /*
    * getter and setter for name
    */
    private $name = null;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /*
    * getter and setter for path
    */
    private $path = null;

    public function getPath()
    {
        if ($this->path != null)
        {
            return $this->path;
        }
        else if ($this->folder != null && $this->name != null)
        {
            return sprintf("%s/%s", $this->getFolder(), $this->getName());
        }
        else
        {
            return null;
        }
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    /*
    * getter and setter for columnsAllowed
    */
    private $columnsAllowed = null;

    public function getColumnsAllowed()
    {
        if (empty($this->columnsAllowed))
        {
            return FALSE;
        }
        else
        {
            return $this->columnsAllowed;
        }
    }

    public function setColumnsAllowed($columnsAllowed)
    {
        $this->columnsAllowed = $columnsAllowed;
    }

    /*
    * getter and setter for handler
    */
    protected $handler = null;

    public function getHandler()
    {
        if(empty($this->handler))
        {
            $this->handler = $this->open();
        }
        return $this->handler;
    }

    /*
    * check if properties and configurations are ok
    */
    public function checkProperty($key)
    {
        if (!property_exists($this, $key))
        {
            throw new PropertyMissingException(sprintf("Property %s of Class File is missing!", $key), 2);
        }
        if (empty($this->{$key}))
        {
            throw new ConfigurationMissingException(sprintf("Configuration %s is missing!", $key), 2);
        }
    }

    /*
    * check handler
    */
    public function checkHandler()
    {
        if (empty($this->handler))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /*
    * open file
    */
    abstract public function open();

    /*
    * close file
    */
    abstract public function close();

    /*
    * reset file, move poiter to the beginning of the file
    */
    abstract public function reset();

    /*
    * return the number of columns contained in the file
    */
    abstract public function getColumnsCount();

    /*
    * return the current row as an array
    */
    abstract public function getRowAsArray();

    /*
    * check if the file has another row
    */
    abstract public function hasRow();
}