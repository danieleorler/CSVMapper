<?php

namespace CSVMapper\Configuration;

class SettingManager
{
	private $settings;

	function __construct()
	{
		$this->settings = array();
	}

	/**
	 * store a setting
	 * @param String $key    setting's key
	 * @param Object $value  setting's value
	 * @return Boolean
	 */
	function set_setting($key,$value)
	{
		if(isset($this->settings[$key]))
		{
			return FALSE;
		}
		else
		{
			$this->settings[$key] = $value;
			return TRUE;
		}
	}

	/**
	 * retrieve a setting
	 * @param  String $key setting's key
	 * @return Object or Boolean
	 */
	function get_setting($key)
	{
		if(isset($this->settings[$key]))
		{
			return $this->settings[$key];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * delete a setting
	 * @param  String $key setting's key
	 * @return Boolean
	 */
	function delete_setting($key)
	{
		if(isset($this->settings[$key]))
		{
			unset($this->settings[$key]);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}