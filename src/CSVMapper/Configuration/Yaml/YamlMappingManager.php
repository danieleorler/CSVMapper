<?php

namespace CSVMapper\Configuration\Yaml;

use Symfony\Component\Yaml\Yaml;
use CSVMapper\Configuration\MappingManager;

class YamlMappingManager extends MappingManager
{
    public function __construct($filepath = FALSE)
    {
        if($filepath)
        {
            $config = Yaml::parse(file_get_contents($filepath));
            foreach($config['mapping'] AS $k=>$v)
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
