<?php

namespace CSVMapper\Configuration;

class ErrorManager
{
	private $errors;

	/**
	 * add an error to the list
	 * @param Object $error
	 */
	function add_error($error)
	{
		$this->errors[] = $error;
	}

	/**
	 * retrieve all errors concatenated
	 * @param  String $separator the String which will separate the errors
	 * @return String
	 */
	function get_errors($separator)
	{
		return implode($separator, $this->errors);
	}
}