<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('regulasi_pajak_model');
    	$this->load->model('putusan_pengadilan_model');
    	$this->load->model('p3b_model');
    	$this->load->model('putusan_ma_model');

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}
	}

	public function index()
	{
		$data['rp_top_view'] = $this->regulasi_pajak_model->get_top_view();
		$data['rp_top_download'] = $this->regulasi_pajak_model->get_top_download();

		$data['pp_top_view'] = $this->putusan_pengadilan_model->get_top_view();
		$data['pp_top_download'] = $this->putusan_pengadilan_model->get_top_download();

		$data['p3b_top_view'] = $this->p3b_model->get_top_view();
		$data['p3b_top_download'] = $this->p3b_model->get_top_download();

		$data['ma_top_view'] = $this->putusan_ma_model->get_top_view();
		$data['ma_top_download'] = $this->putusan_ma_model->get_top_download();

		$this->template->set('title', 'Home - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-home', 'webcontrol/home/home', $data);
	}

	public function session()
	{
		echo '<pre>';
		print_r($this->session->all_userdata());
		echo '</pre>';
	}

	public function level_check($admin_level, $class, $method)
	{
		$level_auth = config_item('level_auth');

		echo '<pre>';
		print_r($level_auth);
		echo '</pre>';

		$check = check_access($admin_level, $class, $method);

		if($check) echo "OK";
		else echo "NOT OK";
	}
}
