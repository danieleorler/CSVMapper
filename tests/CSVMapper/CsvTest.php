<?php

namespace CSVMapper;

use CSVMapper\Configuration\SettingManager;
use CSVMapper\Configuration\MappingManager;
use CSVMapper\Configuration\YamlMappingManager;
use CSVMapper\Configuration\ErrorManager;
use CSVMapper\Exception\WrongColumnsNumberException;
use CSVMapper\Exception\ConfigurationMissingExcepion;

class CsvTest extends \PHPUnit_Framework_TestCase
{
	public function testCorrectMapping()
	{
		$csv = new Csv();
		$config = new SettingManager();
		$mapping = new MappingManager();
		$error = new ErrorManager();

		$config->set_setting('folder','./tests');
		$config->set_setting('filename','temperatures.csv');
		$config->set_setting('separator',';');
		$config->set_setting('columns_allowed',3);

		$mapping->set_mapping("month",		array('key'=>0, 'fn'=>create_function('$input','return strlen($input) == 1?"0".$input:$input;'),'test'=>create_function('$input','return is_numeric($input);')));
		$mapping->set_mapping("year",		array('key'=>1, 'fn'=>FALSE,'test'=>FALSE));
		$mapping->set_mapping("temperature",	array('key'=>2, 'fn'=>create_function('$input','return floatval($input);'),'test'=>FALSE));
		
		$csv->set_mapping_manager($mapping);
		$csv->set_setting_manager($config);
		$csv->set_error_manager($error);

		$result = $csv->looper();

		$expected = array
		(
			array('month' => '01', 'year' => '2013', 'temperature' => 0.2),
			array('month' => '02', 'year' => '2013', 'temperature' => -1.5),
			array('month' => '03', 'year' => '2013', 'temperature' => 2.4),
			array('month' => '04', 'year' => '2013', 'temperature' => 8.7),
			array('month' => '05', 'year' => '2013', 'temperature' => 15.6),
			array('month' => '06', 'year' => '2013', 'temperature' => 20.4),
			array('month' => '07', 'year' => '2013', 'temperature' => 25.3),
			array('month' => '08', 'year' => '2013', 'temperature' => 26.0),
			array('month' => '09', 'year' => '2013', 'temperature' => 22.2),
			array('month' => '10', 'year' => '2013', 'temperature' => 15.2),
			array('month' => '11', 'year' => '2013', 'temperature' => 8.2),
			array('month' => '12', 'year' => '2013', 'temperature' => 0.2)
		);

		$this->assertEquals($result,$expected);
	}

	/**
        * @expectedException CSVMapper\Exception\WrongColumnsNumberException
        */
	public function testNumColsException()
	{
		$csv = new Csv();
		$config = new SettingManager();
		$error = new ErrorManager();

		$config->set_setting('folder','./tests');
		$config->set_setting('filename','temperatures.csv');
		$config->set_setting('separator',';');
		$config->set_setting('columns_allowed',4);

		$csv->set_setting_manager($config);

		$csv->looper();
	}

	/**
        * @expectedException CSVMapper\Exception\ConfigurationMissingExcepion
        */
	public function testConfigException()
	{
		$csv = new Csv();
		$config = new SettingManager();

		$config->set_setting('filename','temperatures.csv');

		$csv->set_setting_manager($config);

		$csv->looper();
	}


        /**
         * 
         */
        public function testYamlMapping()
        {
		$csv = new Csv();
		$config = new SettingManager();
		$mapping = new YamlMappingManager('./tests/tempMappings.yml');
		$error = new ErrorManager();

		$config->set_setting('folder','./tests');
		$config->set_setting('filename','temperatures.csv');
		$config->set_setting('separator',';');
		$config->set_setting('columns_allowed',3);
		
		$csv->set_mapping_manager($mapping);
		$csv->set_setting_manager($config);
		$csv->set_error_manager($error);

		$result = $csv->looper();

		$expected = array
		(
			array('month' => '01', 'year' => '2013', 'temperature' => 0.2),
			array('month' => '02', 'year' => '2013', 'temperature' => -1.5),
			array('month' => '03', 'year' => '2013', 'temperature' => 2.4),
			array('month' => '04', 'year' => '2013', 'temperature' => 8.7),
			array('month' => '05', 'year' => '2013', 'temperature' => 15.6),
			array('month' => '06', 'year' => '2013', 'temperature' => 20.4),
			array('month' => '07', 'year' => '2013', 'temperature' => 25.3),
			array('month' => '08', 'year' => '2013', 'temperature' => 26.0),
			array('month' => '09', 'year' => '2013', 'temperature' => 22.2),
			array('month' => '10', 'year' => '2013', 'temperature' => 15.2),
			array('month' => '11', 'year' => '2013', 'temperature' => 8.2),
			array('month' => '12', 'year' => '2013', 'temperature' => 0.2)
		);

		$this->assertEquals($result,$expected);
        }
}