<?php

	namespace CSVMapper\Configuration;

	class MappingManagerTest extends \PHPUnit_Framework_TestCase
	{
		public function testHandleError()
		{
			$manager = new MappingManager();
			$manager->set_mapping("month", array('key'=>4, 'fn'=>'$input','$period = explode("/",$input); return intval($period[1]);','test'=>FALSE));
			
			$expected = array('key'=>4, 'fn'=>'$input','$period = explode("/",$input); return intval($period[1]);','test'=>FALSE);
			$result = $manager->get_mapping("month");
			$this->assertEquals($result,$expected);
		}

		public function testSetExistingMapping()
		{
			$manager = new MappingManager();
			$manager->set_mapping("month", array('key'=>4, 'fn'=>FALSE,'test'=>FALSE));
			$result = $manager->set_mapping("month", array('key'=>4, 'fn'=>FALSE,'test'=>FALSE));
			$this->assertEquals($result,FALSE);
		}

		public function testGetNonExistingMapping()
		{
			$manager = new MappingManager();
			$manager->set_mapping("month", array('key'=>4, 'fn'=>FALSE,'test'=>FALSE));
			$result = $manager->get_mapping("year");
			$this->assertEquals($result,FALSE);
		}

		public function testDeleteExistingMapping()
		{
			$manager = new MappingManager();
			$manager->set_mapping("month", array('key'=>4, 'fn'=>FALSE,'test'=>FALSE));
			$result = $manager->delete_mapping("month");
			$this->assertEquals($result,TRUE);
		}

		public function testDeleteNonExistingMapping()
		{
			$manager = new MappingManager();
			$manager->set_mapping("month", array('key'=>4, 'fn'=>FALSE,'test'=>FALSE));
			$result = $manager->delete_mapping("year");
			$this->assertEquals($result,FALSE);
		}
	}