<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P3b extends My_Controller {

	public function __construct()
	{
    	parent::__construct();

    	$this->load->model('p3b_model');
    	$this->load->model('p3b_article_model');
    	$this->load->model('favourite_model');

    	$this->load->library('facebook');
    	$this->load->library('pagination');

    	$this->load->helper('peraturan_pajak_helper');
	}

	public function update_url()
	{
		$p3b = $this->p3b_model->get_all();

		foreach($p3b as $row)
		{
			$p3b_id = $row['p3b_id'];
			$p3b_country = $row['p3b_country'];

			$p3b_url = url_title($p3b_country, '-', TRUE);

			$data = array(
                    'p3b_url' => $p3b_url,
                );

            $this->p3b_model->update($p3b_id, $data);
		}
	}

	public function index()
	{
		if(empty($this->uri->segment(3))) $page = 1;
        else $page = $this->uri->segment(3);

		$data['p3b'] = $this->p3b_model->get_all_publish_perpage($page, $this->config->item('perpage2'));
		$data['country'] = $this->p3b_model->get_all_publish_country_name();
		$data['count'] = $this->p3b_model->count();
		$data['latest_p3b'] = $this->p3b_model->get_latest_p3b();

		/*Pagination*/
        $config['base_url'] = site_url('p3b/index');
		$config['total_rows'] =  $this->p3b_model->count();
		$config['per_page'] = $this->config->item('perpage2');

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

		$this->template->set('title', 'Perjanjian Penghindaran Pajak Berganda (P3B) - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/p3b/p3b', $data);
	}

	public function get_social()
	{
		$id = $this->input->post('id');

		$data = $this->p3b_model->get($id);

		$url = site_url('p3b/read/'.$data['p3b_url']);

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
		$p3b = $this->p3b_model->get_publish_by('p3b_url', $url);
		$result = $p3b;

		$data['p3b'] = $p3b;
		$data['country'] = $this->p3b_model->get_all_publish_country_name();
		$data['count'] = $this->p3b_model->count();
		$data['latest_p3b'] = $this->p3b_model->get_latest_p3b();

		$title = $result['p3b_country'].' - Perjanjian Penghindaran Pajak Berganda (P3B) - '.$this->config->item('web_title');
		$description = substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($result['p3b_header_id']))), 0, 255);

		$keywords = 'Perjanjian Penghindaran Pajak Berganda P3B '.$result['p3b_country'];
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
							        $('.modalcaller-p3b#".$p3b['p3b_id']."').trigger( 'click', [ '".$p3b['p3b_id']."' ]  );

							        return false;
							      });
							    </script>";

		$this->template->set('container_class', 'search-page');

		$this->template->set('title', $result['p3b_country'].' - Perjanjian Penghindaran Pajak Berganda (P3B) - '.$this->config->item('web_title'));
		$this->template->load('web/template/template-2', 'web/p3b/p3b-read', $data);
	}

	public function get_single_content()
	{
		if($this->config->item('p3b_login') && !$this->user_auth->is_logged_in())
		{
			$p3b_id = $this->input->post('p3b_id');

			//content
			$p3b_full = $this->get_document($p3b_id);

			//favourite
			$favourite = $this->get_favourite($p3b_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> '<div class="nologin-readmore"><a href="" id="readmore-login">READ MORE</a></div>'.$p3b_full,
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

			$p3b_id = $this->input->post('p3b_id');

			//content
			$p3b_full = $this->get_document($p3b_id);

			//favourite
			$favourite = $this->get_favourite($p3b_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'full_content' 	=> $p3b_full,
								'favourite' 	=> $favourite
							)
						);
		}
	}

	public function get_double_content()
	{
		if($this->user_auth->is_logged_in())
		{
			$p3b_id1 = $this->input->post('p3b_id1');
			$p3b_id2 = $this->input->post('p3b_id2');

			$p3b_full_left = $this->get_document($p3b_id1);
			$p3b_full_right = $this->get_document($p3b_id2);

			echo json_encode(
						array(
								'st' 				=> 1,
								'full_content_left' => $p3b_full_left,
								'full_content_right'=> $p3b_full_right
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

	public function get_single_content_by_country_name()
	{
		if(!$this->config->item('search_p3b_login'))
		{
			$p3b_country = $this->input->post('p3b_country');

			$p3b = $this->p3b_model->get_by_country($p3b_country);
			$p3b_id = $p3b['p3b_id'];

			//content
			$p3b_full = $this->get_document($p3b_id);

			//favourite
			$favourite = $this->get_favourite($p3b_id);

			echo json_encode(
						array(
								'st' 			=> 1,
								'p3b_id' 		=> $p3b_id,
								'full_content' 	=> $p3b_full,
								'favourite' 	=> $favourite
							)
						);
		}
		else
		{
			if($this->user_auth->is_logged_in())
			{
				$p3b_country = $this->input->post('p3b_country');

				$p3b = $this->p3b_model->get_by_country($p3b_country);
				$p3b_id = $p3b['p3b_id'];

				//content
				$p3b_full = $this->get_document($p3b_id);

				//favourite
				$favourite = $this->get_favourite($p3b_id);

				echo json_encode(
							array(
									'st' 			=> 1,
									'p3b_id' 		=> $p3b_id,
									'full_content' 	=> $p3b_full,
									'favourite' 	=> $favourite
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
	}

	public function get_double_content_by_country_name()
	{
		if($this->user_auth->is_logged_in())
		{
			$p3b_country1 = $this->input->post('p3b_country1');
			$p3b1 = $this->p3b_model->get_by_country($p3b_country1);
			$p3b_id1 = $p3b1['p3b_id'];

			$p3b_country2 = $this->input->post('p3b_country2');
			$p3b2 = $this->p3b_model->get_by_country($p3b_country2);
			$p3b_id2 = $p3b2['p3b_id'];

			$article = $this->input->post('article');
			$cut_1 = $this->input->post('cut_1');
			$cut_2 = $this->input->post('cut_2');
			$cut_3 = $this->input->post('cut_3');

			//content
			if($article == 'all')
			{
				$p3b_full_left = $this->get_document($p3b_id1);
				$p3b_full_right = $this->get_document($p3b_id2);
			}
			if($article == 'cut')
			{
				$p3b_full_left = $this->get_document($p3b_id1, $cut_1, $cut_2);
				$p3b_full_right = $this->get_document($p3b_id2, $cut_1, $cut_2);
			}
			if($article == 'one')
			{
				$p3b_full_left = $this->get_document($p3b_id1, null, null, $cut_3);
				$p3b_full_right = $this->get_document($p3b_id2, null, null, $cut_3);
			}

			echo json_encode(
						array(
								'st' 				=> 1,
								'full_content_left' => $p3b_full_left,
								'full_content_right'=> $p3b_full_right
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

	private function get_document($p3b_id, $from = null, $to = null, $cur = null)
	{
		$p3b = $this->p3b_model->get($p3b_id);
		
		/*view*/
		$p3b_view = $p3b['p3b_view'];

		$p3b_view_new = (int)$p3b_view+1;

		$data = array('p3b_view' => $p3b_view_new);
		$this->p3b_model->update($p3b_id, $data);
		/*view*/

		$p3b_country = $p3b['p3b_country'];

		$p3b_status = $p3b['p3b_status'];

		if($p3b_status == 1) $p3b_status_name = 'In Force';
		else $p3b_status_name = '-';

		$p3b_header_id = $p3b['p3b_header_id'];
		$p3b_header_en = $p3b['p3b_header_en'];

		if($from == null && $to == null && $cur == null) $p3b_article = $this->p3b_article_model->get_all_article($p3b_id);
		if($from != null && $to != null && $cur == null) $p3b_article = $this->p3b_article_model->get_article_range($p3b_id, $from, $to);
		if($from == null && $to == null && $cur != null) $p3b_article = $this->p3b_article_model->get_article_current($p3b_id, $cur);

		$p3b_article_id = '';
		$cur_chapter = 0;
		$empty_id = 0;

		foreach($p3b_article as $row)
		{
			if($row['p3b_article_chapter'] != 0)
			{
				if($row['p3b_article_chapter'] !== $cur_chapter)
				{
					$p3b_article_id .= '<p><br><center><strong>CHAPTER '.to_romawi($row['p3b_article_chapter']).'</strong>';
					$p3b_article_id .= '<strong>'.$row['p3b_article_chapter_title_id'].'</strong></center></p>';
				}

				$cur_chapter = $row['p3b_article_chapter'];
			}

			$p3b_article_id .= '<p><br><center><strong>Pasal '.$row['p3b_article_number'].'</strong><br/>';
			$p3b_article_id .= '<strong>'.$row['p3b_article_title_id'].'</strong></center></p>';
			$p3b_article_id .= $row['p3b_article_content_id'];

			if($row['p3b_article_content_id'] == "") $empty_id = 1;
		}

		$p3b_article_en = '';
		$cur_chapter = 0;
		$empty_en = 0;

		foreach($p3b_article as $row)
		{
			if($row['p3b_article_chapter'] != 0)
			{
				if($row['p3b_article_chapter'] !== $cur_chapter)
				{
					$p3b_article_en .= '<p><br><center><strong>CHAPTER '.to_romawi($row['p3b_article_chapter']).'</strong><br />';
					$p3b_article_en .= '<strong>'.$row['p3b_article_chapter_title_en'].'</strong></center></p>';
				}

				$cur_chapter = $row['p3b_article_chapter'];
			}

			$p3b_article_en .= '<p><br><center><strong>Article '.$row['p3b_article_number'].'</strong></center>';
			$p3b_article_en .= '<center><strong>'.$row['p3b_article_title_en'].'</strong></center></p>';
			$p3b_article_en .= $row['p3b_article_content_en'];

			if($row['p3b_article_content_en'] == "") $empty_en = 1;
		}

		$p3b_protocol_id = $p3b['p3b_protocol_id'];
		$p3b_protocol_en = $p3b['p3b_protocol_en'];

		//-----------------------------

		$p3b_top = '<div class="treaty-meta">Status : '.$p3b_status_name.' | Effective : '.format_tanggal_indonesia($p3b['p3b_date_effective']).' | Signed :  '.format_tanggal_indonesia($p3b['p3b_date_signed']).'</div>';
		$p3b_top .= '<img src="'.site_url().'assets/themes/images/flag/flag-indonesia.jpg" class="img-flag" width="100" height="65">';
        $p3b_top .= '<img src="'.site_url().'assets/themes/images/flag/flag-'.strtolower($p3b_country).'.png" class="img-flag" width="100" height="65">';

        if($empty_id == 0 && $empty_en == 0) $p3b_top .= '<div class="treaty-lang"><span class="active"><a href="" id="btn-en">ENGLISH</a></span> | <span><a href="" id="btn-id">BAHASA</a></span></div>';
        if($empty_id == 1 && $empty_en == 0) $p3b_top .= '<div class="treaty-lang"><span class="active"><a href="" id="btn-en">ENGLISH</a></span></div>';
        if($empty_id == 0 && $empty_en == 1) $p3b_top .= '<div class="treaty-lang"><span class="active"><a href="" id="btn-id">BAHASA</a></span></div>';

		$p3b_full_id = $p3b_header_id;
		$p3b_full_id .= $p3b_article_id;
		if(!empty($p3b_protocol_id)) $p3b_full_id .= '<p><center><strong>PROTOkOL</strong></center></p>'.$p3b_protocol_id;
		$p3b_full_id .= '<div class="footerdoc"><img src="'.site_url().'assets/themes/images/newdocfooter.png"></div>';

		$p3b_full_en = $p3b_header_en;
		$p3b_full_en .= $p3b_article_en;
		if(!empty($p3b_protocol_en)) $p3b_full_en .= '<p><center><strong>PROTOCOL</strong></center></p>'.$p3b_protocol_en;
		$p3b_full_en .= '<div class="footerdoc"><img src="'.site_url().'assets/themes/images/newdocfooter.png"></div>';

		$p3b_full = $p3b_top.'<div id="id">'.$p3b_full_id.'</div><div id="en">'.$p3b_full_en.'</div>';


		//-----------------------------

		return $p3b_full;
	}

	private function get_favourite($favourite_document_id)
	{
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 2, $favourite_document_id);

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
		$p3b_id = $this->input->post('doc_1');

		$p3b = $this->p3b_model->get($p3b_id);

		set_cookie('cookie_p3b', 'yes', 3600);
		set_cookie('cookie_p3b_id', $p3b_id, 3600);
		set_cookie('cookie_p3b_text', 'Perjanjian Penghindaran Pajak Berganda: '.$p3b['p3b_country'], 3600);
	}

	public function delete_cookie_sanding()
	{
		delete_cookie('cookie_p3b');
		delete_cookie('cookie_p3b_id');
		delete_cookie('cookie_p3b_text');
	}

	public function sanding()
	{
		$id = $this->input->post('id');
		$p3b = $this->p3b_model->get($id);

		echo 'Perjanjian Penghindaran Pajak Berganda: '.$p3b['p3b_country'];
	}

	public function favourite()
	{
		$favourite_document_id = $this->input->post('id');
		$favourite_user = $this->session->userdata('user_id');

		$check = $this->favourite_model->check($favourite_user, 2, $favourite_document_id);

		if($check == 0)
		{
			$data = array(
					'favourite_user' => $favourite_user,
					'favourite_type' => 2,
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
			$favourite = $this->favourite_model->get_favourite($favourite_user, 2, $favourite_document_id);

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

	public function data()
	{

	}

	public function data_input()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('p3b_country', 'Country', 'trim|required');

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

		$this->form_validation->set_error_delimiters();

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('web/p3b/p3b-input');
		}
		else
		{
			$p3b_country = $this->input->post('p3b_country');

			$p3b_header_id = $this->input->post('p3b_header_id');	
			$p3b_header_en = $this->input->post('p3b_header_en');	

			$p3b_protocol_id = $this->input->post('p3b_protocol_id');	
			$p3b_protocol_en = $this->input->post('p3b_protocol_en');

			$data = array(
					'p3b_country' 		=> $p3b_country,
					'p3b_header_id' 	=> $p3b_header_id,
					'p3b_header_en' 	=> $p3b_header_en,
					'p3b_protocol_id'	=> $p3b_protocol_id,
					'p3b_protocol_en'	=> $p3b_protocol_en,
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
						'p3b_article_p3b' 				=> $p3b_article_p3b,
						'p3b_article_number' 			=> $p3b_article_number,
						'p3b_article_chapter' 			=> $p3b_chapter[$key],
						'p3b_article_chapter_title_id' 	=> $p3b_chapter_title_id[$key],
						'p3b_article_chapter_title_en' 	=> $p3b_chapter_title_en[$key],
						'p3b_article_title_id' 			=> $p3b_article_title_id[$key],
						'p3b_article_title_en' 			=> $p3b_article_title_en[$key],
						'p3b_article_content_id' 		=> $p3b_article_content_id[$key],
						'p3b_article_content_en' 		=> $p3b_article_content_en[$key]
					);

				if(!empty($p3b_article_content_id) && !empty($p3b_article_content_en))
				{
					$this->p3b_article_model->insert($data);

					$p3b_article_number++;
				}
			}

			redirect('p3b/data_input');
		}
	}

	public function data_view()
	{

	}

	public function data_delete()
	{

	}
}