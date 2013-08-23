<?php

	namespace CSVMapper\Configuration;

	class ErrorManagerTest extends \PHPUnit_Framework_TestCase
	{
		public function testHandleError()
		{
			$manager = new ErrorManager();
			$manager->add_error("Test Error");
			$manager->add_error("Test Error2");

			$this->assertEquals($manager->get_errors(","), "Test Error,Test Error2");
		}
	}