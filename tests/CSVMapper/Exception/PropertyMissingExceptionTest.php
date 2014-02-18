<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CSVMapper\Exception;
/**
 * Description of PropertyMissingExceptionTest
 *
 * @author agottardi
 */
class PropertyMissingExceptionTest extends \PHPUnit_Framework_TestCase {
       /**
     * @expectedException CSVMapper\Exception\PropertyMissingException
     */
    public function testPropertyMissing() {
        $PME = new PropertyMissingException('Error', 0 , null);
        throw $PME;
    }
    
    public function testPropertyMissingtoString() {
        $PME = new PropertyMissingException('Error', 0 , null);
        $this->assertEquals("CSVMapper\Exception\PropertyMissingException: [0]: Error ", $PME->__toString());
    }
}
