<?php

	namespace CSVMapper\Configuration;

	class MappingManagerTest extends \PHPUnit_Framework_TestCase
	{
		public function testHandleError()
		{
			$manager = new MappingManager();
			$manager->set_mapping("mese", array('key'=>4, 'fn'=>'$input','$period = explode("/",$input); return intval($period[1]);','test'=>FALSE));
			
			$expected = array('key'=>4, 'fn'=>'$input','$period = explode("/",$input); return intval($period[1]);','test'=>FALSE);
			$result = $manager->get_mapping("mese");
			$this->assertEquals($result,$expected);
		}
	}