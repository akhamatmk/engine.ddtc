<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusanpengadilan extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('putusan_pengadilan_model');
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
		redirect('webcontrol/putusanpengadilan/semua');
		/*
        $data['pp'] = $this->putusan_pengadilan_model->get_all_order_by('id', 'desc');
        //$data['pp'] = $this->putusan_pengadilan_model->get_all();
		//$data['pp'] = array();

		$this->template->set('title', 'Putusan Pengadilan - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/putusanpengadilan/putusanpengadilan', $data);
		*/
	}

	public function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|is_unique[putusan_pengadilan.nomor]');
		$this->form_validation->set_rules('tahun_keputusan', 'Tahun Keputusan', 'trim|required|is_natural');
		$this->form_validation->set_rules('tahun_pajak', 'Tahun Pajak', 'trim|required|is_natural');
		$this->form_validation->set_rules('jenis_pajak', 'Jenis Pajak', 'trim|required');
        $this->form_validation->set_rules('isi_putusan', 'Isi Putusan', 'trim|required');
		/*$this->form_validation->set_rules('pokok_sengketa', 'Pokok Sengketa', 'trim|required');
		$this->form_validation->set_rules('menurut_terbanding', 'Menurut Terbanding', 'trim|required');
		$this->form_validation->set_rules('menurut_pemohon', 'Menurut Pemohon', 'trim|required');
		$this->form_validation->set_rules('menurut_majelis', 'Menurut Majelis', 'trim|required');
		$this->form_validation->set_rules('memperhatikan', 'Memperhatikan', 'trim|required');
		$this->form_validation->set_rules('mengingat', 'Mengingat', 'trim|required');
		$this->form_validation->set_rules('memutuskan', 'Memutuskan', 'trim|required');*/

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$this->template->set('title', 'Putusan Pengadilan - Add - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/putusanpengadilan/putusanpengadilan-add');
        }
        else
        {
         	$nomor = $this->input->post('nomor');
         	$tahun_keputusan = $this->input->post('tahun_keputusan');
         	$tahun_pajak = $this->input->post('tahun_pajak');
         	$jenis_pajak = $this->input->post('jenis_pajak');

            $isi_putusan = $this->input->post('isi_putusan', FALSE);

         	/*$pokok_sengketa = $this->input->post('pokok_sengketa', FALSE);
         	$menurut_terbanding = $this->input->post('menurut_terbanding', FALSE);
         	$menurut_pemohon = $this->input->post('menurut_pemohon', FALSE);
         	$menurut_majelis = $this->input->post('menurut_majelis', FALSE);
         	$memperhatikan = $this->input->post('memperhatikan', FALSE);
         	$mengingat = $this->input->post('mengingat', FALSE);
         	$memutuskan = $this->input->post('memutuskan', FALSE);*/

         	$permalink = str_replace('/', ' ',$nomor);
            $permalink = str_replace('.', ' ',$nomor);
            $permalink = url_title($permalink, '-', TRUE);

         	$data = array(
         			'name'					=> $nomor,
         			'permalink'				=> $permalink,
         			'nomor'					=> $nomor,
         			'tahun_keputusan'		=> $tahun_keputusan,
         			'tahun_pajak'			=> $tahun_pajak,
                    'jenis_pajak'           => $jenis_pajak,
         			'isi_putusan'			=> $isi_putusan,
         			/*'pokok_sengketa'		=> $pokok_sengketa,
         			'menurut_terbanding'	=> $menurut_terbanding,
         			'menurut_pemohon'		=> $menurut_pemohon,
         			'menurut_majelis'		=> $menurut_majelis,
         			'memperhatikan'			=> $memperhatikan,
         			'mengingat'				=> $mengingat,
         			'memutuskan'			=> $memutuskan,*/
         			'status'			=> 0
         		);

         	$insert = $this->putusan_pengadilan_model->insert($data);

            $pp_id = $this->db->insert_id();

         	if($insert)
         	{
         		redirect('webcontrol/putusanpengadilan/edit/'.$pp_id);
         	}
         	else
         	{
         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

         		$this->template->set('title', 'Putusan Pengadilan - Add - '.$this->config->item('web_title'));
				$this->template->load('webcontrol/template/template-form', 'webcontrol/putusanpengadilan/putusanpengadilan-add');
         	}
        }
	}

	public function edit($pp_id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required');
        $this->form_validation->set_rules('tahun_keputusan', 'Tahun Keputusan', 'trim|required|is_natural');
        $this->form_validation->set_rules('tahun_pajak', 'Tahun Pajak', 'trim|required|is_natural');
        $this->form_validation->set_rules('jenis_pajak', 'Jenis Pajak', 'trim|required');
        $this->form_validation->set_rules('isi_putusan', 'Isi Putusan', 'trim|required');
        /*$this->form_validation->set_rules('pokok_sengketa', 'Pokok Sengketa', 'trim|required');
        $this->form_validation->set_rules('menurut_terbanding', 'Menurut Terbanding', 'trim|required');
        $this->form_validation->set_rules('menurut_pemohon', 'Menurut Pemohon', 'trim|required');
        $this->form_validation->set_rules('menurut_majelis', 'Menurut Majelis', 'trim|required');
        $this->form_validation->set_rules('memperhatikan', 'Memperhatikan', 'trim|required');
        $this->form_validation->set_rules('mengingat', 'Mengingat', 'trim|required');
        $this->form_validation->set_rules('memutuskan', 'Memutuskan', 'trim|required');*/

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$data['pp'] = $this->putusan_pengadilan_model->get($pp_id);

        	$this->template->set('title', 'Putusan Pengadilan - Edit - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/putusanpengadilan/putusanpengadilan-edit', $data);
        }
        else
        {
         	$nomor = $this->input->post('nomor');
            $tahun_keputusan = $this->input->post('tahun_keputusan');
            $tahun_pajak = $this->input->post('tahun_pajak');
            $jenis_pajak = $this->input->post('jenis_pajak');

            $isi_putusan = $this->input->post('isi_putusan', FALSE);

            /*$pokok_sengketa = $this->input->post('pokok_sengketa', FALSE);
            $menurut_terbanding = $this->input->post('menurut_terbanding', FALSE);
            $menurut_pemohon = $this->input->post('menurut_pemohon', FALSE);
            $menurut_majelis = $this->input->post('menurut_majelis', FALSE);
            $memperhatikan = $this->input->post('memperhatikan', FALSE);
            $mengingat = $this->input->post('mengingat', FALSE);
            $memutuskan = $this->input->post('memutuskan', FALSE);*/

            $permalink = str_replace('/', ' ',$nomor);
            $permalink = str_replace('.', ' ',$nomor);
            $permalink = url_title($permalink, '-', TRUE);

         	$data = array(
                    'name'                  => $nomor,
                    'permalink'             => $permalink,
                    'nomor'                 => $nomor,
                    'tahun_keputusan'       => $tahun_keputusan,
                    'tahun_pajak'           => $tahun_pajak,
                    'jenis_pajak'           => $jenis_pajak,
                    'isi_putusan'           => $isi_putusan,
                    /*'pokok_sengketa'      => $pokok_sengketa,
                    'menurut_terbanding'    => $menurut_terbanding,
                    'menurut_pemohon'       => $menurut_pemohon,
                    'menurut_majelis'       => $menurut_majelis,
                    'memperhatikan'         => $memperhatikan,
                    'mengingat'             => $mengingat,
                    'memutuskan'            => $memutuskan,*/
                );

         	$update = $this->putusan_pengadilan_model->update($pp_id, $data);

         	if($update)
         	{
         		redirect('webcontrol/putusanpengadilan/edit/'.$pp_id);
         	}
         	else
         	{
         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot update data to database.</p>');

         		$data['pp'] = $this->putusan_pengadilan_model->get($pp_id);

         		$this->template->set('title', 'Putusan Pengadilan - Edit - '.$this->config->item('web_title'));
				$this->template->load('webcontrol/template/template-form', 'webcontrol/putusanpengadilan/putusanpengadilan-edit', $data);
         	}
        }
	}

	public function view($pp_id)
	{
		$data['pp'] = $this->putusan_pengadilan_model->get($pp_id);

 		$this->template->set('title', 'Putusan Pengadilan - View - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/putusanpengadilan/putusanpengadilan-view', $data);
	}

	public function semua($pp_id)
	{
		if(empty($this->uri->segment(4))) $page = 1;
        else $page = $this->uri->segment(4);
		
		$show = $this->input->get('show', TRUE);
		if(empty($show)) $show = $this->config->item('perpage');
		
		if($this->input->get('search', TRUE)) {
			$data['pp'] = $this->putusan_pengadilan_model->get_all_search_perpage($page,$show,$this->input->get('search', TRUE));
			$counter = $this->putusan_pengadilan_model->countallsearch($this->input->get('search', TRUE));
		} else {
			$data['pp'] = $this->putusan_pengadilan_model->get_all_perpage($page,$show);
			$counter = $this->putusan_pengadilan_model->countall();
		}
		
		/*Pagination*/
        $config['base_url'] = site_url('webcontrol/putusanpengadilan/semua');
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

 		$this->template->set('title', 'Putusan Pengadilan - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/putusanpengadilan/putusanpengadilan-semua', $data);
	}

	public function publish($pp_id)
	{
		$data = array('status' => 1);

		$update = $this->putusan_pengadilan_model->update($pp_id, $data);

		if($update)
		{
			redirect('webcontrol/putusanpengadilan');
		}
		else
		{
			redirect('webcontrol/putusanpengadilan');
		}
	}

	public function unpublish($pp_id)
	{
		$data = array('status' => 0);

		$update = $this->putusan_pengadilan_model->update($pp_id, $data);

		if($update)
		{
			redirect('webcontrol/putusanpengadilan');
		}
		else
		{
			redirect('webcontrol/putusanpengadilan');
		}
	}

	public function delete($pp_id)
	{
		$delete = $this->putusan_pengadilan_model->delete($pp_id);

		if($delete)
		{
			redirect('webcontrol/putusanpengadilan');
		}
		else
		{
			redirect('webcontrol/putusanpengadilan');
		}
	}
}
