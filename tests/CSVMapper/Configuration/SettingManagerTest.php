<?php

	namespace CSVMapper\Configuration;

	class SettingManagerTest extends \PHPUnit_Framework_TestCase
	{
		public function testHandleError()
		{
			$manager = new SettingManager();
			$manager->set_setting("folder", "C:\dev");
			
			$expected = "C:\dev";
			$result = $manager->get_setting("folder");

			$this->assertEquals($result,$expected);
		}
	}