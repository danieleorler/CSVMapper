<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper\Reader;

/**
 * Description of ReaderTest
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

class ReaderTest extends \PHPUnit_Framework_TestCase {

    public function testReaderGetSetFile() {

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

    public function testReaderGetSetParser() {

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

}
