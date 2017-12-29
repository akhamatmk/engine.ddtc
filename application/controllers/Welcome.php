<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('user_model');
    	$this->load->model('jenis_dokumen_model');

    	$this->load->library('facebook');
	}

	public function index()
	{
		/*
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

    	//----------------------
    	//Home SEARCH validation
    	//----------------------
		$this->load->library('form_validation');
		$this->form_validation->set_rules('key', 'Key word', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

		if($this->form_validation->run() == FALSE)
		{
			$data['jenis_dokumen'] = $this->jenis_dokumen_model->get_all_publish_order_by('jenis_dokumen_name', 'desc');

			$this->template->set('title', 'Welcome - '.$this->config->item('web_title'));
			$this->template->load('web/template/template-0', 'web/welcome/welcome', $data);
		}
		else
		{
			$jenis_dokumen_array = $this->input->post('jenis_dokumen');
			$key = $this->input->post('key');

			if(!empty($jenis_dokumen_array))
			{
				$jenis_dokumen_url = implode('_', $jenis_dokumen_array);
			}
			else
			{
				$jenis_dokumen_url = 'semua-dokumen';
			}

			$key_url = url_title($key, '_', TRUE);

			redirect('peraturan-pajak/search/'.$key_url.'/semua-kategori/'.$jenis_dokumen_url.'/00-00-0000_00-00-0000/0000/0_0/kalimat/0/tahun');
		}
		//----------------------
		*/

		redirect('home');
	}
}
