<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('feedback_model');

    	$this->load->helper('user_helper');
    	$this->load->helper('text');

    	$this->load->library('typography');

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
		$data['feedback'] = $this->feedback_model->get_all_order_by('feedback_id', 'desc');

		$this->template->set('title', 'Feedback - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/feedback/feedback', $data);
	}

	public function publish($admin_id)
	{
		$data = array('feedback_status' => 1);

		$update = $this->feedback_model->update($admin_id, $data);

		if($update)
		{
			redirect('webcontrol/feedback');
		}
		else
		{
			redirect('webcontrol/feedback');
		}
	}

	public function unpublish($admin_id)
	{
		$data = array('feedback_status' => 0);

		$update = $this->feedback_model->update($admin_id, $data);

		if($update)
		{
			redirect('webcontrol/feedback');
		}
		else
		{
			redirect('webcontrol/feedback');
		}
	}
}
