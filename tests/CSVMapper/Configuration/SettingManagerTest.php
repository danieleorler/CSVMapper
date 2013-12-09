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

		public function testSetExistingSetting()
		{
			$manager = new SettingManager();
			$manager->set_setting("folder", "./tests");
			$result = $manager->set_setting("folder", "./tests");
			$this->assertEquals($result,FALSE);
		}

		public function testGetNonExistingSetting()
		{
			$manager = new SettingManager();
			$manager->set_setting("folder", "./tests");
			$result = $manager->get_setting("separator");
			$this->assertEquals($result,FALSE);
		}

		public function testDeleteExistingSetting()
		{
			$manager = new SettingManager();
			$manager->set_setting("folder", "./tests");
			$result = $manager->delete_setting("folder");
			$this->assertEquals($result,TRUE);
		}

		public function testDeleteNonExistingSetting()
		{
			$manager = new SettingManager();
			$manager->set_setting("folder", "./tests");
			$result = $manager->delete_setting("separator");
			$this->assertEquals($result,FALSE);
		}
	}