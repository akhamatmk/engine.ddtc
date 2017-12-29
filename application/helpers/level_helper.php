<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('check_access'))
{
	function check_access($level, $class, $method)
	{
		$level_auth = config_item('level_auth');

		$result = $level_auth[$level][$class][$method];

		return $result;
	}
}

// --------------------------------------------------------------------
