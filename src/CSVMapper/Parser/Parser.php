<?php

namespace CSVMapper\Parser;

use CSVMapper\Configuration\MappingManager;
use CSVMapper\Configuration\ErrorManager;

class Parser
{

    private $mappingManager;
    private $errorManager;
    
    public function getMappingManager()
    {
        return $this->mappingManager;
    }

    public function setMappingManager(MappingManager $mappingManager)
    {
        $this->mappingManager = $mappingManager;
    }
    
    public function getErrorManager()
    {
        return $this->errorManager;
    }

    public function setErrorManager(ErrorManager $errorManager)
    {
        $this->errorManager = $errorManager;
    }

    /**
     * parser generico, dato un mapping estrae e formatta le informazioni contenute in una linea
     * @param  Array[mixed] the extracted row to precces
     * @return Array[mixed] row parsed
     */
    public function parse($row)
    {
        $result = array();

        foreach($this->mappingManager->get_all_mappings() AS $key=>$field)
        {
            if(isset($field['key']) && !is_null($field['key']))
            {
                $input = $this->remove_quotes($row[$field['key']]);
            }
            else
            {
                $input = $field['value'];
            }

            if(isset($field['test']) && $field['test'] && !$field['test']($input))
            {
                $this->errorManager->add_error("Field {$key} didn't pass the test!");
                return FALSE;
            }
            else
            {
                if(isset($field['fn']) && $field['fn'])
                {
                    $result[$key] = $field['fn']($input);
                }
                else
                {
                    $result[$key] = $input;
                }
            }
        }

        return $result;
    }
    
    /**
     * [remove_quotes description]
     * @param  String $input
     * @return String
     */
    public function remove_quotes($input)
    {
        if(strlen($input) > 0)
        {
            if(substr($input, 0, 1) == '"')
            {
                $input = substr($input, 1);
            }

            if(substr($input, -1) == '"')
            {
                $input = substr($input, 0, -1);
            }
        }

        return $input;
    }
}
