<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peraturanpajak extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('regulasi_pajak_model');
    	$this->load->model('kelompok_model');
    	$this->load->model('master_listjenis_model');
    	$this->load->model('topik_model');
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
		redirect('webcontrol/peraturanpajak/semua');
		/*
		$data['pj'] = $this->regulasi_pajak_model->get_field('id, jenis_dokumen_lengkap, nomordokumen, publish, submit_date');

		$this->template->set('title', 'Peraturan Pajak - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/peraturanpajak/peraturanpajak', $data);
		*/
	}

    public function check_select($value)
    {
        if ($value == '0')
        {
            $this->form_validation->set_message('check_select', 'Please choose %s.');

            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

	public function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nomordokumen', 'Nomor Dokumen', 'trim|required|is_unique[regulasi_pajak.nomordokumen]');
        $this->form_validation->set_rules('kelompok', 'Kelompok', 'trim|required|callback_check_select');
		$this->form_validation->set_rules('jenisdok2', 'Jenis Dokument', 'trim|required|callback_check_select');
        $this->form_validation->set_rules('jenis_dokumen_lengkap', 'Jenis Dokumen Lengkap', 'trim|required');
        $this->form_validation->set_rules('nomor', 'Jenis Dokumen Lengkap', 'trim|required|numeric');
        $this->form_validation->set_rules('tahun', 'Jenis Dokumen Lengkap', 'trim|required|numeric');
        $this->form_validation->set_rules('tanggal', 'Jenis Dokumen Lengkap', 'trim|required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');
        $this->form_validation->set_rules('body_final', 'Body Final', 'trim|required');
        $this->form_validation->set_rules('lamp1_filename', 'Body Final', 'trim');
        $this->form_validation->set_rules('topik', 'Topik', 'trim|required|callback_check_select');
        $this->form_validation->set_rules('regstatus', 'RegStatus', 'trim');
        $this->form_validation->set_rules('view', 'View', 'trim|numeric');
        $this->form_validation->set_rules('sync', 'Sync', 'trim');
        $this->form_validation->set_rules('id_tkb', 'ID_TKB', 'trim|numeric');
        $this->form_validation->set_rules('id_tr', 'ID_TR', 'trim|numeric');
        $this->form_validation->set_rules('id_bc', 'ID_BC', 'trim|numeric');
        $this->form_validation->set_rules('id_dj', 'ID_DJ', 'trim|numeric');
        $this->form_validation->set_rules('id_jdi', 'ID_JDI', 'trim|numeric');
        $this->form_validation->set_rules('id_o', 'ID_O', 'trim|numeric');
        $this->form_validation->set_rules('id_tf', 'ID_TF', 'trim|numeric');
        $this->form_validation->set_rules('publish', 'Publish', 'trim');
        $this->form_validation->set_rules('reviewed', 'Reviewed', 'trim');
        $this->form_validation->set_rules('linklist[]', 'Linklist', 'trim');
        $this->form_validation->set_rules('statuslist[]', 'Statuslist', 'trim');
        $this->form_validation->set_rules('historylist[]', 'Historylist', 'trim');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
            $data['error_lamp1_file'] = "";
            $data['error_file_pdf'] = "";

        	$data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
        	$data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
        	$data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
            $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
            $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
            $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

        	$this->template->set('title', 'Peraturan Pajak - Add - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-add', $data);
        }
        else
        {
            $lamp1_file = "";
            $data['error_lamp1_file'] = "";
            $upload_lamp1_file = TRUE;
            if(!empty($_FILES['lamp1_file']['name']))
            {
                $config['upload_path']          = './assets/download/peraturanpajak/file/';
                //$config['upload_path']          = './assets/download/peraturanpajak/lampiran/';
                $config['allowed_types']        = 'doc|docx|pdf';
                $config['max_size']             = 2048;

                $new_name = time().'_'.$_FILES["lamp1_file"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('lamp1_file'))
                {
                    $data['error_lamp1_file'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $upload_lamp1_file = FALSE;
                }
                else
                {
                    $lamp1_file = $this->upload->data('file_name');

                    $upload_lamp1_file = TRUE;
                }
            }

            $file_pdf = "";
            $data['error_file_pdf'] = "";
            $upload_file_pdf = TRUE;
            if(!empty($_FILES['file_pdf']['name']))
            {
                $config['upload_path']          = './assets/download/peraturanpajak/file/';
                $config['allowed_types']        = 'pdf';
                $config['max_size']             = 10240;

                $new_name = time().'_'.$_FILES["file_pdf"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('file_pdf'))
                {
                    $data['error_file_pdf'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $upload_file_pdf = FALSE;
                }
                else
                {
                    $file_pdf = $this->upload->data('file_name');

                    $upload_file_pdf = TRUE;
                }
            }

            if($upload_lamp1_file && $upload_file_pdf)
            {
             	$nomordokumen = $this->input->post('nomordokumen');
                $kelompok = $this->input->post('kelompok');
                $jenisdok2 = $this->input->post('jenisdok2');
                $jenis_dokumen_lengkap = $this->input->post('jenis_dokumen_lengkap');
                $nomor = $this->input->post('nomor');
                $tahun = $this->input->post('tahun');
                $tanggal = $this->input->post('tanggal');
                $perihal = $this->input->post('perihal');
                $body_final = $this->input->post('body_final', FALSE);
                $lamp1_filename = $this->input->post('lamp1_filename');
                $topik = $this->input->post('topik');
                $regstatus = $this->input->post('regstatus');
                $view = $this->input->post('view');
                $sync = $this->input->post('sync');
                $id_tkb = $this->input->post('id_tkb');
                $id_tr = $this->input->post('id_tr');
                $id_bc = $this->input->post('id_bc');
                $id_dj = $this->input->post('id_dj');
                $id_jdi = $this->input->post('id_jdi');
                $id_o = $this->input->post('id_o');
                $id_tf = $this->input->post('id_tf');
                $publish = $this->input->post('publish');
                $reviewed = $this->input->post('reviewed');
                $linklist = implode(";", $this->input->post('linklist'));
                $statuslist = implode(";", $this->input->post('statuslist'));
                $historylist = implode(";", $this->input->post('historylist'));

                $permalink = str_replace('/', ' ',$nomordokumen);
                $permalink = str_replace('.', ' ',$nomordokumen);
                $permalink = $jenis_dokumen_lengkap.' '.$permalink;
                $permalink = url_title($permalink, '-', TRUE);

             	$data = array(
                        'kelompok'                  => $kelompok,
                        'jenisdok2'                 => $jenisdok2,
                        'jenis_dokumen_lengkap'     => $jenis_dokumen_lengkap,
                        'nomordokumen'              => $nomordokumen,
                        'permalink'                 => $permalink,
                        'nomor'                     => $nomor,
                        'tahun'                     => $tahun,
                        'tanggal'                   => $tanggal,
                        'perihal'                   => $perihal,
                        'body_final'                => $body_final,
                        'lamp1_filename'            => $lamp1_filename,
                        'lamp1_file'                => $lamp1_file,
                        'file_pdf'                  => $file_pdf,
                        'topik'                     => $topik,
                        'regstatus'                 => $regstatus,
                        'view'                      => $view,
                        'sync'                      => $sync,
                        'id_tkb'                    => $id_tkb,
                        'id_tr'                     => $id_tr,
                        'id_bc'                     => $id_bc,
                        'id_dj'                     => $id_dj,
                        'id_jdi'                    => $id_jdi,
                        'id_o'                      => $id_o,
                        'id_tf'                     => $id_tf,
                        'publish'                   => $publish,
                        'reviewed'                  => $reviewed,
                        'linklist'                  => $linklist,
                        'statuslist'                => $statuslist,
                        'historylist'               => $historylist,
             		);

             	$insert = $this->regulasi_pajak_model->insert($data);

                $id = $this->db->insert_id();

             	if($insert)
             	{
             		redirect('webcontrol/peraturanpajak/edit/'.$id);
             	}
             	else
             	{
                    $data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
                    $data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
                    $data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
                    $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                    $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                    $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

             		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

             		$this->template->set('title', 'Peraturan Pajak - Add - '.$this->config->item('web_title'));
                    $this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-add', $data);
             	}
            }
            else
            {
                $data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
                $data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
                $data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
                $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

                $this->template->set('title', 'Peraturan Pajak - Add - '.$this->config->item('web_title'));
                $this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-add', $data);
            }
        }
	}

	public function edit($id)
	{
		$this->load->library('form_validation');

        $this->form_validation->set_rules('nomordokumen', 'Nomor Dokumen', 'trim|required');
        $this->form_validation->set_rules('kelompok', 'Kelompok', 'trim|required|callback_check_select');
        $this->form_validation->set_rules('jenisdok2', 'Jenis Dokument', 'trim|required|callback_check_select');
        $this->form_validation->set_rules('jenis_dokumen_lengkap', 'Jenis Dokumen Lengkap', 'trim|required');
        $this->form_validation->set_rules('nomor', 'Jenis Dokumen Lengkap', 'trim|required|numeric');
        $this->form_validation->set_rules('tahun', 'Jenis Dokumen Lengkap', 'trim|required|numeric');
        $this->form_validation->set_rules('tanggal', 'Jenis Dokumen Lengkap', 'trim|required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');
        $this->form_validation->set_rules('body_final', 'Body Final', 'trim|required');
        $this->form_validation->set_rules('lamp1_filename', 'Body Final', 'trim');
        $this->form_validation->set_rules('topik', 'Topik', 'trim|required|callback_check_select');
        $this->form_validation->set_rules('regstatus', 'RegStatus', 'trim');
        $this->form_validation->set_rules('view', 'View', 'trim|numeric');
        $this->form_validation->set_rules('sync', 'Sync', 'trim');
        $this->form_validation->set_rules('id_tkb', 'ID_TKB', 'trim|numeric');
        $this->form_validation->set_rules('id_tr', 'ID_TR', 'trim|numeric');
        $this->form_validation->set_rules('id_bc', 'ID_BC', 'trim|numeric');
        $this->form_validation->set_rules('id_dj', 'ID_DJ', 'trim|numeric');
        $this->form_validation->set_rules('id_jdi', 'ID_JDI', 'trim|numeric');
        $this->form_validation->set_rules('id_o', 'ID_O', 'trim|numeric');
        $this->form_validation->set_rules('id_tf', 'ID_TF', 'trim|numeric');
        $this->form_validation->set_rules('publish', 'Publish', 'trim');
        $this->form_validation->set_rules('reviewed', 'Reviewed', 'trim');
        $this->form_validation->set_rules('linklist[]', 'Linklist', 'trim');
        $this->form_validation->set_rules('statuslist[]', 'Statuslist', 'trim');
        $this->form_validation->set_rules('historylist[]', 'Historylist', 'trim');

        $this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

        if($this->form_validation->run() == FALSE)
        {
            $data['pj'] = $this->regulasi_pajak_model->get($id);

            $data['error_lamp1_file'] = "";
            $data['error_file_pdf'] = "";

            $data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
            $data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
            $data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
            $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
            $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
            $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

            $this->template->set('title', 'Peraturan Pajak - Edit - '.$this->config->item('web_title'));
            $this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-edit', $data);
        }
        else
        {
            $lamp1_file = "";
            $data['error_lamp1_file'] = "";
            $upload_lamp1_file = TRUE;
            if(!empty($_FILES['lamp1_file']['name']))
            {
                //$config['upload_path']          = './assets/download/peraturanpajak/lampiran/';
                $config['upload_path']          = './assets/download/peraturanpajak/file/';
                $config['allowed_types']        = 'doc|docx|pdf';
                $config['max_size']             = 10240;

                $new_name = time().'_'.$_FILES["lamp1_file"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('lamp1_file'))
                {
                    $data['error_lamp1_file'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $upload_lamp1_file = FALSE;
                }
                else
                {
                    $lamp1_file = $this->upload->data('file_name');

                    $upload_lamp1_file = TRUE;
                }
            }

            $file_pdf = "";
            $data['error_file_pdf'] = "";
            $upload_file_pdf = TRUE;
            if(!empty($_FILES['file_pdf']['name']))
            {
                $config['upload_path']          = './assets/download/peraturanpajak/file/';
                $config['allowed_types']        = 'pdf';
                $config['max_size']             = 10240;

                $new_name = time().'_'.$_FILES["file_pdf"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('file_pdf'))
                {
                    $data['error_file_pdf'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $upload_file_pdf = FALSE;
                }
                else
                {
                    $file_pdf = $this->upload->data('file_name');

                    $upload_file_pdf = TRUE;
                }
            }

            if($upload_lamp1_file && $upload_file_pdf)
            {
                $nomordokumen = $this->input->post('nomordokumen');
                $kelompok = $this->input->post('kelompok');
                $jenisdok2 = $this->input->post('jenisdok2');
                $jenis_dokumen_lengkap = $this->input->post('jenis_dokumen_lengkap');
                $nomor = $this->input->post('nomor');
                $tahun = $this->input->post('tahun');
                $tanggal = $this->input->post('tanggal');
                $perihal = $this->input->post('perihal');
                $body_final = $this->input->post('body_final', FALSE);
                $lamp1_filename = $this->input->post('lamp1_filename');
                $topik = $this->input->post('topik');
                $regstatus = $this->input->post('regstatus');
                $view = $this->input->post('view');
                $sync = $this->input->post('sync');
                $id_tkb = $this->input->post('id_tkb');
                $id_tr = $this->input->post('id_tr');
                $id_bc = $this->input->post('id_bc');
                $id_dj = $this->input->post('id_dj');
                $id_jdi = $this->input->post('id_jdi');
                $id_o = $this->input->post('id_o');
                $id_tf = $this->input->post('id_tf');
                $publish = $this->input->post('publish');
                $reviewed = $this->input->post('reviewed');
                $linklist = implode(";", $this->input->post('linklist'));
                $statuslist = implode(";", $this->input->post('statuslist'));
                $historylist = implode(";", $this->input->post('historylist'));

                $permalink = str_replace('/', ' ',$nomordokumen);
                $permalink = str_replace('.', ' ',$nomordokumen);
                $permalink = $jenis_dokumen_lengkap.' '.$permalink;
                $permalink = url_title($permalink, '-', TRUE);

                if($lamp1_file !== "" && $file_pdf !== "")
                {
                    $data = array(
                        'kelompok'                  => $kelompok,
                        'jenisdok2'                 => $jenisdok2,
                        'jenis_dokumen_lengkap'     => $jenis_dokumen_lengkap,
                        'nomordokumen'              => $nomordokumen,
                        'permalink'                 => $permalink,
                        'nomor'                     => $nomor,
                        'tahun'                     => $tahun,
                        'tanggal'                   => $tanggal,
                        'perihal'                   => $perihal,
                        'body_final'                => $body_final,
                        'lamp1_filename'            => $lamp1_filename,
                        'lamp1_file'                => $lamp1_file,
                        'file_pdf'                  => $file_pdf,
                        'topik'                     => $topik,
                        'regstatus'                 => $regstatus,
                        'view'                      => $view,
                        'sync'                      => $sync,
                        'id_tkb'                    => $id_tkb,
                        'id_tr'                     => $id_tr,
                        'id_bc'                     => $id_bc,
                        'id_dj'                     => $id_dj,
                        'id_jdi'                    => $id_jdi,
                        'id_o'                      => $id_o,
                        'id_tf'                     => $id_tf,
                        'publish'                   => $publish,
                        'reviewed'                  => $reviewed,
                        'linklist'                  => $linklist,
                        'statuslist'                => $statuslist,
                        'historylist'               => $historylist,
                    );
                }

                if($lamp1_file === "" && $file_pdf === "")
                {
                    $data = array(
                        'kelompok'                  => $kelompok,
                        'jenisdok2'                 => $jenisdok2,
                        'jenis_dokumen_lengkap'     => $jenis_dokumen_lengkap,
                        'nomordokumen'              => $nomordokumen,
                        'permalink'                 => $permalink,
                        'nomor'                     => $nomor,
                        'tahun'                     => $tahun,
                        'tanggal'                   => $tanggal,
                        'perihal'                   => $perihal,
                        'body_final'                => $body_final,
                        'lamp1_filename'            => $lamp1_filename,
                        'topik'                     => $topik,
                        'regstatus'                 => $regstatus,
                        'view'                      => $view,
                        'sync'                      => $sync,
                        'id_tkb'                    => $id_tkb,
                        'id_tr'                     => $id_tr,
                        'id_bc'                     => $id_bc,
                        'id_dj'                     => $id_dj,
                        'id_jdi'                    => $id_jdi,
                        'id_o'                      => $id_o,
                        'id_tf'                     => $id_tf,
                        'publish'                   => $publish,
                        'reviewed'                  => $reviewed,
                        'linklist'                  => $linklist,
                        'statuslist'                => $statuslist,
                        'historylist'               => $historylist,
                    );
                }

                if($lamp1_file !== "" && $file_pdf === "")
                {
                    $data = array(
                        'kelompok'                  => $kelompok,
                        'jenisdok2'                 => $jenisdok2,
                        'jenis_dokumen_lengkap'     => $jenis_dokumen_lengkap,
                        'nomordokumen'              => $nomordokumen,
                        'permalink'                 => $permalink,
                        'nomor'                     => $nomor,
                        'tahun'                     => $tahun,
                        'tanggal'                   => $tanggal,
                        'perihal'                   => $perihal,
                        'body_final'                => $body_final,
                        'lamp1_filename'            => $lamp1_filename,
                        'lamp1_file'                => $lamp1_file,
                        'topik'                     => $topik,
                        'regstatus'                 => $regstatus,
                        'view'                      => $view,
                        'sync'                      => $sync,
                        'id_tkb'                    => $id_tkb,
                        'id_tr'                     => $id_tr,
                        'id_bc'                     => $id_bc,
                        'id_dj'                     => $id_dj,
                        'id_jdi'                    => $id_jdi,
                        'id_o'                      => $id_o,
                        'id_tf'                     => $id_tf,
                        'publish'                   => $publish,
                        'reviewed'                  => $reviewed,
                        'linklist'                  => $linklist,
                        'statuslist'                => $statuslist,
                        'historylist'               => $historylist,
                    );
                }

                if($lamp1_file === "" && $file_pdf !== "")
                {
                    $data = array(
                        'kelompok'                  => $kelompok,
                        'jenisdok2'                 => $jenisdok2,
                        'jenis_dokumen_lengkap'     => $jenis_dokumen_lengkap,
                        'nomordokumen'              => $nomordokumen,
                        'permalink'                 => $permalink,
                        'nomor'                     => $nomor,
                        'tahun'                     => $tahun,
                        'tanggal'                   => $tanggal,
                        'perihal'                   => $perihal,
                        'body_final'                => $body_final,
                        'lamp1_filename'            => $lamp1_filename,
                        'file_pdf'                  => $file_pdf,
                        'topik'                     => $topik,
                        'regstatus'                 => $regstatus,
                        'view'                      => $view,
                        'sync'                      => $sync,
                        'id_tkb'                    => $id_tkb,
                        'id_tr'                     => $id_tr,
                        'id_bc'                     => $id_bc,
                        'id_dj'                     => $id_dj,
                        'id_jdi'                    => $id_jdi,
                        'id_o'                      => $id_o,
                        'id_tf'                     => $id_tf,
                        'publish'                   => $publish,
                        'reviewed'                  => $reviewed,
                        'linklist'                  => $linklist,
                        'statuslist'                => $statuslist,
                        'historylist'               => $historylist,
                    );
                }

                $update = $this->regulasi_pajak_model->update($id, $data);

                if($update)
                {
                    redirect('webcontrol/peraturanpajak/edit/'.$id);
                }
                else
                {
                    $data['pj'] = $this->regulasi_pajak_model->get($id);

                    $data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
                    $data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
                    $data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
                    $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                    $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                    $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

                    $this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

                    $this->template->set('title', 'Peraturan Pajak - Edit 1 - '.$this->config->item('web_title'));
                    $this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-edit', $data);
                }
            }
            else
            {
                $data['pj'] = $this->regulasi_pajak_model->get($id);

                $data['kelompok'] = $this->kelompok_model->get_all_publish_order_by('idk', 'asc');
                $data['jenisdok'] = $this->master_listjenis_model->get_all_publish_order_by('IDJenis', 'asc', 'DokPajak');
                $data['topik'] = $this->topik_model->get_all_publish_order_by('topik_id', 'asc');
                $data['linklist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                $data['statuslist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');
                $data['historylist'] = $this->regulasi_pajak_model->get_field_publish('id, nomordokumen');

                $this->template->set('title', 'Peraturan Pajak - Edit 2 - '.$this->config->item('web_title'));
                $this->template->load('webcontrol/template/template-form', 'webcontrol/peraturanpajak/peraturanpajak-edit', $data);
            }
        }
	}

	public function view($id)
	{
		$data['pj'] = $this->regulasi_pajak_model->get($id);

 		$this->template->set('title', 'Peraturan Pajak - View - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/peraturanpajak/peraturanpajak-view', $data);
	}

	public function semua($id)
	{
		//$data['pj'] = $this->regulasi_pajak_model->get($id);
		
		if(empty($this->uri->segment(4))) $page = 1;
        else $page = $this->uri->segment(4);
		
		$show = $this->input->get('show', TRUE);
		if(empty($show)) $show = $this->config->item('perpage');
		
		if($this->input->get('search', TRUE)) {
			$data['pj'] = $this->regulasi_pajak_model->get_all_search_perpage($page,$show,$this->input->get('search', TRUE));
			$counter = $this->regulasi_pajak_model->countallsearch($this->input->get('search', TRUE));
		} else {
			$data['pj'] = $this->regulasi_pajak_model->get_all_perpage($page,$show);
			$counter = $this->regulasi_pajak_model->countall();
		}
		
		/*Pagination*/
        $config['base_url'] = site_url('webcontrol/peraturanpajak/semua');
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

 		$this->template->set('title', 'Peraturan Pajak - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/peraturanpajak/peraturanpajak-semua', $data);
	}

	public function publish($id)
	{
		$data = array('publish' => 1);

		$update = $this->regulasi_pajak_model->update($id, $data);

		if($update)
		{
			redirect('webcontrol/peraturanpajak');
		}
		else
		{
			redirect('webcontrol/peraturanpajak');
		}
	}

	public function unpublish($id)
	{
		$data = array('publish' => 0);

		$update = $this->regulasi_pajak_model->update($id, $data);

		if($update)
		{
			redirect('webcontrol/peraturanpajak');
		}
		else
		{
			redirect('webcontrol/peraturanpajak');
		}
	}

    public function delete($id)
    {
        $delete = $this->regulasi_pajak_model->delete($id);

        if($delete)
        {
            redirect('webcontrol/peraturanpajak');
        }
        else
        {
            redirect('webcontrol/peraturanpajak');
        }
    }

    public function delete_pdf($kind)
    {
        $id = $this->input->post('id');

        if($kind == "lamp1_file")
        {
            $data = array('lamp1_file' => '');
        }

        if($kind == "file_pdf")
        {
            $data = array('file_pdf' => '');
        }

        $update = $this->regulasi_pajak_model->update($id, $data);
    }
}
