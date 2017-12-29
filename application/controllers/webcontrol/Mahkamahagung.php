<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahkamahagung extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('mahkamahagung_model');
    	$this->load->model('putusan_ma_model');
		$this->load->library('pagination');

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
		redirect('webcontrol/mahkamahagung/semua');
		/*
		$data['ma'] = $this->mahkamahagung_model->get_all_order_by('ma_id', 'desc');

		$this->template->set('title', 'Mahkamah Agung - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/mahkamahagung/mahkamahagung', $data);
		*/
	}

	public function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('ma_number', 'Mahkamah Agung Number', 'trim|required|is_unique[mahkamahagung.ma_number]');
		$this->form_validation->set_rules('ma_year', 'Mahkamah Agung Year', 'trim|required|is_natural');
		$this->form_validation->set_rules('ma_content', 'Mahkamah Agung Content', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$this->template->set('title', 'Mahkamah Agung - Add - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/mahkamahagung/mahkamahagung-add');
        }
        else
        {
         	$ma_number = $this->input->post('ma_number');
         	$ma_year = $this->input->post('ma_year');
         	$ma_content = $this->input->post('ma_content', FALSE);

         	$permalink = str_replace('/', ' ',$ma_number);
            $permalink = str_replace('.', ' ',$ma_number);

         	$data = array(
         			'ma_url'			=> url_title('Putusan Mahkamah Agung Nomor: '.$permalink, '-', TRUE),
         			'ma_number'			=> $ma_number,
         			'ma_year'			=> $ma_year,
         			'ma_content'		=> $ma_content,
         			'ma_status'			=> 4
         		);

         	$insert = $this->mahkamahagung_model->insert($data);

         	$ma_id = $this->db->insert_id();

         	if($insert)
         	{
         		redirect('webcontrol/mahkamahagung/edit/'.$ma_id);
         	}
         	else
         	{
         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

         		$this->template->set('title', 'Mahkamah Agung - Add - '.$this->config->item('web_title'));
				$this->template->load('webcontrol/template/template-form', 'webcontrol/mahkamahagung/mahkamahagung-add');
         	}
        }
	}

	public function edit($ma_id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('ma_number', 'Mahkamah Agung Number', 'trim|required');
		$this->form_validation->set_rules('ma_year', 'Mahkamah Agung Year', 'trim|required|is_natural');
		$this->form_validation->set_rules('ma_content', 'Mahkamah Agung Content', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$data['ma'] = $this->mahkamahagung_model->get($ma_id);

        	$this->template->set('title', 'Mahkamah Agung - Edit - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/mahkamahagung/mahkamahagung-edit', $data);
        }
        else
        {
         	$ma_number = $this->input->post('ma_number');
         	$ma_year = $this->input->post('ma_year');
         	$ma_content = $this->input->post('ma_content', FALSE);

         	$ma = $this->mahkamahagung_model->get($ma_id);
         	$ma_status = $ma['ma_status'];

         	if($ma_status == 0 || $ma_status == 2) $mas = 0;
         	else $mas = $ma_status;

         	$permalink = str_replace('/', ' ',$ma_number);
            $permalink = str_replace('.', ' ',$ma_number);

         	$data = array(
         			'ma_url'			=> url_title('Putusan Mahkamah Agung Nomor: '.$permalink, '-', TRUE),
         			'ma_number'			=> $ma_number,
         			'ma_year'			=> $ma_year,
         			'ma_content'		=> $ma_content,
         			'ma_status'			=> $mas
         		);

         	$update = $this->mahkamahagung_model->update($ma_id, $data);

         	if($update)
         	{
         		redirect('webcontrol/mahkamahagung/edit/'.$ma_id);
         	}
         	else
         	{
         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot update data to database.</p>');

         		$data['ma'] = $this->mahkamahagung_model->get($ma_id);

         		$this->template->set('title', 'Mahkamah Agung - Edit - '.$this->config->item('web_title'));
				$this->template->load('webcontrol/template/template-form', 'webcontrol/mahkamahagung/mahkamahagung-edit', $data);
         	}
        }
	}

	public function view($ma_id)
	{
		$data['ma'] = $this->mahkamahagung_model->get($ma_id);

 		$this->template->set('title', 'Mahkamah Agung - View - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/mahkamahagung/mahkamahagung-view', $data);
	}

	public function semua($ma_id)
	{
		//$data['ma'] = $this->mahkamahagung_model->get_all_perpage($page, $perpage);
		
		if(empty($this->uri->segment(4))) $page = 1;
        else $page = $this->uri->segment(4);
		
		$show = $this->input->get('show', TRUE);
		if(empty($show)) $show = $this->config->item('perpage');
		
		if($this->input->get('search', TRUE)) {
			$data['ma'] = $this->putusan_ma_model->get_all_search_perpage($page,$show,$this->input->get('search', TRUE));
			$counter = $this->putusan_ma_model->countallsearch($this->input->get('search', TRUE));
		} else {
			$data['ma'] = $this->putusan_ma_model->get_all_perpage($page,$show);
			$counter = $this->putusan_ma_model->countall();
		}
		
		/*Pagination*/
        $config['base_url'] = site_url('webcontrol/mahkamahagung/semua');
		$config['total_rows'] =  $counter;
		$data['total_rows'] =  $counter;
		if($page == 1) {
			$data['current_page_start'] =  1;
			$data['current_page_end'] =  $page * $show;
		} else {
			$data['current_page_start'] =  (($page - 1) * $show) + 1;
			$data['current_page_end'] =  (($page - 1) * $show) + $show;
		}
		if($data['current_page_end'] > $counter) {
			$data['current_page_end'] = $counter;
		}
		$config['per_page'] = $show;

		$config['use_page_numbers'] = true;
		$config['num_links'] = 3;

		$config['full_tag_open'] = '<ul class="pagination paginationcustom">';
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';		

		$config['first_link'] = false;
		$config['last_link'] = false;

		$this->pagination->initialize($config);

		$data['paging'] = $this->pagination->create_links();
		/*----------*/
		
		$this->template->set('title', 'Mahkamah Agung - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/mahkamahagung/mahkamahagung-semua', $data);
	}

	public function publish($ma_id)
	{
		$data = array('ma_status' => 3);

		$update = $this->mahkamahagung_model->update($ma_id, $data);

		if($update)
		{
			redirect('webcontrol/mahkamahagung');
		}
		else
		{
			redirect('webcontrol/mahkamahagung');
		}
	}

	public function unpublish($ma_id)
	{
		$data = array('ma_status' => 4);

		$update = $this->mahkamahagung_model->update($ma_id, $data);

		if($update)
		{
			redirect('webcontrol/mahkamahagung');
		}
		else
		{
			redirect('webcontrol/mahkamahagung');
		}
	}

	public function delete($ma_id)
	{
		$delete = $this->mahkamahagung_model->delete($ma_id);

		if($delete)
		{
			redirect('webcontrol/mahkamahagung');
		}
		else
		{
			redirect('webcontrol/mahkamahagung');
		}
	}
}
