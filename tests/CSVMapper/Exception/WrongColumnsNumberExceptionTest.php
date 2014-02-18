<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CSVMapper\Exception;
/**
 * Description of WrongColumnsNumberExceptionTest
 *
 * @author agottardi
 */

class WrongColumnsNumberExceptionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException CSVMapper\Exception\WrongColumnsNumberException
     */
    public function testWrongColumnsNumber() {
        $CME = new WrongColumnsNumberException('Error', 0 , null);
        throw $CME;
    }
    
    
    public function testWrongColumnsNumbertoString() {
        $WCE = new WrongColumnsNumberException('Error', 0, null);
        $this->assertEquals("CSVMapper\Exception\WrongColumnsNumberException: [0]: Error ", $WCE->__toString());
    }
}
