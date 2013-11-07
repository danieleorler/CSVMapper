<?php

namespace CSVMapper;

use CSVMapper\Configuration\SettingManager;
use CSVMapper\Configuration\MappingManager;
use CSVMapper\Configuration\ErrorManager;
use CSVMapper\Exception\WrongColumnsNumberException;
use CSVMapper\Exception\ConfigurationMissingExcepion;

class Csv
{

	private $error_manager;
	private $mapping_manager;
	private $setting_manager;

	function __contruct()
	{
		$this->errors = array();
	}

	/**
	 * sets the mapping manager
	 * @param MappingManager $manager
	 */
	function set_mapping_manager(MappingManager $manager)
	{
		$this->mapping_manager = $manager;
	}

	/**
	 * sets the setting manager
	 * @param SettingManager $manager
	 */
	function set_setting_manager(SettingManager $manager)
	{
		$this->setting_manager = $manager;
	}

	/**
	 * sets the error manager
	 * @param ErrorManager $manager
	 */
	function set_error_manager(ErrorManager $manager)
	{
		$this->error_manager = $manager;
	}

	/**
	 * loops all the file rows
	 * @return Array[mixed] the result of the parser application on each row
	 */
	function looper()
	{
		if(!$this->setting_manager->get_setting('folder'))
		{
			throw new ConfigurationMissingExcepion(sprintf("Configuration %s is missing!",'folder'), 2);
		}

		if(!$this->setting_manager->get_setting('filename'))
		{
			throw new ConfigurationMissingExcepion(sprintf("Configuration %s is missing!",'filename'), 3);
		}

		$filepath = sprintf("%s/%s",$this->setting_manager->get_setting('folder'),$this->setting_manager->get_setting('filename'));
		$file = fopen($filepath, "r");

		if($this->setting_manager->get_setting('separator') !== null)
		{
			$separator = $this->setting_manager->get_setting('separator');
		}
		else
		{
			$separator = ';';
		}

		if($this->setting_manager->get_setting('columns_allowed') !== null)
		{
			$columns_count = count(explode($separator,fgets($file)));
			$allowed_count = $this->setting_manager->get_setting('columns_allowed');
		}
		else
		{
			$allowed_count = FALSE;
		}

		if($allowed_count && $columns_count != $allowed_count)
		{
			fclose($file);
			throw new WrongColumnsNumberException(sprintf("Expected %d columns, found %d!",$allowed_count,$columns_count), 1);
		}
		else
		{
			fseek($file, 0);
			$rows = array();
			while (!feof($file))
			{
				$line = fgets($file);
				if(strlen($line) > 0)
				{
					if($row = $this->parser(explode($separator,$line)))
					{
						$rows[] = $row;
					}
				}
			}

			fclose($file);
			return $rows;
		}
	}

	/**
	 * parser generico, dato un mapping estrae e formatta le informazioni contenute in una linea
	 * @param  Array[mixed] the extracted row to precces
	 * @return Array[mixed] row parsed
	 */
	function parser($row)
	{
		$result = array();

		foreach($this->mapping_manager->get_all_mappings() AS $key=>$field)
		{
			if(isset($field['key']) && !is_null($field['key']))
			{
				$input = $this->remove_quotes($row[$field['key']]);
			}
			else
			{
                                $input = $field['value'];
			}

			if(isset($field['test']) && $field['test'] && !$field['test']($input))
			{
				$this->error_manager->add_error("Field {$key} didn't pass the test!");
				return FALSE;
			}
			else
			{
				if(isset($field['fn']) && $field['fn'])
				{
					$result[$key] = $field['fn']($input);
				}
				else
				{
					$result[$key] = $input;
				}
			}
		}

		return $result;
	}

	/**
	 * [remove_quotes description]
	 * @param  String $input
	 * @return String
	 */
	function remove_quotes($input)
	{
		if(strlen($input) > 0)
		{
			if(substr($input, 0, 1) == '"')
			{
				$input = substr($input, 1);
			}

			if(substr($input, -1) == '"')
			{
				$input = substr($input, 0, -1);
			}
		}

		return $input;
	}
}
