<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper\Source;

use CSVMapper\Exception\PropertyMissingException;
use CSVMapper\Exception\ConfigurationMissingExcepion;
/**
 * Description of File
 *
 * @author danorler
 */
class File
{
    private $folder = null;
    private $name = null;
    private $path = null;
    private $handler = null;
    
    public function getFolder()
    {
        return $this->folder;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return sprintf("%s/%s",$this->getFolder(),$this->getName());
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
    
    public function open()
    {
        $this->handler = $this->openFile($this->getPath());
        return $this->handler;
    }

    public function getHandler()
    {
        if(empty($this->handler))
        {
            $this->open();
        }
        return $this->handler;
    }

    public function close()
    {
        if(!empty($this->handler))
        {
            fclose($this->handler);
        }
        $this->handler = null;
    }
    
    public function reset()
    {
        if(!empty($this->handler))
        {
            fseek($this->handler,0);
        }
    }
    
    public function checkProperty($key)
    {
        if(!property_exists($this, $key))
        {
            throw new PropertyMissingException(sprintf("Property %s of Class File is missing!",$key), 2);
        }
        if(empty($this->{$key}))
        {
            throw new ConfigurationMissingExcepion(sprintf("Configuration %s is missing!",$key), 2);
        }
    }
}
