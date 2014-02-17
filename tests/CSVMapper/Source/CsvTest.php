<?php

namespace CSVMapper;

use CSVMapper\Configuration\ErrorManager;
use CSVMapper\Configuration\MappingManager;
use CSVMapper\Configuration\Yaml;
use CSVMapper\Parser\Parser;
use CSVMapper\Reader\Reader;
use CSVMapper\Source\CsvFile;

class CsvTest extends \PHPUnit_Framework_TestCase {

    private $expected_table;

    /*
     * set up the expected resultset
     */

    protected function setUp() {
        $this->expected_table = array
            (
            array('month' => '01', 'year' => '2013', 'temperature' => 0.2, 'fixed_field' => 'default_value'),
            array('month' => '02', 'year' => '2013', 'temperature' => -1.5, 'fixed_field' => 'default_value'),
            array('month' => '03', 'year' => '2013', 'temperature' => 2.4, 'fixed_field' => 'default_value'),
            array('month' => '04', 'year' => '2013', 'temperature' => 8.7, 'fixed_field' => 'default_value'),
            array('month' => '05', 'year' => '2013', 'temperature' => 15.6, 'fixed_field' => 'default_value'),
            array('month' => '06', 'year' => '2013', 'temperature' => 20.4, 'fixed_field' => 'default_value'),
            array('month' => '07', 'year' => '2013', 'temperature' => 25.3, 'fixed_field' => 'default_value'),
            array('month' => '08', 'year' => '2013', 'temperature' => 26.0, 'fixed_field' => 'default_value'),
            array('month' => '09', 'year' => '2013', 'temperature' => 22.2, 'fixed_field' => 'default_value'),
            array('month' => '10', 'year' => '2013', 'temperature' => 15.2, 'fixed_field' => 'default_value'),
            array('month' => '11', 'year' => '2013', 'temperature' => 8.2, 'fixed_field' => 'default_value'),
            array('month' => '12', 'year' => '2013', 'temperature' => 0.2, 'fixed_field' => 'default_value')
        );
    }

    /*
     * test a correct mapping with columns number limit and explicit delimiter
     */

    public function testCorrectMapping() {
        $file = new CsvFile();
        $file->setFolder('./tests/CsvTest');
        $file->setName('temperatures.csv');
        $file->setSeparator(';');
        $file->setColumnsAllowed(3);

        $mapping = new MappingManager();
        $error = new ErrorManager();
        $parser = new Parser();
        $reader = new Reader();

        $mapping->set_mapping("month", array('key' => 0, 'fn' => function($input) {
        return strlen($input) == 1 ? "0" . $input : $input;
    }, 'test' => function($input) {
        return is_numeric($input);
    }));
        $mapping->set_mapping("year", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
        $mapping->set_mapping("temperature", array('key' => 2, 'fn' => create_function('$input', 'return floatval($input);'), 'test' => FALSE));
        $mapping->set_mapping("fixed_field", array('key' => NULL, 'value' => 'default_value', 'fn' => FALSE, 'test' => FALSE));

        $parser->setMappingManager($mapping);
        $parser->setErrorManager($error);

        $reader->setParser($parser);
        $reader->setFile($file);

        $result = array();

        while ($reader->hasNextRow()) {
            $row = $reader->getNextRow();
            if ($row !== FALSE) {
                $result[] = $row;
            }
        }

        $this->assertEquals($this->expected_table, $result);
    }

    /*
     * test a correct mapping with columns number limit and default delimiter
     */

    public function testCorrectMappingDefaultSeparator() {
        $file = new CsvFile();
        $file->setFolder('./tests/CsvTest');
        $file->setName('temperatures.csv');
        $file->setColumnsAllowed(3);

        $mapping = new MappingManager();
        $error = new ErrorManager();
        $parser = new Parser();
        $reader = new Reader();

        $mapping->set_mapping("month", array('key' => 0, 'fn' => function($input) {
        return strlen($input) == 1 ? "0" . $input : $input;
    }, 'test' => function($input) {
        return is_numeric($input);
    }));
        $mapping->set_mapping("year", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
        $mapping->set_mapping("temperature", array('key' => 2, 'fn' => create_function('$input', 'return floatval($input);'), 'test' => FALSE));
        $mapping->set_mapping("fixed_field", array('key' => NULL, 'value' => 'default_value', 'fn' => FALSE, 'test' => FALSE));

        $parser->setMappingManager($mapping);
        $parser->setErrorManager($error);

        $reader->setParser($parser);
        $reader->setFile($file);

        $result = array();

        while ($reader->hasNextRow()) {
            $row = $reader->getNextRow();
            if ($row !== FALSE) {
                $result[] = $row;
            }
        }

        $this->assertEquals($this->expected_table, $result);
    }

    /*
     * test a correct mapping without columns number limit and with default delimiter
     */

    public function testCorrectMappingNoColumnsNumberBound() {
        $file = new CsvFile();
        $file->setFolder('./tests/CsvTest');
        $file->setName('temperatures.csv');

        $mapping = new MappingManager();
        $error = new ErrorManager();
        $parser = new Parser();
        $reader = new Reader();

        $mapping->set_mapping("month", array('key' => 0, 'fn' => function($input) {
        return strlen($input) == 1 ? "0" . $input : $input;
    }, 'test' => function($input) {
        return is_numeric($input);
    }));
        $mapping->set_mapping("year", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
        $mapping->set_mapping("temperature", array('key' => 2, 'fn' => create_function('$input', 'return floatval($input);'), 'test' => FALSE));
        $mapping->set_mapping("fixed_field", array('key' => NULL, 'value' => 'default_value', 'fn' => FALSE, 'test' => FALSE));

        $parser->setMappingManager($mapping);
        $parser->setErrorManager($error);

        $reader->setParser($parser);
        $reader->setFile($file);

        $result = array();

        while ($reader->hasNextRow()) {
            $row = $reader->getNextRow();
            if ($row !== FALSE) {
                $result[] = $row;
            }
        }

        $this->assertEquals($this->expected_table, $result);
    }

    public function testCloseFile() {
        $file = new CsvFile();
        $file->setFolder('./tests/CsvTest');
        $file->setName('temperatures.csv');
        $file->getHandler();

        $file->close();
        $this->assertTrue($file->handler == null);
    }

    public function testYamlMapping() {
        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();
        $rows = array();

        $CSV->setFolder('./tests/CsvTest');
        $CSV->setName('temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));
        $CSV->setFolder($setting->get_setting('folder'));
        $CSV->setName($setting->get_setting('filename'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        while ($CSVReader->hasNextRow()) {
            array_push($rows, $CSVReader->getNextRow());
        }

        $this->assertEquals($this->expected_table, $rows);
    }

    public function testSetPath() {
        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();

        $CSV->setFolder('./tests/CsvTest');
        $CSV->setName('temperatures.csv');
        $CSV->setPath('./tests/CsvTest/temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));
        $CSV->setFolder($setting->get_setting('folder'));
        $CSV->setName($setting->get_setting('filename'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        $this->assertNotNull($CSV->getPath());
    }

    /**
     * @expectedException CSVMapper\Exception\PropertyMissingException
     */
    public function testMissingProperty() {

        // it works because this code tries to retrieve a property (fakeproperty) not available

        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();

        $CSV->setPath('./tests/CsvTest/temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));
        $CSV->setFolder($setting->get_setting('folder'));
        $CSV->setName($setting->get_setting('filename'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        $CSV->checkProperty('fakeProperty');
    }

    /**
     * @expectedException CSVMapper\Exception\ConfigurationMissingExcepion
     */
    public function testMissingConfiguration() {

        // it works because this code doesn't set folder and name parameters

        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();

        $CSV->setPath('./tests/CsvTest/temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        $CSV->checkProperty('fakeProperty');
    }

    public function testGetPathWithNoParametersSet() {
        $CSV = new CsvFile;
        $CSV->setColumnsAllowed(3);

        $this->assertNull($CSV->getPath());
    }

    public function testGetColumnsAllowedWithNoParametersSet() {
        $CSV = new CsvFile;

        $this->assertFalse($CSV->getColumnsAllowed());
    }

    public function testParserMappingManager() {
        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();

        $CSV->setFolder('./tests/CsvTest');
        $CSV->setName('temperatures.csv');
        $CSV->setPath('./tests/CsvTest/temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));
        $CSV->setFolder($setting->get_setting('folder'));
        $CSV->setName($setting->get_setting('filename'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        $this->assertNotNull($CSVParser->getMappingManager());
    }

    public function testParserErrorManager() {
        $CSV = new CsvFile();
        $CSVParser = new Parser();
        $CSVReader = new Reader();

        $CSV->setFolder('./tests/CsvTest');
        $CSV->setName('temperatures.csv');
        $CSV->setPath('./tests/CsvTest/temperatures.csv');

        $setting = new Yaml\YamlSettingManager('./tests/CsvTest/tempMappings.yml');
        $mapping = new Yaml\YamlMappingManager('./tests/CsvTest/tempMappings.yml');

        $CSV->setSeparator($setting->get_setting('separator'));
        $CSV->setColumnsAllowed($setting->get_setting('columns_allowed'));
        $CSV->setFolder($setting->get_setting('folder'));
        $CSV->setName($setting->get_setting('filename'));

        $CSVParser->setErrorManager(new ErrorManager());
        $CSVParser->setMappingManager($mapping);

        $CSVReader->setFile($CSV);
        $CSVReader->setParser($CSVParser);

        $this->assertNotNull($CSVParser->getErrorManager());
    }

//
//	/**
//    * @expectedException CSVMapper\Exception\WrongColumnsNumberException
//    */
//	public function testNumColsException()
//	{
//		$csv = new Csv();
//		$config = new SettingManager();
//		$error = new ErrorManager();
//
//		$config->set_setting('folder','./tests');
//		$config->set_setting('filename','temperatures.csv');
//		$config->set_setting('separator',';');
//		$config->set_setting('columns_allowed',4);
//
//		$csv->set_setting_manager($config);
//
//		$csv->looper();
//	}
//
//	/**
//    * @expectedException CSVMapper\Exception\ConfigurationMissingExcepion
//    */
//	public function testConfigException()
//	{
//		$csv = new Csv();
//		$config = new SettingManager();
//
//		$config->set_setting('filename','temperatures.csv');
//
//		$csv->set_setting_manager($config);
//
//		$csv->looper();
//	}
//
//	/**
//    * @expectedException CSVMapper\Exception\ConfigurationMissingExcepion
//    */
//	public function testConfigException2()
//	{
//		$csv = new Csv();
//		$config = new SettingManager();
//
//		$config->set_setting('folder','./tests');
//
//		$csv->set_setting_manager($config);
//
//		$csv->looper();
//	}
//
//    /**
//     *
//     */
//    public function testYamlSetting()
//    {
//		$csv = new Csv();
//		$config = new YamlSettingManager('./tests/tempMappings.yml');
//        $mapping = new MappingManager();
//        $error = new ErrorManager();
//
//		$mapping->set_mapping("month",			array('key'=>0, 'fn'=>create_function('$input','return strlen($input) == 1?"0".$input:$input;'),'test'=>create_function('$input','return is_numeric($input);')));
//		$mapping->set_mapping("year",			array('key'=>1, 'fn'=>FALSE,'test'=>FALSE));
//		$mapping->set_mapping("temperature",	array('key'=>2, 'fn'=>create_function('$input','return floatval($input);'),'test'=>FALSE));
//	    $mapping->set_mapping("fixed_field",	array('key'=>NULL, 'value'=>'default_value', 'fn'=>FALSE, 'test'=>FALSE));
//
//		$csv->set_mapping_manager($mapping);
//		$csv->set_setting_manager($config);
//		$csv->set_error_manager($error);
//
//		$result = $csv->looper();
//
//		$this->assertEquals($result,$this->expected_table);
//    }
//
//    /**
//     *
//     */
//
//    public function testRemoveQuotes()
//    {
//        $csv = new Csv();
//
//        $this->assertEquals($csv->remove_quotes('"2"'), 2);
//    }
}
