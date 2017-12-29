<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('page_model');

    	$this->load->library('facebook');
	}

	public function index()
	{
		redirect('home');
	}

	public function view($page_url)
	{
		//----------------------
    	//GET Facebook Login URL
    	//----------------------
    	$fb_data = $this->facebook->login();

    	if(!isset($fb_data['me']))
    	{
    		$data['facebook_login'] = $fb_data['loginUrl'];
    	}
    	else
    	{
    		$data['facebook_login'] = '';
    	}
    	//----------------------
    	
		$page = $this->page_model->get_by('page_url', $page_url);

		$data['page'] = $page;

		if($page['page_url'] == 'frequently-asked-question') $page_class = "faq";
		else $page_class = $page['page_url'];

		$data['page_class'] = $page_class;
		
		$this->template->set('title', $page['page_title'].' - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-1', 'web/page/page', $data);
	}
}
