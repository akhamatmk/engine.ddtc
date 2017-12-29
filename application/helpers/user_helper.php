<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('get_user_data'))
{
	function get_user_data($id)
	{
		if($id == 0)
		{
			return false;
		}
		else
		{
			$CI =& get_instance();

			$CI->load->model('user_model');

			$user= $CI->user_model->get($id);

			return $user;	
		}
	}
}

// --------------------------------------------------------------------
