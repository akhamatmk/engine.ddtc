<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

        public function __construct()
        {
                parent::__construct();

                if($this->admin_auth->is_logged_in())
                {
                        redirect('webcontrol/home');
                }
        }

	public function index()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('admin_email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[6]');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

        	if($this->form_validation->run() == FALSE)
                {
                	$data['error'] = "";

                	$this->template->set('title', 'Sign In - '.$this->config->item('web_title'));
        		$this->template->load('webcontrol/template/template-signin', 'webcontrol/signin/signin', $data);
                }
                else
                {
                	$admin_email = $this->input->post('admin_email');
                	$admin_password = $this->input->post('admin_password');

                	$login = $this->admin_auth->do_login($admin_email, $admin_password);

                	if($login == 'success')
                	{
                		redirect('webcontrol/home');
                	}
                	else
                	{
                		$data['error'] = $login;

        	        	$this->template->set('title', 'Sign In - '.$this->config->item('web_title'));
        			$this->template->load('webcontrol/template/template-signin', 'webcontrol/signin/signin', $data);
                	}
                }
	}
}