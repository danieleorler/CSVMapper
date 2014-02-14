<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper;

/**
 * Description of ExcelTest (even if self-explaining)
 *
 * @author agottardi
 */
use CSVMapper\Configuration\SettingManager;
use CSVMapper\Configuration\Yaml\YamlSettingManager;
use CSVMapper\Configuration\MappingManager;
use CSVMapper\Configuration\Yaml\YamlMappingManager;
use CSVMapper\Configuration\ErrorManager;
use CSVMapper\Exception\WrongColumnsNumberException;
use CSVMapper\Exception\ConfigurationMissingExcepion;

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
        $file = new Source\ExcelFile;
        $file->setColumnsAllowed(3);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->open();

        $this->assertFalse($file->getHandler() == null);
    }

    public function testHasRowWithAvailableRows() {
        $file = new Source\ExcelFile;
        $file->setColumnsAllowed(3);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBook.xlsx');
        $file->open();

        $hasRow = $file->hasRow();
        $this->assertTrue($hasRow);
    }

    public function testHasRowWithNoRows() {
        $file = new Source\ExcelFile;
        $file->setColumnsAllowed(0);
        $file->setFolder('./tests/ExcelTest');
        $file->setName('TestBookEmpty.xlsx');
        $file->open();

        $hasRow = $file->hasRow();
        $this->assertFalse($hasRow);
    }

    public function testGetRow() {

        $array = array();

        $file = new Source\ExcelFile;
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

        $XLSFile = new Source\ExcelFile;
        $XLSFile->setColumnsAllowed(0);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');

        $XLSMapping = new MappingManager();

        $XLSMapping->set_mapping("campo1", array('key' => 0, 'fn' => FALSE, 'test' => FALSE));
        $XLSMapping->set_mapping("campo2", array('key' => 1, 'fn' => FALSE, 'test' => FALSE));
        $XLSMapping->set_mapping("campo3", array('key' => 2, 'fn' => FALSE, 'test' => FALSE));

//        $XLSMapping = new YamlMappingManager($XLSFile->getPath());
//        $XLSSetting = new YamlSettingManager($XLSFile->getPath());
        $XLSError = new ErrorManager();
        $XLSParser = new Parser\Parser();
        $XLSReader = new Reader\Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        while ($XLSReader->hasNextRow()) {
            array_push($rows, $XLSReader->getNextRow());
        }


        $this->assertEquals($this->testResult, $rows);
    }

}
