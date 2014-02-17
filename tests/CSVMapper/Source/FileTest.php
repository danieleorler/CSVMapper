<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CSVMapper\Source;
/**
 * Description of FileTest
 *
 * @author agottardi
 */
class FileTest  extends \PHPUnit_Framework_TestCase {
    public function testResetFile()
    {
        $file = new File();
        
        $this->assertTrue($file->reset());
    }
    
        public function testCloseFile()
    {
        $file = new File();
        
        $this->assertFalse($file->close());
    }
}
