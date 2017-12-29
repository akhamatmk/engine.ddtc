<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noaccess extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('signin');
    	}
	}

	public function index()
	{
		$this->template->set('title', 'No Access - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/noaccess/noaccess');
	}
}
