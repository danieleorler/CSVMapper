<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper\Parser;

/**
 * Description of ParserTest
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

class ParserTest extends \PHPUnit_Framework_TestCase {

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

    public function testTestFailed() {
        $result = true;

        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBook.xlsx');
        $XLSFile->setPath('./tests/ExcelTest/TestBook.xlsx');


        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappingsTest.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        while ($XLSReader->hasNextRow()) {
            if ($XLSReader->getNextRow() == false) {
                $result = false;
            }
        }


        $this->assertFalse($result);
    }

    public function testRemoveQuotes() {

        $XLSFile = new ExcelFile;
        $XLSFile->setColumnsAllowed(3);
        $XLSFile->setFolder('./tests/ExcelTest');
        $XLSFile->setName('TestBookQuotes.xlsx');
        $XLSFile->setPath('./tests/ExcelTest/TestBookQuotes.xlsx');


        $XLSMapping = new YamlMappingManager('./tests/ExcelTest/TestBookMappingsTest.yml');
        $XLSError = new ErrorManager();
        $XLSParser = new Parser();
        $XLSReader = new Reader();


        $XLSParser->setErrorManager($XLSError);
        $XLSParser->setMappingManager($XLSMapping);

        $XLSReader->setFile($XLSFile);
        $XLSReader->setParser($XLSParser);

        $result = $XLSParser->remove_quotes("\"try\"");

        $this->assertEquals($result, 'try');
    }

}
