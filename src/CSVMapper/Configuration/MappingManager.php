<?php

namespace CSVMapper\Configuration;

class MappingManager
{

	private $mappings;

	/**
	 * set a mapping
	 * @param String $key     mapping's key
	 * @param Object $value   mapping's value
	 */
	function set_mapping($key,$value)
	{
		if(isset($this->mappings[$key]))
		{
			return FALSE;
		}
		else
		{
			return $this->mappings[$key] = $value;
		}
	}

	/**
	 * retrieve a mapping
	 * @param  String $key mapping's key
	 * @return Array[mixed]
	 */
	function get_mapping($key)
	{
		if(isset($this->mappings[$key]))
		{
			return $this->mappings[$key];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * retrieve all mapping
	 * @return Array[mixed]
	 */
	function get_all_mappings()
	{
		return $this->mappings;
	}

	/**
	 * delete a mapping
	 * @param  String $key mapping's key
	 * @return Boolean
	 */
	function delete_setting($key)
	{
		if(isset($this->mappings[$key]))
		{
			unset($this->mappings[$key]);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}