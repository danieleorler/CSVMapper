<?php

namespace CSVMapper\Configuration;

use Symfony\Component\Yaml\Yaml;

class YamlMappingManager extends MappingManager
{
    public function __construct($filepath = FALSE)
    {
        if($filepath)
        {
            $fields = Yaml::parse(file_get_contents($filepath));
            foreach($fields AS $k=>$v)
            {
                $this->set_mapping($k,$this->yamlToArray($v));
            }
        }
    }
    
    public function yamlToArray($field)
    {
        $arrayMapping = array();
        foreach($field AS $k=>$v)
        {
            if(!is_array($v))
            {
                $arrayMapping[$k] = $v;
            }
            else
            {
                $arrayMapping[$k] = create_function($v['parameter'],$v['body']);
            }
        }
        
        return $arrayMapping;
    }
}
