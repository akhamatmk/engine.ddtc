<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P3b extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('p3b_model');
    	$this->load->model('p3b_article_model');
		$this->load->library('pagination');

        $this->load->helper('peraturan_pajak_helper');

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
		redirect('webcontrol/p3b/semua');
		/*
		$data['p3b'] = $this->p3b_model->get_all_order_by('p3b_id', 'desc');

		$this->template->set('title', 'P3B - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/p3b/p3b', $data);
		*/
	}

	public function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('p3b_country', 'Country', 'trim|required');
        $this->form_validation->set_rules('p3b_date_signed', 'Signed Date', 'trim|required');
        $this->form_validation->set_rules('p3b_date_effective', 'Effective Date', 'trim|required');

        $this->form_validation->set_rules('p3b_header_id', 'Header', 'trim');
        $this->form_validation->set_rules('p3b_header_en', 'Header', 'trim');

        $this->form_validation->set_rules('p3b_chapter[]', 'Chapter', 'trim');

        $this->form_validation->set_rules('p3b_chapter_title_id[]', 'Chapter Title', 'trim');
        $this->form_validation->set_rules('p3b_chapter_title_en[]', 'Chapter Title', 'trim');

        $this->form_validation->set_rules('p3b_article_title_id[]', 'Article Title', 'trim');
        $this->form_validation->set_rules('p3b_article_title_en[]', 'Article Title', 'trim');

        $this->form_validation->set_rules('p3b_article_content_id[]', 'Article Content', 'trim');
        $this->form_validation->set_rules('p3b_article_content_en[]', 'Article Content', 'trim');

        $this->form_validation->set_rules('p3b_protocol_id', 'Protocol', 'trim');
        $this->form_validation->set_rules('p3b_protocol_en', 'Protocol', 'trim');

        $this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

        if($this->form_validation->run() == FALSE)
        {
            $this->template->set('title', 'P3B - Add - '.$this->config->item('web_title'));
            $this->template->load('webcontrol/template/template-form', 'webcontrol/p3b/p3b-add');
        }
        else
        {
            $p3b_country = $this->input->post('p3b_country');

            $p3b_date_signed = $this->input->post('p3b_date_signed');   
            $p3b_date_effective = $this->input->post('p3b_date_effective');

            $p3b_header_id = $this->input->post('p3b_header_id');   
            $p3b_header_en = $this->input->post('p3b_header_en');   

            $p3b_protocol_id = $this->input->post('p3b_protocol_id');   
            $p3b_protocol_en = $this->input->post('p3b_protocol_en');

            $data = array(
                    'p3b_url'           => url_title($p3b_country, '-', TRUE),
                    'p3b_country'       => $p3b_country,
                    'p3b_date_signed'   => $p3b_date_signed,
                    'p3b_date_effective'=> $p3b_date_effective,
                    'p3b_header_id'     => $p3b_header_id,
                    'p3b_header_en'     => $p3b_header_en,
                    'p3b_protocol_id'   => $p3b_protocol_id,
                    'p3b_protocol_en'   => $p3b_protocol_en,
                );
            $this->p3b_model->insert($data);

            $p3b_id = $this->db->insert_id();

            $check = $this->input->post('check');

            $p3b_article_p3b = $p3b_id;

            $p3b_chapter = $this->input->post('p3b_chapter');

            $p3b_chapter_title_id = $this->input->post('p3b_chapter_title_id');
            $p3b_chapter_title_en = $this->input->post('p3b_chapter_title_en');

            $p3b_article_title_id = $this->input->post('p3b_article_title_id');
            $p3b_article_title_en = $this->input->post('p3b_article_title_en');

            $p3b_article_content_id = $this->input->post('p3b_article_content_id');
            $p3b_article_content_en = $this->input->post('p3b_article_content_en');

            $p3b_article_number = 1;
            foreach($check as $key => $value)
            {
                $data = array(
                        'p3b_article_p3b'               => $p3b_article_p3b,
                        'p3b_article_number'            => $p3b_article_number,
                        'p3b_article_chapter'           => $p3b_chapter[$key],
                        'p3b_article_chapter_title_id'  => $p3b_chapter_title_id[$key],
                        'p3b_article_chapter_title_en'  => $p3b_chapter_title_en[$key],
                        'p3b_article_title_id'          => $p3b_article_title_id[$key],
                        'p3b_article_title_en'          => $p3b_article_title_en[$key],
                        'p3b_article_content_id'        => $p3b_article_content_id[$key],
                        'p3b_article_content_en'        => $p3b_article_content_en[$key]
                    );

                if((!empty($p3b_article_content_id[$key]) || $p3b_article_content_id[$key] != "") || (!empty($p3b_article_content_en[$key]) || $p3b_article_content_en[$key] != ""))
                {
                    $this->p3b_article_model->insert($data);

                    $p3b_article_number++;
                }
            }

            redirect('webcontrol/p3b/edit/'.$p3b_id);
        }
    }

    public function edit($p3b_id)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('p3b_country', 'Country', 'trim|required');
        $this->form_validation->set_rules('p3b_date_signed', 'Signed Date', 'trim|required');
        $this->form_validation->set_rules('p3b_date_effective', 'Effective Date', 'trim|required');

        $this->form_validation->set_rules('p3b_header_id', 'Header', 'trim');
        $this->form_validation->set_rules('p3b_header_en', 'Header', 'trim');

        $this->form_validation->set_rules('p3b_chapter[]', 'Chapter', 'trim');

        $this->form_validation->set_rules('p3b_chapter_title_id[]', 'Chapter Title', 'trim');
        $this->form_validation->set_rules('p3b_chapter_title_en[]', 'Chapter Title', 'trim');

        $this->form_validation->set_rules('p3b_article_title_id[]', 'Article Title', 'trim');
        $this->form_validation->set_rules('p3b_article_title_en[]', 'Article Title', 'trim');

        $this->form_validation->set_rules('p3b_article_content_id[]', 'Article Content', 'trim');
        $this->form_validation->set_rules('p3b_article_content_en[]', 'Article Content', 'trim');

        $this->form_validation->set_rules('p3b_protocol_id', 'Protocol', 'trim');
        $this->form_validation->set_rules('p3b_protocol_en', 'Protocol', 'trim');

        $this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

        if($this->form_validation->run() == FALSE)
        {
            $data['p3b'] = $this->p3b_model->get($p3b_id);
            $data['p3b_article'] = $this->p3b_article_model->get_all_article($p3b_id);

            $this->template->set('title', 'P3B - Edit - '.$this->config->item('web_title'));
            $this->template->load('webcontrol/template/template-form', 'webcontrol/p3b/p3b-edit', $data);
        }
        else
        {
            $p3b_country = $this->input->post('p3b_country');

            $p3b_date_signed = $this->input->post('p3b_date_signed');   
            $p3b_date_effective = $this->input->post('p3b_date_effective');

            $p3b_header_id = $this->input->post('p3b_header_id');   
            $p3b_header_en = $this->input->post('p3b_header_en');   

            $p3b_protocol_id = $this->input->post('p3b_protocol_id');   
            $p3b_protocol_en = $this->input->post('p3b_protocol_en');

            $data = array(
                    'p3b_url'           => url_title($p3b_country, '-', TRUE),
                    'p3b_country'       => $p3b_country,
                    'p3b_date_signed'   => $p3b_date_signed,
                    'p3b_date_effective'=> $p3b_date_effective,
                    'p3b_header_id'     => $p3b_header_id,
                    'p3b_header_en'     => $p3b_header_en,
                    'p3b_protocol_id'   => $p3b_protocol_id,
                    'p3b_protocol_en'   => $p3b_protocol_en,
                );
            $this->p3b_model->update($p3b_id, $data);

            $check = $this->input->post('check');

            $p3b_article_p3b = $p3b_id;

            $p3b_chapter = $this->input->post('p3b_chapter');

            $p3b_chapter_title_id = $this->input->post('p3b_chapter_title_id');
            $p3b_chapter_title_en = $this->input->post('p3b_chapter_title_en');

            $p3b_article_title_id = $this->input->post('p3b_article_title_id');
            $p3b_article_title_en = $this->input->post('p3b_article_title_en');

            $p3b_article_content_id = $this->input->post('p3b_article_content_id');
            $p3b_article_content_en = $this->input->post('p3b_article_content_en');

            $this->p3b_article_model->delete_by_parent($p3b_article_p3b);

            $p3b_article_number = 1;
            foreach($check as $key => $value)
            {
                $data = array(
                        'p3b_article_p3b'               => $p3b_article_p3b,
                        'p3b_article_number'            => $p3b_article_number,
                        'p3b_article_chapter'           => $p3b_chapter[$key],
                        'p3b_article_chapter_title_id'  => $p3b_chapter_title_id[$key],
                        'p3b_article_chapter_title_en'  => $p3b_chapter_title_en[$key],
                        'p3b_article_title_id'          => $p3b_article_title_id[$key],
                        'p3b_article_title_en'          => $p3b_article_title_en[$key],
                        'p3b_article_content_id'        => $p3b_article_content_id[$key],
                        'p3b_article_content_en'        => $p3b_article_content_en[$key]
                    );

                if((!empty($p3b_article_content_id[$key]) || $p3b_article_content_id[$key] != "") || (!empty($p3b_article_content_en[$key]) || $p3b_article_content_en[$key] != ""))
                {
                    $this->p3b_article_model->insert($data);

                    $p3b_article_number++;
                }
            }

            redirect('webcontrol/p3b/edit/'.$p3b_id);
        }
    }

    public function view($p3b_id)
    {
        $data['p3b'] = $this->p3b_model->get($p3b_id);
        $data['p3b_article'] = $this->p3b_article_model->get_all_article($p3b_id);

        $this->template->set('title', 'P3B - View - '.$this->config->item('web_title'));
        $this->template->load('webcontrol/template/template-table', 'webcontrol/p3b/p3b-view', $data);
    }

    public function semua($p3b_id)
	{
		//$data['p3b'] = $this->p3b_model->get_all_order_by('p3b_id', 'desc');
		if(empty($this->uri->segment(4))) $page = 1;
        else $page = $this->uri->segment(4);
		
		$show = $this->input->get('show', TRUE);
		if(empty($show)) $show = $this->config->item('perpage');
		
		if($this->input->get('search', TRUE)) {
			$data['p3b'] = $this->p3b_model->get_all_search_perpage($page,$show,$this->input->get('search', TRUE));
			$counter = $this->p3b_model->countallsearch($this->input->get('search', TRUE));
		} else {
			$data['p3b'] = $this->p3b_model->get_all_perpage($page,$show);
			$counter = $this->p3b_model->countall();
		}
		
		/*Pagination*/
        $config['base_url'] = site_url('webcontrol/p3b/semua');
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
		

		$this->template->set('title', 'P3B - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/p3b/p3b-semua', $data);
	}

	public function publish($p3b_id)
	{
		$data = array('p3b_status' => 1);

		$update = $this->p3b_model->update($p3b_id, $data);

		if($update)
		{
			redirect('webcontrol/p3b');
		}
		else
		{
			redirect('webcontrol/p3b');
		}
	}

	public function unpublish($p3b_id)
	{
		$data = array('p3b_status' => 0);

		$update = $this->p3b_model->update($p3b_id, $data);

		if($update)
		{
			redirect('webcontrol/p3b');
		}
		else
		{
			redirect('webcontrol/p3b');
		}
	}

	public function delete($p3b_id)
	{
        $delete = $this->p3b_model->delete($p3b_id);

		$delete_article = $this->p3b_article_model->delete_by_parent($p3b_id);

		if($delete && $delete_article)
		{
			redirect('webcontrol/p3b');
		}
		else
		{
			redirect('webcontrol/p3b');
		}
	}
}
