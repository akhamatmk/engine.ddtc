<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_pengadilan_pajak extends My_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('putusan_pengadilan_model');
    	$this->load->model('favourite_model');

    	$this->load->library('facebook');
    	$this->load->library('pagination');

    	$this->load->helper('peraturan_pajak_helper');
    	$this->load->helper('text');
	}

	public function convert($page)
	{
		$perpage = 50;

		$pp = $this->putusan_pengadilan_model->get_all_perpage($page, $perpage);

		foreach($pp as $row)
		{
			$id = $row['id'];
			$jenis_pajak = $row['jenis_pajak'];
			$tahun_pajak = $row['tahun_pajak'];
			$pokok_sengketa = $row['pokok_sengketa'];
			$menurut_terbanding = $row['menurut_terbanding'];
			$menurut_pemohon = $row['menurut_pemohon'];
			$menurut_majelis = $row['menurut_majelis'];
			$memperhatikan = $row['memperhatikan'];
			$mengingat = $row['mengingat'];
			$memutuskan = $row['memutuskan'];

			$jenis_pajak = str_replace('&ltp&gt', '', $jenis_pajak);
			$jenis_pajak = str_replace('&lt/p&gt', '', $jenis_pajak);
			$jenis_pajak = trim($jenis_pajak);

			$tahun_pajak = str_replace('&ltp&gt', '', $tahun_pajak);
			$tahun_pajak = str_replace('&lt/p&gt', '', $tahun_pajak);
			$tahun_pajak = trim($tahun_pajak);

			$pokok_sengketa = str_replace('<p>&amp;nbsp;</p>', '-', $pokok_sengketa);
			$pokok_sengketa = trim($pokok_sengketa);

			$menurut_terbanding = str_replace('<p>&amp;nbsp;</p>', '-', $menurut_terbanding);
			$menurut_terbanding = trim($menurut_terbanding);

			$menurut_pemohon = str_replace('<p>&amp;nbsp;</p>', '-', $menurut_pemohon);
			$menurut_pemohon = trim($menurut_pemohon);

			$menurut_majelis = str_replace('<p>&amp;nbsp;</p>', '-', $menurut_majelis);
			$menurut_majelis = trim($menurut_majelis);

			$memperhatikan = str_replace('<p>&amp;nbsp;</p>', '-', $memperhatikan);
			$memperhatikan = trim($memperhatikan);

			$mengingat = str_replace('<p>&amp;nbsp;</p>', '-', $mengingat);
			$mengingat = trim($mengingat);

			$memutuskan = str_replace('<p>&amp;nbsp;</p>', '-', $memutuskan);
			$memutuskan = trim($memutuskan);

			$data = array(
					'jenis_pajak'	=> $jenis_pajak,
					'tahun_pajak'	=> $tahun_pajak,
					'pokok_sengketa'	=> $pokok_sengketa,
					'menurut_terbanding'	=> $menurut_terbanding,
					'menurut_pemohon'	=> $menurut_pemohon,
					'menurut_majelis'	=> $menurut_majelis,
					'memperhatikan'	=> $memperhatikan,
					'mengingat'	=> $mengingat,
					'memutuskan'	=> $memutuskan
				);

			$this->putusan_pengadilan_model->update($id, $data);
		}
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

		$data['result'] = $this->putusan_pengadilan_model->get_all_publish_perpage($page, $this->config->item('perpage'), $search_sort, $search_order);

		$data['jenis_pp'] = $this->putusan_pengadilan_model->get_jenis_pp();
		$data['tahun_pp'] = $this->putusan_pengadilan_model->get_tahun_pp();
		$data['latest_pp'] = $this->putusan_pengadilan_model->get_latest_pp();
		$data['count'] = $this->putusan_pengadilan_model->count();
		$data['pp_key'] = "";
		$data['pp_number'] = "";

		/*Pagination*/
        $config['base_url'] = site_url('putusan-pengadilan-pajak/index');
        $config['suffix'] = '?sort='.$search_sort.'&order='.$search_order;
		$config['total_rows'] =  $this->putusan_pengadilan_model->count();
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

		$this->template->set('title', 'Putusan Pengadilan Pajak - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/pp/pp', $data);
	}

	public function get_social()
	{
		$id = $this->input->post('id');

		$data = $this->putusan_pengadilan_model->get($id);

		$url = site_url('putusan-pengadilan-pajak/read/'.$data['permalink']);

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
		$result = $this->putusan_pengadilan_model->get_publish_by('permalink', $url);

		$data['jenis_pp'] = $this->putusan_pengadilan_model->get_jenis_pp();
		$data['tahun_pp'] = $this->putusan_pengadilan_model->get_tahun_pp();
		$data['pp_key'] = "";
		$data['pp_number'] = "";

		$data['result'] = $result;

		$title = 'Putusan Pengadilan Pajak Nomor : '.$result['name'].' - Putusan Pengadilan Pajak - '.$this->config->item('web_title');
		$description = substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($result['isi_putusan']))), 0, 255);

		$keywords = 'Putusan Pengadilan Pajak '.$result['name'];
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
							        $('.modalcaller-pp#".$result['id']."').trigger( 'click', [ '".$result['id']."' ]  );

							        return false;
							      });
							    </script>";

		$this->template->set('container_class', 'search-page');

		$this->template->set('title', 'Putusan Pengadilan Pajak Nomor : '.$result['name'].' - Putusan Pengadilan Pajak - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/pp/pp-read', $data);
	}

	public function do_search_()
	{
		$search_key = $this->input->post('search_key');
		$search_jenis_pp = $this->input->post('search_jenis_pp');
		$search_tahun = $this->input->post('search_tahun');
		$search_method = $this->input->post('search_method');

		$key_url = url_title($search_key, '_', TRUE);
		$jenis_pp_url = url_title($search_jenis_pp, '-', TRUE);

		if($search_tahun == 'all') $search_tahun = '0000';

		$search_url = site_url().'putusan-pengadilan-pajak/search/'.$key_url.'/'.$jenis_pp_url.'/'.$search_tahun.'/'.$search_method.'/tahun';

		if(!$search_key || trim($search_key) == "") redirect('putusan-pengadilan-pajak');
		else redirect($search_url);
	}

	public function do_search()
	{
		if(!$this->config->item('search_putusan_pengadilan_login'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('search_key', 'Kata Kunci', 'trim');
			$this->form_validation->set_rules('search_number', 'Nomor Putusan', 'trim');
			$this->form_validation->set_rules('search_jenis_pp', 'Jenis Putusan', 'trim');
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
				$search_key = $this->input->post('search_key');
				$search_number = $this->input->post('search_number');
				$search_jenis_pp = $this->input->post('search_jenis_pp');
				$search_jenis_pp_array = $this->input->post('search_jenis_pp_array');
				if(!empty($search_jenis_pp_array))
				{
					$search_jenis_pp = implode('_', $search_jenis_pp_array);
				}

				$search_tahun = $this->input->post('search_tahun');
				$search_tahun_array = $this->input->post('search_tahun_array');
				if(!empty($search_tahun_array))
				{
					$search_tahun = implode('_', $search_tahun_array);
				}

				$search_method = $this->input->post('search_method');

				if($search_key == '') $search_key = 'semua';
				if($search_number == '') $search_number = '0';
				if($search_tahun == 'all' || $search_tahun == '') $search_tahun = '0000';
				if($search_jenis_pp == '') $search_jenis_pp = 'semua-jenis-putusan-pengadilan-pajak';

				$key_url = url_title($search_key, '_', TRUE);
				$jenis_pp_url = url_title($search_jenis_pp, '-', TRUE);

				$search_url = site_url().'putusan-pengadilan-pajak/search/'.$key_url.'/'.$search_number.'/'.$jenis_pp_url.'/'.$search_tahun.'/'.$search_method;

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
				$this->form_validation->set_rules('search_number', 'Nomor Putusan', 'trim');
				$this->form_validation->set_rules('search_jenis_pp', 'Jenis Putusan', 'trim');
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
					$search_key = $this->input->post('search_key');
					$search_number = $this->input->post('search_number');
					$search_jenis_pp = $this->input->post('search_jenis_pp');
					$search_jenis_pp_array = $this->input->post('search_jenis_pp_array');
					if(!empty($search_jenis_pp_array))
					{
						$search_jenis_pp = implode('_', $search_jenis_pp_array);
					}

					$search_tahun = $this->input->post('search_tahun');
					$search_tahun_array = $this->input->post('search_tahun_array');
					if(!empty($search_tahun_array))
					{
						$search_tahun = implode('_', $search_tahun_array);
					}

					$search_method = $this->input->post('search_method');

					if($search_key == '') $search_key = 'semua';
					if($search_number == '') $search_number = '0';
					if($search_tahun == 'all' || $search_tahun == '') $search_tahun = '0000';
					if($search_jenis_pp == '') $search_jenis_pp = 'semua-jenis-putusan-pengadilan-pajak';

					$key_url = url_title($search_key, '_', TRUE);
					$jenis_pp_url = url_title($search_jenis_pp, '-', TRUE);

					$search_url = site_url().'putusan-pengadilan-pajak/search/'.$key_url.'/'.$search_number.'/'.$jenis_pp_url.'/'.$search_tahun.'/'.$search_method;

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
		$search_jenis_pp = $this->uri->segment(5);
		if(strpos($search_jenis_pp, '_') !== false) {
			$search_jenis_pp = explode('_', $search_jenis_pp);
		} else {
			$search_jenis_pp = [$search_jenis_pp];
		}
		$search_tahun = $this->uri->segment(6);
		if(strpos($search_tahun, '_') !== false) {
			$search_tahun = explode('_', $search_tahun);
		}
		$search_method = $this->uri->segment(7);

		$terms = str_replace("_", " ", $search_key);

		if(empty($this->uri->segment(8))) $page = 1;
        else $page = $this->uri->segment(8);

        $data['type'] = 'searchresult';
		$data['result'] = $this->putusan_pengadilan_model->get_search_result_perpage($terms, $search_number, $search_jenis_pp, $search_tahun, $search_method, $search_sort, $search_order, $page, $this->config->item('perpage'));
		$data['jenis_pp'] = $this->putusan_pengadilan_model->get_jenis_pp();
		$data['tahun_pp'] = $this->putusan_pengadilan_model->get_tahun_pp();
		$data['latest_pp'] = $this->putusan_pengadilan_model->get_latest_pp();
		$data['count'] = count($this->putusan_pengadilan_model->get_search_result($terms, $search_number, $search_jenis_pp, $search_tahun, $search_method, $search_sort, $search_order));
		$data['countall'] = $this->putusan_pengadilan_model->count();

		$pp_key = $this->uri->segment(3);
        $pp_key = str_replace("_", " ", $pp_key);
        if($pp_key == 'semua') $pp_key = "";
        $data['pp_key'] = $pp_key;

        $pp_number = $search_number;
        if($pp_number == 0) $pp_number = '';
        $data['pp_number'] = $pp_number;

        /*Pagination*/
        $config['base_url'] = site_url('putusan-pengadilan-pajak/search/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7));
        $config['suffix'] = '?sort='.$search_sort.'&order='.$search_order;
        $config['total_rows'] = count($this->putusan_pengadilan_model->get_search_result($terms, $search_number, $search_jenis_pp, $search_tahun, $search_method, $search_sort, $search_order));
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

		$this->template->set('title', 'Putusan Pengadilan Pajak - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/pp/pp', $data);
	}

	public function get_single_content()
	{
		// if($this->user_auth->is_logged_in())
		if($this->config->item('putusan_pengadilan_login') && !$this->user_auth->is_logged_in())
		{
			$pp_id = $this->input->post('pp_id');

			//content
			$pp_full = $this->get_document($pp_id);

			//favourite
			$favourite = $this->get_favourite($pp_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> '<div class="nologin-readmore"><a href="" id="readmore-login">READ MORE</a></div>'.$pp_full,
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

			$pp_id = $this->input->post('pp_id');

			//content
			$pp_full = $this->get_document($pp_id);

			//favourite
			$favourite = $this->get_favourite($pp_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> $pp_full,
								'favourite' 	=> $favourite
							)
						);
		}
	}

	public function get_double_content()
	{
		if($this->user_auth->is_logged_in())
		{
			$pp_id1 = $this->input->post('pp_id1');
			$pp_id2 = $this->input->post('pp_id2');

			$pp_full_left = $this->get_document($pp_id1);
			$pp_full_right = $this->get_document($pp_id2);

			echo json_encode(
						array(
								'st' 				=> 1,
								'full_content_left' => $pp_full_left,
								'full_content_right'=> $pp_full_right
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

	private function get_document($pp_id, $from = null, $to = null, $cur = null)
	{
		$pp = $this->putusan_pengadilan_model->get($pp_id);
		$pp_view = $pp['view'];

		$pp_view_new = (int)$pp_view+1;

		$data = array('view' => $pp_view_new);
		$this->putusan_pengadilan_model->update($pp_id, $data);

		$pattern = "#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#"; 

		//preg_replace($pattern, '', html_entity_decode($pp['jenis_pajak']));

		//-----------------------------

		$pp_full = '<p class="head headtop"><strong>Putusan Pengadilan Pajak Nomor : '.$pp['name'].'</strong></p>';

		/*$jenis_pajak = $pp['jenis_pajak'];
		$jenis_pajak = str_replace('&ltp&gt', '&lt;p&gt;', $jenis_pajak);
		$jenis_pajak = str_replace('&lt/p&gt', '&lt;/p&gt;', $jenis_pajak);
		$pp_full .= '<p><strong>Jenis Pajak</strong></p>'. html_entity_decode($jenis_pajak);

		$pp_full .= '<p><strong>Tahun Pajak</strong></p>'. html_entity_decode('&lt;p&gt;'.$pp['tahun_keputusan'].'&lt;/p&gt;');

		$pokok_sengketa = $pp['pokok_sengketa'];
		$pokok_sengketa = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $pokok_sengketa);
		$pp_full .= '<p><strong>Pokok Sengketa</strong></p>'. html_entity_decode($pokok_sengketa);

		$menurut_terbanding = $pp['menurut_terbanding'];
		$menurut_terbanding = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $menurut_terbanding);
		$pp_full .= '<p><strong>Menurut Terbanding</strong></p>'. html_entity_decode($menurut_terbanding);

		$menurut_pemohon = $pp['menurut_pemohon'];
		$menurut_pemohon = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $menurut_pemohon);
		$pp_full .= '<p><strong>Menurut Pemohon</strong></p>'. html_entity_decode($menurut_pemohon);

		$menurut_majelis = $pp['menurut_majelis'];
		$menurut_majelis = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $menurut_majelis);
		$pp_full .= '<p><strong>Menurut Majelis</strong></p>'. html_entity_decode($menurut_majelis);

		$memperhatikan = $pp['memperhatikan'];
		$memperhatikan = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $memperhatikan);
		$pp_full .= '<p><strong>Memperhatikan</strong></p>'. html_entity_decode($memperhatikan);

		$mengingat = $pp['mengingat'];
		$mengingat = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $mengingat);
		$pp_full .= '<p><strong>Mengingat</strong></p>'. html_entity_decode($mengingat);

		$memutuskan = $pp['memutuskan'];
		$memutuskan = str_replace('&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', $memutuskan);
		$pp_full .= '<p><strong>Memutuskan</strong></p>'. html_entity_decode($memutuskan);*/

		/*$pp_full .= '<p class="head"><strong>Jenis Pajak</strong></p><p style="text-align:center;">'. $pp['jenis_pajak'] . '</p>';

	    $pp_full .= '<p class="head"><strong>Tahun Pajak</strong></p><p style="text-align:center;">'. $pp['tahun_keputusan'] . '</p>';

	    $pp_full .= '<p class="head"><strong>Pokok Sengketa</strong></p>'. $pp['pokok_sengketa'];
		
		$pp_full .= '<table cellpadding="0" cellspacing="0" border="0" class="tablecontent">';
		$pp_full .= '<tbody>';
		$pp_full .= '<tr>';
		$pp_full .= '<td><strong>Menurut Terbanding</strong></td>';
		$pp_full .= '<td>:</td>';
		$pp_full .= '<td>';
		$pp_full .= $pp['menurut_terbanding'];
		$pp_full .= '</td>';
		$pp_full .= '</tr>';
		$pp_full .= '</tbody>';
		$pp_full .= '</table>';
		
		$pp_full .= '<table cellpadding="0" cellspacing="0" border="0" class="tablecontent">';
		$pp_full .= '<tbody>';
		$pp_full .= '<tr>';
		$pp_full .= '<td><strong>Menurut Pemohon</strong></td>';
		$pp_full .= '<td>:</td>';
		$pp_full .= '<td>';
		$pp_full .= $pp['menurut_pemohon'];
		$pp_full .= '</td>';
		$pp_full .= '</tr>';
		$pp_full .= '</tbody>';
		$pp_full .= '</table>';
		
		$pp_full .= '<table cellpadding="0" cellspacing="0" border="0" class="tablecontent">';
		$pp_full .= '<tbody>';
		$pp_full .= '<tr>';
		$pp_full .= '<td><strong>Menurut Majelis</strong></td>';
		$pp_full .= '<td>:</td>';
		$pp_full .= '<td>';
		$pp_full .= $pp['menurut_majelis'];
		$pp_full .= '</td>';
		$pp_full .= '</tr>';
		$pp_full .= '</tbody>';
		$pp_full .= '</table>';
		
		$pp_full .= '<p class="head"><strong>Memperhatikan</strong></p>'. $pp['memperhatikan'];
		
		$pp_full .= '<p class="head"><strong>Mengingat</strong></p>'. $pp['mengingat'];
		
		$pp_full .= '<p class="head"><strong>Memutuskan</strong></p>'. $pp['memutuskan'];*/
		
		/*
	    $pp_full .= '<p class="head"><strong>Menurut Terbanding</strong></p>'. $pp['menurut_terbanding'];

	    $pp_full .= '<p class="head"><strong>Menurut Pemohon</strong></p>'. $pp['menurut_pemohon'];

	    $pp_full .= '<p class="head"><strong>Menurut Majelis</strong></p>'. $pp['menurut_majelis'];

	    $pp_full .= '<p class="head"><strong>Memperhatikan</strong></p>'. $pp['memperhatikan'];

	    $pp_full .= '<p class="head"><strong>Mengingat</strong></p>'. $pp['mengingat'];

	    $pp_full .= '<p class="head"><strong>Memutuskan</strong></p>'. $pp['memutuskan'];
		*/

		$pp_full .= $pp['isi_putusan'];

		$pp_full .= '<div class="footerdoc"><img src="'.site_url().'assets/themes/images/newdocfooter.png"></div>';


		//-----------------------------

		return $pp_full;
	}

	private function get_favourite($favourite_document_id)
	{
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 3, $favourite_document_id);

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
		$pp_id = $this->input->post('doc_1');

		$pp = $this->putusan_pengadilan_model->get($pp_id);

		set_cookie('cookie_pp', 'yes', 3600);
		set_cookie('cookie_pp_id', $pp_id, 3600);
		set_cookie('cookie_pp_text', 'Putusan Pengadilan Pajak Nomor: '.$pp['name'], 3600);
	}

	public function delete_cookie_sanding()
	{
		delete_cookie('cookie_pp');
		delete_cookie('cookie_pp_id');
		delete_cookie('cookie_pp_text');
	}

	public function sanding()
	{
		$id = $this->input->post('id');
		$pp = $this->putusan_pengadilan_model->get($id);

		echo 'Putusan Pengadilan Pajak Nomor: '.$pp['name'];
	}

	public function favourite()
	{
		$favourite_document_id = $this->input->post('id');
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 3, $favourite_document_id);

		if($check == 0)
		{
			$data = array(
					'favourite_user' => $favourite_user,
					'favourite_type' => 3,
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
			$favourite = $this->favourite_model->get_favourite($favourite_user, 3, $favourite_document_id);

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