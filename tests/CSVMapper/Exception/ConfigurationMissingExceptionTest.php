<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CSVMapper\Exception;

/**
 * Description of ExceptionsTest
 *
 * @author agottardi
 */
class ConfigurationMissingExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException CSVMapper\Exception\ConfigurationMissingException
     */
    public function testConfigurationMissing() {
        $CME = new ConfigurationMissingException('Error', 0, null);
        throw $CME;
    }

    public function testConfigurationMissingtoString() {
        $CME = new ConfigurationMissingException('Error', 0, null);
        $this->assertEquals("CSVMapper\Exception\ConfigurationMissingException: [0]: Error ", $CME->__toString());
    }

}
