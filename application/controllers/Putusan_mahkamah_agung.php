
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_mahkamah_agung extends My_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('putusan_ma_model');
    	$this->load->model('favourite_model');

    	$this->load->library('facebook');
    	$this->load->library('pagination');

    	$this->load->helper('peraturan_pajak_helper');
    	$this->load->helper('text');
	}

	public function testurl()
	{
		$nomor = 'Put-30952/PP/M.XIV/19/2011';
		$nomor = str_replace("/"," ",$nomor);
		$nomor = str_replace("."," ",$nomor);

		echo url_title($nomor, '-', TRUE);
	}

	public function index()
	{
		//------

		if(isset($_GET['sort']))
		{
			$search_sort = $_GET['sort'];
		}
		else
		{
			$search_sort = 'tahun';
		}

		if(isset($_GET['order']))
		{
			$search_order = $_GET['order'];
		}
		else
		{
			$search_order = 'desc';
		}

		if($search_order == 'desc') $corder = 'asc';
		if($search_order == 'asc' || $search_order == '') $corder = 'desc';

		$url_year = current_url().'?sort=tahun&order='.$corder;
		$url_number = current_url().'?sort=nomor&order='.$corder;

		$data['url_year'] = $url_year;
		$data['url_number'] = $url_number;

		//------

		if(empty($this->uri->segment(3))) $page = 1;
        else $page = $this->uri->segment(3);

		$data['result'] = $this->putusan_ma_model->get_all_publish_perpage($page, $this->config->item('perpage'), $search_sort, $search_order);

		$data['tahun_ma'] = $this->putusan_ma_model->get_tahun_ma();
		$data['count'] = $this->putusan_ma_model->count();
		$data['ma_number'] = "";
		$data['ma_key'] = "";
        $data['latest_ma'] = $this->putusan_ma_model->get_latest_ma();

		/*Pagination*/

        $config['base_url'] = site_url('putusan-mahkamah-agung/index');
        $config['suffix'] = '?sort='.$search_sort.'&order='.$search_order;
		$config['total_rows'] =  $this->putusan_ma_model->count();
		$config['per_page'] = $this->config->item('perpage');

		$config['use_page_numbers'] = true;
		$config['num_links'] = 3;

		$config['full_tag_open'] = '<ul class="pagination">';
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

		$this->template->set('container_class', 'search-page');

		$this->template->set('title', 'Putusan Mahkamah Agung - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/ma/ma', $data);
	}

	public function get_social()
	{
		$id = $this->input->post('id');

		$data = $this->putusan_ma_model->get($id);

		$url = site_url('putusan-mahkamah-agung/read/'.$data['ma_url']);

		$html ='<a href="https://www.facebook.com/sharer/sharer.php?u='.$url.'" target="_blank" id="share-facebook"><span class="socicon socicon-facebook"></a>
				<a href="https://twitter.com/intent/tweet?url='.$url.'" target="_blank" id="share-twitter"><span class="socicon socicon-twitter"></a>
				<a href="https://www.linkedin.com/shareArticle?url='.$url.'" target="_blank" id="share-linkedin"><span class="socicon socicon-linkedin"></a>
				<a href="https://plus.google.com/share?url='.$url.'" target="_blank" id="share-googleplus"><span class="socicon socicon-googleplus"></a>
				<a href="http://line.me/R/msg/text/?'.$url.'" target="_blank" id="share-line"><span class="socicon socicon-line"></a>
				<a href="whatsapp://send?text='.$url.'" target="_blank" id="share-whatsapp"><span class="socicon socicon-whatsapp"></a>';

		echo $html;
	}	

	public function read($url)
	{
		$result = $this->putusan_ma_model->get_publish_by('ma_url', $url);

		$data['result'] = $result;

		$data['tahun_ma'] = $this->putusan_ma_model->get_tahun_ma();
		$data['count'] = $this->putusan_ma_model->count();
		$data['ma_number'] = "";
		$data['ma_key'] = "";
        $data['latest_ma'] = $this->putusan_ma_model->get_latest_ma();

        $title = 'Putusan Mahkamah Agung Nomor: '.$result['ma_number'].' - Putusan Mahkamah Agung - '.$this->config->item('web_title');
		$description = substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($result['ma_content']))), 0, 255);

		$keywords = 'Putusan Mahkamah Agung '.$result['ma_number'];
		$keywords = str_replace(" ", ", ", strtolower($keywords));

		$data['meta'] =  '<meta name="description" content="'.$description.'">
						  <meta name="keywords" content="ddtc, taxengine, '.$keywords.'">
						  <meta name="author" content="TAX ENGINE">

						  <!-- facebook -->
						  <meta property="og:url"           content="'.current_url().'" />
						  <meta property="og:type"          content="website" />
						  <meta property="og:title"         content="'.$title.'" />
						  <meta property="og:description"   content="'.$description.'" />
						  <meta property="og:image"         content="'.site_url('assets/cover.jpg').'" />

						  <!-- twitter -->
						  <meta name="twitter:card" content="summary">
						  <meta name="twitter:url" content="'.current_url().'">
						  <meta name="twitter:title" content="'.$title.'">
						  <meta name="twitter:description" content="'.$description.'">
						  <meta name="twitter:image" content="'.site_url('assets/cover.jpg').'">';

        $data['javascript'] = 	"<script>
							      $(document).ready(function(){
							        $('.modalcaller-ma#".$result['ma_id']."').trigger( 'click', [ '".$result['ma_id']."' ]  );

							        return false;
							      });
							    </script>";

		$this->template->set('container_class', 'search-page');

		$this->template->set('title', 'Putusan Mahkamah Agung Nomor: '.$result['ma_number'].' - Putusan Mahkamah Agung - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/ma/ma-read', $data);
	}

	public function do_search()
	{
		if(!$this->config->item('search_putusan_ma_login'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('search_key', 'Kata Kunci', 'trim');
			$this->form_validation->set_rules('search_number', 'Nomor', 'trim|is_natural');
			$this->form_validation->set_rules('search_tahun', 'Tahun', 'trim');
			$this->form_validation->set_rules('search_method', 'Metode', 'trim');

			$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');

			if($this->form_validation->run() == FALSE)
			{
				echo json_encode(
							array(
								'st' => 0, 'msg' => validation_errors()
								)
							);
			}
			else
			{
				$search_number = $this->input->post('search_number');
				$search_key = $this->input->post('search_key');
				
				$search_tahun = $this->input->post('search_tahun');
				$search_tahun_array = $this->input->post('search_tahun_array');
				if(!empty($search_tahun_array))
				{
					$search_tahun = implode('_', $search_tahun_array);
				}

				$search_method = $this->input->post('search_method');

				if($search_tahun == 'all' || $search_tahun == '') $search_tahun = '0000';
				if($search_number == '') $search_number = '0';
				if($search_key == '') $search_key = 'semua';

				$key_url = url_title($search_key, '_', TRUE);

				$search_url = site_url().'putusan-mahkamah-agung/search/'.$key_url.'/'.$search_number.'/'.$search_tahun.'/'.$search_method;

				//if(!$search_key || trim($search_key) == "") redirect('putusan-mahkamah-agung');
				//else redirect($search_url);

				echo json_encode(
							array(
									'st' => 1, 
									'msg' => '<p class="help-block message-success-alt-1">Mengarahkan...</p>',
									'url' => $search_url
								)
							);
			}
		}	
		else
		{
			if($this->user_auth->is_logged_in())
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('search_key', 'Kata Kunci', 'trim');
				$this->form_validation->set_rules('search_number', 'Nomor', 'trim|is_natural');
				$this->form_validation->set_rules('search_tahun', 'Tahun', 'trim');
				$this->form_validation->set_rules('search_method', 'Metode', 'trim');

				$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');

				if($this->form_validation->run() == FALSE)
				{
					echo json_encode(
								array(
									'st' => 0, 'msg' => validation_errors()
									)
								);
				}
				else
				{
					$search_number = $this->input->post('search_number');
					$search_key = $this->input->post('search_key');
					
					$search_tahun = $this->input->post('search_tahun');
					$search_tahun_array = $this->input->post('search_tahun_array');
					if(!empty($search_tahun_array))
					{
						$search_tahun = implode('_', $search_tahun_array);
					}

					$search_method = $this->input->post('search_method');

					if($search_tahun == 'all' || $search_tahun == '') $search_tahun = '0000';
					if($search_number == '') $search_number = '0';
					if($search_key == '') $search_key = 'semua';

					$key_url = url_title($search_key, '_', TRUE);

					$search_url = site_url().'putusan-mahkamah-agung/search/'.$key_url.'/'.$search_number.'/'.$search_tahun.'/'.$search_method;

					//if(!$search_key || trim($search_key) == "") redirect('putusan-mahkamah-agung');
					//else redirect($search_url);

					echo json_encode(
								array(
										'st' => 1, 
										'msg' => '<p class="help-block message-success-alt-1">Mengarahkan...</p>',
										'url' => $search_url,
										'tahun1' => $search_tahun_cek
									)
								);
				}
			}
			else
			{
				echo json_encode(
								array(
										'st' => 2
									)
								);
			}
		}
	}

	public function search()
	{
		//------

		if(isset($_GET['sort']))
		{
			$search_sort = $_GET['sort'];
		}
		else
		{
			$search_sort = 'tahun';
		}

		if(isset($_GET['order']))
		{
			$search_order = $_GET['order'];
		}
		else
		{
			$search_order = 'desc';
		}

		if($search_order == 'desc') $corder = 'asc';
		if($search_order == 'asc' || $search_order == '') $corder = 'desc';

		$url_year = current_url().'?sort=tahun&order='.$corder;
		$url_number = current_url().'?sort=nomor&order='.$corder;

		$data['url_year'] = $url_year;
		$data['url_number'] = $url_number;

		//------

		$search_key = $this->uri->segment(3);
		$search_number = $this->uri->segment(4);
		$search_tahun = $this->uri->segment(5);
		if(strpos($search_tahun, '_') !== false) {
			$search_tahun = explode('_', $search_tahun);
		}
		$search_method = $this->uri->segment(6);

		$terms = str_replace("_", " ", $search_key);

		if(empty($this->uri->segment(7))) $page = 1;
        else $page = $this->uri->segment(7);

		$data['result'] = $this->putusan_ma_model->get_search_result_perpage($terms, $search_number, $search_tahun, $search_method, $search_sort, $search_order, $page, $this->config->item('perpage'));
		$data['tahun_ma'] = $this->putusan_ma_model->get_tahun_ma();
		$data['count'] = count($this->putusan_ma_model->get_search_result($terms, $search_number, $search_tahun, $search_method, $search_sort, $search_order));

		$ma_number = $this->uri->segment(4);
		if($ma_number == '0') $ma_number = "";
        $data['ma_number'] = $ma_number;

		$ma_key = $this->uri->segment(3);
        $ma_key = str_replace("_", " ", $ma_key);
        if($ma_key == 'semua') $ma_key = "";
        $data['ma_key'] = $ma_key;
        $data['latest_ma'] = $this->putusan_ma_model->get_latest_ma();

        /*Pagination*/
        $config['base_url'] = site_url('putusan-mahkamah-agung/search/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
        $config['suffix'] = '?sort='.$search_sort.'&order='.$search_order;
        $config['total_rows'] = count($this->putusan_ma_model->get_search_result($terms, $search_number, $search_tahun, $search_method, $search_sort, $search_order));
		$config['per_page'] = $this->config->item('perpage');

		$config['use_page_numbers'] = true;
		$config['num_links'] = 3;

		$config['full_tag_open'] = '<ul class="pagination">';
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

		$this->template->set('container_class', 'search-page');

		$this->template->set('title', 'Putusan Mahkamah Agung - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/ma/ma', $data);
	}

	public function get_single_content()
	{
		if($this->config->item('putusan_ma_login') && !$this->user_auth->is_logged_in())
		{
			$ma_id = $this->input->post('ma_id');

			//content
			$ma_full = $this->get_document($ma_id);

			//favourite
			$favourite = $this->get_favourite($ma_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> '<div class="nologin-readmore"><a href="" id="readmore-login">READ MORE</a></div>'.$ma_full,
								'favourite' 	=> $favourite
							)
						);
		}
		else
		{
			// echo json_encode(
			// 			array(
			// 					'st' 			=> 0
			// 				)
			// 			);

			$ma_id = $this->input->post('ma_id');

			//content
			$ma_full = $this->get_document($ma_id);

			//favourite
			$favourite = $this->get_favourite($ma_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> $ma_full,
								'favourite' 	=> $favourite
							)
						);
		}
	}

	public function get_double_content()
	{
		if($this->user_auth->is_logged_in())
		{
			$ma_id1 = $this->input->post('ma_id1');
			$ma_id2 = $this->input->post('ma_id2');

			$ma_full_left = $this->get_document($ma_id1);
			$ma_full_right = $this->get_document($ma_id2);

			echo json_encode(
						array(
								'st' 				=> 1,
								'full_content_left' => $ma_full_left,
								'full_content_right'=> $ma_full_right
							)
						);
		}
		else
		{
			echo json_encode(
						array(
								'st' 			=> 0
							)
						);
		}
	}

	private function get_document($ma_id)
	{
		$ma = $this->putusan_ma_model->get($ma_id);
		$ma_view = $ma['ma_view'];

		$ma_view_new = (int)$ma_view+1;

		$data = array('ma_view' => $ma_view_new);
		$this->putusan_ma_model->update($ma_id, $data);

		//-----------------------------

		$ma_full = $ma['ma_content'].'<div class="footerdoc"><img src="'.site_url().'assets/themes/images/newdocfooter.png"></div>';


		//-----------------------------

		return $ma_full;
	}

	private function get_favourite($favourite_document_id)
	{
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 4, $favourite_document_id);

		if($check == 0)
		{
			return '0';
		}
		else
		{
			return '1';
		}
	}

	public function create_cookie_sanding()
	{
		$ma_id = $this->input->post('doc_1');

		$ma = $this->putusan_ma_model->get($ma_id);

		set_cookie('cookie_ma', 'yes', 3600);
		set_cookie('cookie_ma_id', $ma_id, 3600);
		set_cookie('cookie_ma_text', 'Putusan Mahkamah Agung Nomor: '.$ma['ma_number'], 3600);
	}

	public function delete_cookie_sanding()
	{
		delete_cookie('cookie_ma');
		delete_cookie('cookie_ma_id');
		delete_cookie('cookie_ma_text');
	}

	public function sanding()
	{
		$id = $this->input->post('id');
		$ma = $this->putusan_ma_model->get($id);

		echo 'Putusan Mahkamah Agung Nomor: '.$ma['ma_number'];
	}

	public function favourite()
	{
		$favourite_document_id = $this->input->post('id');
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 4, $favourite_document_id);

		if($check == 0)
		{
			$data = array(
					'favourite_user' => $favourite_user,
					'favourite_type' => 4,
					'favourite_document_id' => $favourite_document_id,
				);
			$insert = $this->favourite_model->insert($data);

			if($insert)
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		}
		else
		{
			$favourite = $this->favourite_model->get_favourite($favourite_user, 4, $favourite_document_id);

			$favourite_id = $favourite['favourite_id'];

			$delete = $this->favourite_model->delete($favourite_id);

			if($delete)
			{
				echo '2';
			}
			else
			{
				echo '0';
			}
		}
	}
}