<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('get_admin_data'))
{
	function get_admin_data($id)
	{
		if($id == 0)
		{
			return false;
		}
		else
		{
			$CI =& get_instance();

			$CI->load->model('admin_model');

			$admin= $CI->admin_model->get($id);

			return $admin;	
		}
	}
}

// --------------------------------------------------------------------
