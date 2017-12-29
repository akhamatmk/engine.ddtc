<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('user_model');

    	$this->load->helper('user_helper');

    	//auth
    	$admin_level = $this->session->admin_level;
    	$class = $this->router->fetch_class();
  		$method = $this->router->fetch_method();

  		$check = check_access($admin_level, $class, $method);

  		if(!$check)
  		{
  			redirect('webcontrol/noaccess');
  		}
    	//----
	}

	public function index()
	{
		$data['user'] = $this->user_model->get_all_order_by('user_id', 'desc');

		$this->template->set('title', 'User - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/user/user', $data);
	}

	public function publish($user_id)
	{
		$data = array('user_status' => 1);

		$update = $this->user_model->update($user_id, $data);

		if($update)
		{
			redirect('webcontrol/user');
		}
		else
		{
			redirect('webcontrol/user');
		}
	}

	public function unpublish($user_id)
	{
		$data = array('user_status' => 0);

		$update = $this->user_model->update($user_id, $data);

		if($update)
		{
			redirect('webcontrol/user');
		}
		else
		{
			redirect('webcontrol/user');
		}
	}
}
