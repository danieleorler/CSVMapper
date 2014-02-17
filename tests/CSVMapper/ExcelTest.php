<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper;


/**
 * This class can parse Excel files (in many formats such as xls, xlsx..)
 *
 * @author agottardi
 */

use CSVMapper\Configuration\MappingManager;
use CSVMapper\Exception\ConfigurationMissingExcepion;
use CSVMapper\Exception\PropertyMissingException;
use CSVMapper\Configuration\ErrorManager;
use CSVMapper\Configuration\Yaml\YamlMappingManager;
use CSVMapper\Configuration\Yaml\YamlSettingManager;
use CSVMapper\Parser\Parser;
use CSVMapper\Reader\Reader;
use CSVMapper\Source\ExcelFile;

class ExcelTest extends \PHPUnit_Framework_TestCase {

    private $file = null;
    private $testValues = array('0' => '1', '1' => '2', '2' => '3');
    private $testResult = array(
        array('campo1' => '1', 'campo2' => '2', 'campo3' => '3'),
        array('campo1' => '4', 'campo2' => '5', 'campo3' => '6'),
        array('campo1' => '7', 'campo2' => '8', 'campo3' => '9'),
        array('campo1' => '10', 'campo2' => '11', 'campo3' => '12'),
        array('campo1' => '13', 'campo2' => '14', 'campo3' => '15'),
        array('campo1' => '16', 'campo2' => '17', 'campo3' => '18'),
    );

    public function testCorrectHandler() {
        $file = new ExcelFile();
        $file->setColumnsAllowed(3);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->open();

        $this->assertFalse($file->getHandler() == null);
    }

    public function testHasRowWithAvailableRows() {
        $file = new ExcelFile();
        $file->setColumnsAllowed(3);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->open();

        $hasRow = $file->hasRow();
        $this->assertTrue($hasRow);
    }

    public function testHasRowWithNoRows() {
        $file = new ExcelFile();
        $file->setColumnsAllowed(0);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBookEmpty.xlsx');
        $file->open();

        $hasRow = $file->hasRow();
        $this->assertFalse($hasRow);
    }

    public function testGetRow() {

        $array = array();

        $file = new ExcelFile();
        $file->setColumnsAllowed(0);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->open();

        if ($file->hasRow()) {
            $array = $file->getRawRow();
        }

        $this->assertEquals($array, $this->testValues);
    }

    public function testCorrectMapping() {
        $rows = array();

        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

//        $XLSMapping = new MappingManager();
//
//        $XLSMapping->set_mapping("campo1", array('key' => 0, 'fn' => FALSE, 'test' => FALSE));
//        $XLSMapping->set_mapping("campo2", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
//        $XLSMapping->set_mapping("campo3", array('key' => 2, 'fn' => FALSE, 'test' => FALSE));

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        while ($XLSReader->hasNextRow()) {
            array_push($rows, $XLSReader->getNextRow());
        }


        $this->assertEquals($this->testResult, $rows);
    }

    public function testCloseFile() {

        $file = new ExcelFile();
        $file->setColumnsAllowed(3);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->getHandler();

        $file->close();

        $this->assertTrue($file->handler == null);
    }

    public function testReaderGetParser() {

        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $parser = $XLSReader->getParser();
        $this->assertTrue($parser == $XLSParser);
    }

    public function testReaderGetFile() {

        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $file = $XLSReader->getFile();
        $this->assertTrue($file == $XLSFile);
    }

    /**
     * @expectedException CSVMapper\Exception\WrongColumnsNumberException
     */
    public function testTooManyColumnsAllowed() {
        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(4);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);
    }

    public function testReaderCloseFile() {
        $rows = array();

        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

//        $XLSMapping = new MappingManager();
//
//        $XLSMapping->set_mapping("campo1", array('key' => 0, 'fn' => FALSE, 'test' => FALSE));
//        $XLSMapping->set_mapping("campo2", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
//        $XLSMapping->set_mapping("campo3", array('key' => 2, 'fn' => FALSE, 'test' => FALSE));

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $XLSReader->close();


        $this->assertTrue($XLSFile->handler == null);
    }

    public function testSetPath() {

        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');
        $XLSFile->setPath('./tests/ExcelTest/TestBook.xlsx');


        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $this->assertNotNull($XLSFile->getPath());
    }

    /**
     * @expectedException CSVMapper\Exception\PropertyMissingException
     */
    public function testMissingProperty() {
        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $XLSFile->checkProperty('fakeProperty');

        $XLSReader->close();
    }

    /**
     * @expectedException CSVMapper\Exception\ConfigurationMissingExcepion
     */
    public function testMissingConfiguration() {
        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setPath('./tests/ExcelTest/TestBook.xlsx');

        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $XLSFile->checkProperty('fakeProperty');

        $XLSReader->close();
    }

    public function testGetPathWithNoParametersSet() {
        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);

        $this->assertNull($XLSFile->getPath());
    }

    public function testGetColumnsAllowedWithNoParametersSet() {
        $XLSFile = new ExcelFile;
        $this->assertFalse($XLSFile->getColumnsAllowed());
    }

    public function testGetParserMappingManager() {

        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');
        $XLSFile->setPath('./tests/ExcelTest/TestBook.xlsx');


        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $this->assertNotNull($XLSParser->getMappingManager());
    }

    public function testGetParserErrorManager() {

        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');
        $XLSFile->setPath('./tests/ExcelTest/TestBook.xlsx');


        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $this->assertNotNull($XLSParser->getErrorManager());
    }

    public function testTestNotPassed() {

        $rows = array();

        $XLSFile = new ExcelFile();
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new MappingManager();

        $XLSMapping->set_mapping("\"campo1\"", array('key' => 0, 'fn' => FALSE, 'test' => FALSE));
        $XLSMapping->set_mapping("campo2", array('key' => 1, 'fn' => FALSE, 'test' => create_function('$input', 'return ($input<3);')));
        $XLSMapping->set_mapping("campo3", array('key' => 2, 'fn' => FALSE, 'test' => FALSE));


        $XLSSetting = new YamlSettingManager('./tests/ExcelTest/TestBookMappings.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        while ($XLSFile->hasRow()) {
            $rows = $XLSFile->getRawRow();
        }

        $XLSReader->close();
    }

}
