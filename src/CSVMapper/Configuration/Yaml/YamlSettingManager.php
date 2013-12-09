<?php

namespace CSVMapper\Configuration\Yaml;

use Symfony\Component\Yaml\Yaml;
use CSVMapper\Configuration\SettingManager;

class YamlSettingManager extends SettingManager
{
    public function __construct($filepath = FALSE)
    {
        if($filepath)
        {
            $config = Yaml::parse(file_get_contents($filepath));
            foreach($config['setting'] AS $k=>$v)
            {
                $this->set_setting($k,$v);
            }
        }
    }
}