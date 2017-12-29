<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends MY_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
    	$this->load->helper('peraturan_pajak_helper');
		$this->load->model('p3b_article_model');
    }
	
	public function index()
	{	
		echo 'nothing happen';
	}
	
	public function rp()
	{			
		//if($this->user_auth->is_logged_in())
		//{
			$param_offset= 0 ;
			$params = array_slice($this->uri->rsegment_array(), $param_offset);			
			$id = $params[2];
			
			$pj = $this->regulasi_pajak_model->get($id);
			$pj_view = $pj['view'];

			$pj_view_new = (int)$pj_view+1;

			$data = array('view' => $pj_view_new);
			$this->regulasi_pajak_model->update($id, $data);
			
			$regulasi_pajak = $this->regulasi_pajak_model->get($id);
			if(!empty($regulasi_pajak)) {
				$id_o = $regulasi_pajak['id_o'];
				$body_final = $regulasi_pajak['body_final'];

				if(!$id_o || $id_o == NULL || $id_o == 0)
				{
					$linklist  = $regulasi_pajak['linklist'];

					if($linklist != '') 
					{
						$body_replace = regulasi_ortax_format_body_rp($linklist, $body_final);
					} 
					else
					{
						$body_replace = $body_final;
					}
				}
				else
				{
					$linklist = get_linklist($id_o);

					if($linklist != '') 
					{
						$body_replace = regulasi_ortax_format_body($linklist, $body_final);
					} 
					else
					{
						$body_replace = $body_final;
					}
				}
				
				$id = $this->input->post('id');
				$regulasi_pajak = $this->regulasi_pajak_model->get($id);
				
				$tes = "<html><head><style>table tr, p, img, ul, ol{page-break-inside: avoid !important; padding-top:40px !important; padding-left:10px !important; padding-right:10px !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:12px !important;line-height:14px !important;margin-top:40px !important;} .nocompare-content {margin:25px !important;height:auto !important;overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} table tr td td, table tr td td span {font-size:11px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;border:0 !important;} td {border-width:.5px !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:25px !important;padding:0 !important;z-index: 99 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .doc-modal table table .wi{padding:2px !important;} body, html{z-index: 99 !important;overflow:hidden !important;margin:25px !important;} a, u {font-weight:400 !important;text-decoration:none !important;color:#000 !important;} .peraturan_title {margin:25px !important;text-align:center;}</style>";
				$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
				$tes .= "<style>";
				$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
				$tes .= "</style>";
				$tes .= "</head><body>";
				$tes .= "<div class='doc-modal'>";
				$tes .= "<div class='modal-desc' id='modal-contents' style='page-break-before: always;'>";
				$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
				$tes .= $body_replace;
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/jquery.min.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/html2canvas.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/converttable.js?v=1'></script>";
				$tes .= "<script type=\"text/javascript\">";
				$tes .= "var html2pdf = {";
				$tes .= "footer: {";
				$tes .= "height:\"2.5cm\",";
				$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;overflow:visible; height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 300px;\"></div>'";
				//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
				$tes .= "}";
				$tes .= "};";
				$tes .= "</script>";
				$tes .= "</body></html>";
				
				echo $tes;
			} else {
				echo 'no content';
			}
		//} 
		//else 
		//{
		//	echo 'not authorize';
		//}
	}
	
	public function noc()
	{			
		//if($this->user_auth->is_logged_in())
		//{
			$param_offset= 0 ;
			$params = array_slice($this->uri->rsegment_array(), $param_offset);			
			$id = $params[2];
			
			$pj = $this->regulasi_pajak_model->get($id);
			$pj_view = $pj['view'];

			$pj_view_new = (int)$pj_view+1;

			$data = array('view' => $pj_view_new);
			$this->regulasi_pajak_model->update($id, $data);
			
			$regulasi_pajak = $this->regulasi_pajak_model->get($id);
			if(!empty($regulasi_pajak)) {
				$id_o = $regulasi_pajak['id_o'];
				$body_final = $regulasi_pajak['body_final'];

				if(!$id_o || $id_o == NULL || $id_o == 0)
				{
					$linklist  = $regulasi_pajak['linklist'];

					if($linklist != '') 
					{
						$body_replace = regulasi_ortax_format_body_rp($linklist, $body_final);
					} 
					else
					{
						$body_replace = $body_final;
					}
				}
				else
				{
					$linklist = get_linklist($id_o);

					if($linklist != '') 
					{
						$body_replace = regulasi_ortax_format_body($linklist, $body_final);
					} 
					else
					{
						$body_replace = $body_final;
					}
				}
				
				$id = $this->input->post('id');
				$regulasi_pajak = $this->regulasi_pajak_model->get($id);
				
				$tes = "<html><head><style>table tr, p, img, ul, ol{page-break-inside: avoid !important; padding-top:40px !important; padding-left:10px !important; padding-right:10px !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:12px !important;line-height:14px !important;margin-top:40px !important;} .nocompare-content {margin:25px !important;height:auto !important;overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} table tr td td, table tr td td span {font-size:11px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;border:0 !important;} td {border-width:.5px !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:25px !important;padding:0 !important;z-index: 99 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .doc-modal table table .wi{padding:2px !important;} body, html{z-index: 99 !important;overflow:hidden !important;margin:25px !important;} a, u {font-weight:400 !important;text-decoration:none !important;color:#000 !important;} .peraturan_title {margin:25px !important;text-align:center;}</style>";
				$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
				$tes .= "<style>";
				$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
				$tes .= "</style>";
				$tes .= "</head><body>";
				$tes .= "<div class='doc-modal'>";
				$tes .= "<div class='modal-desc' id='modal-contents' style='page-break-before: always;'>";
				$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
				$tes .= $body_replace;
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/jquery.min.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/html2canvas.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/converttable.js?v=1'></script>";
				$tes .= "<script type=\"text/javascript\">";
				$tes .= "var html2pdf = {";
				$tes .= "footer: {";
				$tes .= "height:\"2.5cm\",";
				$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;overflow:visible; height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 300px;\"></div>'";
				//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
				$tes .= "}";
				$tes .= "};";
				$tes .= "</script>";
				$tes .= "</body></html>";
				
				echo $tes;
			} else {
				echo 'no content';
			}
		//} 
		//else 
		//{
		//	echo 'not authorize';
		//}
	}

	public function pp()
	{			
		//if($this->user_auth->is_logged_in())
		//{
			$param_offset= 0 ;
			$params = array_slice($this->uri->rsegment_array(), $param_offset);			
			$id = $params[2];
			
			$pp = $this->putusan_pengadilan_model->get($id);
			if(!empty($pp)) {
				$pp_full = '<p class="head headtop"><strong>Putusan Pengadilan Pajak Nomor : '.$pp['name'].'</strong></p>';
				$pp_full .= $pp['isi_putusan'];
				
				//$tes = "<html><head><style>* {overflow:visible;} table tr, p, img, ul, ol{page-break-before: always !important;page-break-inside: avoid !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:10px !important;line-height:14px !important;} table tr td td, table tr td td span {font-size:8px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;} table {border:0 !important;} td {border-width:.5px !important;} .nocompare-content-pp {height:auto !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:0 !important;padding:0 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .nocompare-content {overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} .doc-modal-pp table table .wi{padding:2px !important;} body, html{overflow:hidden !important;}</style>";
				$tes = "<html><head><style>table tr, p, img, ul, ol{page-break-inside: avoid !important; padding-left:10px !important; padding-right:10px !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:12px !important;line-height:14px !important;margin-top:40px !important;} .nocompare-content {margin:25px !important;height:auto !important;overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} table tr td td, table tr td td span {font-size:11px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;border:0 !important;} td {border-width:.5px !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:25px !important;padding:0 !important;z-index: 99 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .doc-modal table table .wi{padding:2px !important;} body, html{z-index: 99 !important;overflow:hidden !important;margin:25px !important;} a, u {font-weight:400 !important;text-decoration:none !important;color:#000 !important;} .peraturan_title {margin:25px !important;text-align:center;}</style>";
				$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
				$tes .= "<style>";
				$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
				$tes .= "</style>";
				$tes .= "</head><body>";
				$tes .= "<div class='doc-modal-pp'>";
				$tes .= "<div class='modal-desc' id='modal-contents-pp' style='page-break-before: always;'>";
				$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
				$tes .= "<div class='nocompare-content nocompare-content-pp' id='nocompare-wrapper-pp'>";
				$tes .= $pp_full;
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/jquery.min.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/html2canvas.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/converttable.js'></script>";
				$tes .= "<script type=\"text/javascript\">";
				$tes .= "var html2pdf = {";
				$tes .= "footer: {";
				$tes .= "height:\"1.5cm\",";
				$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 262px;\"></div>'";
				//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
				$tes .= "}";
				$tes .= "};";
				$tes .= "</script>";
				$tes .= "</body></html>";
				
				echo $tes;
			} else {
				echo 'no content';
			}
		//}
		//else
		//{
		//	echo 'not authorize';
		//}
	}

	public function ma()
	{			
		//if($this->user_auth->is_logged_in())
		//{
			$param_offset= 0 ;
			$params = array_slice($this->uri->rsegment_array(), $param_offset);			
			$id = $params[2];
			
			$ma = $this->putusan_ma_model->get($id);
			if(!empty($ma)) {
				$pattern = "#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#"; 
				$ma_full = $ma['ma_content'];
				
				$tes = "<html><head><style>table tr, p, img, ul, ol{page-break-inside: avoid !important; padding-left:10px !important; padding-right:10px !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:12px !important;line-height:14px !important;margin-top:40px !important;} .nocompare-content {margin:25px !important;height:auto !important;overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} table tr td td, table tr td td span {font-size:11px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;border:0 !important;} td {border-width:.5px !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:25px !important;padding:0 !important;z-index: 99 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .doc-modal table table .wi{padding:2px !important;} body, html{z-index: 99 !important;overflow:hidden !important;margin:25px !important;} a, u {font-weight:400 !important;text-decoration:none !important;color:#000 !important;} .peraturan_title {margin:25px !important;text-align:center;}</style>";
				$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
				$tes .= "<style>";
				$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
				$tes .= "</style>";
				$tes .= "</head><body>";
				$tes .= "<div class='doc-modal-ma'>";
				$tes .= "<div class='modal-desc' id='modal-contents-ma' style='page-break-before: always;'>";
				$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
				$tes .= "<div class='nocompare-content nocompare-content-ma' id='nocompare-wrapper-ma'>";
				$tes .= $ma_full;
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/jquery.min.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/html2canvas.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/converttable.js'></script>";
				$tes .= "<script type=\"text/javascript\">";
				$tes .= "var html2pdf = {";
				$tes .= "footer: {";
				$tes .= "height:\"1.5cm\",";
				$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 296px;\"></div>'";
				//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
				$tes .= "}";
				$tes .= "};";
				$tes .= "</script>";
				$tes .= "</body></html>";
				
				echo $tes;
			} else {
				echo 'no content';
			}
		//}
		//else
		//{
		//	echo 'not authorize';
		//}
	}

	public function p3b()
	{
		//if($this->user_auth->is_logged_in())
		//{
			$param_offset= 0 ;
			$params = array_slice($this->uri->rsegment_array(), $param_offset);			
			$id = $params[2];
			$lang = $params[3];
			
			if($id == '') {
				echo 'please select doc number';
				die();
			}
			
			if($lang == '') {
				echo 'please select language';
				die();
			}
			
			$p3b = $this->p3b_model->get($id);
			if($p3b['p3b_country']) {
				$p3b_country = $p3b['p3b_country'];
				$p3b_status = $p3b['p3b_status'];

				if($p3b_status == 1) $p3b_status_name = 'In Force';
				else $p3b_status_name = '-';

				$p3b_header_id = $p3b['p3b_header_id'];
				$p3b_header_en = $p3b['p3b_header_en'];
				
				$p3b_article = $this->p3b_article_model->get_all_article($id);

				$p3b_article_id = '';
				$cur_chapter = 0;
				$empty_id = 0;

				foreach($p3b_article as $row)
				{
					if(!$row['p3b_article_content_id'] && $lang == 'id') {
						exit('no content');
					}
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
					if(!$row['p3b_article_title_en'] && $lang == 'en') {
						exit('no content');
					}
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

				$p3b_top = '<div class="treaty-meta">Status : '.$p3b_status_name.' | Effective : '.format_tanggal_indonesia($p3b['p3b_date_effective']).' | Signed :  '.format_tanggal_indonesia($p3b['p3b_date_signed']).'</div>';
				$p3b_top .= '<img src="'.site_url().'assets/themes/images/flag/flag-indonesia.jpg" class="img-flag" width="100" height="65">';
				$p3b_top .= '<img src="'.site_url().'assets/themes/images/flag/flag-'.strtolower($p3b_country).'.png" class="img-flag" width="100" height="65">';

				$p3b_full_id = $p3b_header_id;
				$p3b_full_id .= $p3b_article_id;
				if(!empty($p3b_protocol_id)) $p3b_full_id .= '<p><center><strong>PROTOkOL</strong></center></p>'.$p3b_protocol_id;
				//$p3b_full_id .= '<div class="footerdoc"><img src="'.site_url().'assets/themes/images/printdocfooter.jpg"></div>';

				$p3b_full_en = $p3b_header_en;
				$p3b_full_en .= $p3b_article_en;
				if(!empty($p3b_protocol_en)) $p3b_full_en .= '<p><center><strong>PROTOCOL</strong></center></p>'.$p3b_protocol_en;
				//$p3b_full_en .= '<div class="footerdoc"><img src="'.site_url().'assets/themes/images/printdocfooter.jpg"></div>';
				
				if($lang == 'id') {
					$p3b_full = $p3b_top.'<div id="id">'.$p3b_full_id.'</div>';
				}
				
				if($lang == 'en') {
					$p3b_full = $p3b_top.'<div id="en">'.$p3b_full_en.'</div>';
				}
				
				$tes = "<html><head><style>table tr, p, img, ul, ol{page-break-inside: avoid !important; padding-left:10px !important; padding-right:10px !important;} body,p, table tr td { font-family: 'Cambria' !important; font-size:12px !important;line-height:14px !important;margin-top:40px !important;} .nocompare-content {margin:25px !important;height:auto !important;overflow-x:inherit !important;overflow-y:hidden !important;padding:0 !important;} table tr td td, table tr td td span {font-size:11px !important;} p, li, td {text-align:justify;} table {border-collapse: collapse;border:0 !important;} td {border-width:.5px !important;} table img {margin:0 auto !important;display:block;padding:0 !important;max-width:100% !important;height:auto !important;} html, body {height:auto !important;margin:25px !important;padding:0 !important;z-index: 99 !important;} .tablewrap {padding:0 !important;width:100% !important;display:block !important;overflow:inherit !important;} .tablewrap .tablewrap {padding:0 !important;margin:0 !important;} .doc-modal table table .wi{padding:2px !important;} body, html{z-index: 99 !important;overflow:hidden !important;margin:25px !important;} a, u {font-weight:400 !important;text-decoration:none !important;color:#000 !important;} .peraturan_title {margin:25px !important;text-align:center;}</style>";
				$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
				$tes .= "<style>";
				$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
				$tes .= "</style>";
				$tes .= "</head><body>";
				$tes .= "<div class='doc-modal-p3b'>";
				$tes .= "<div class='modal-desc' id='modal-contents-p3b' style='page-break-before: always;'>";
				$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
				$tes .= "<div class='nocompare-content nocompare-content-p3b' id='nocompare-wrapper-p3b'>";
				$tes .= $p3b_full;
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "</div>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/jquery.min.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/html2canvas.js'></script>";
				$tes .= "<script src='https://engine.ddtc.co.id/assets/themes/js/converttable.js'></script>";
				$tes .= "<script type=\"text/javascript\">";
				$tes .= "var html2pdf = {";
				$tes .= "footer: {";
				$tes .= "height:\"1.5cm\",";
				$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 262px;\"></div>'";
				//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
				$tes .= "}";
				$tes .= "};";
				$tes .= "</script>";
				$tes .= "</body></html>";
				
				echo $tes;
			} else {
				echo 'no content';
			}
		//}
		//else
		//{
		//	echo 'not authorize';
		//}
	}
	
	public function tes()
	{
		$tes = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
		$tes = "<html class='no-js' xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='en-US'><head>";
		$tes .= "<link href='https://engine.ddtc.co.id/assets/themes/css/custom.css?v=5' rel='stylesheet' type='text/css'>";
		$tes .= "<style>";
		$tes .= "html,body,td,ol,p{font-size:12px;}";
		$tes .= ".modal-desc,html,body,.nocompare-content{overflow:visible !important;z-index: 99 !important;}";
		$tes .= "</style>";
		$tes .= "</head><body>";
		$tes .= "<div class='doc-modal'>";
		$tes .= "<div class='modal-desc' id='modal-contents'>";
		$tes .= "<img src='https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png' width='0' height='0' />";
		$tes .= "<table border='0' cellpadding='0' cellspacing='0' style='page-break-inside:auto;'>";
		$tes .= "<tbody style='page-break-inside:auto;'>";
		$tes .= "<tr style='page-break-inside:auto;'><td style='page-break-inside:auto;'>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
		//$tes .= "<ol><li><div>Undang-Undang Pengampunan Pajak adalah Undang-Undang Nomor 11 Tahun 2016 tentang Pengampunan Pajak.</div></li><li><div>Pengampunan Pajak adalah penghapusan pajak yang seharusnya terutang, tidak dikenai sanksi administrasi perpajakan dan sanksi pidana di bidang perpajakan, dengan cara mengungkap Harta dan membayar Uang Tebusan sebagaimana diatur dalam Undang-Undang Pengampunan Pajak.</div></li><li><div>Wajib Pajak adalah orang pribadi atau badan yang mempunyai hak dan kewajiban perpajakan sesuai dengan ketentuan peraturan perundang-undangan di bidang perpajakan.</div></li><li><div>Harta adalah akumulasi tambahan kemampuan ekonomis berupa seluruh kekayaan, baik berwujud maupun tidak berwujud, baik bergerak maupun tidak bergerak, baik yang digunakan untuk usaha maupun bukan untuk usaha, yang berada di dalam dan/atau di luar wilayah Negara Kesatuan Republik Indonesia.</div></li><li><div>Utang adalah jumlah pokok utang yang belum dibayar yang berkaitan langsung dengan perolehan Harta.</div></li><li><div>Tahun Pajak adalah jangka waktu 1 (satu) tahun kalender kecuali jika Wajib Pajak menggunakan tahun buku yang tidak sama dengan tahun kalender.</div></li><li><div>Tunggakan Pajak adalah jumlah pokok pajak yang belum dilunasi berdasarkan Surat Tagihan Pajak yang di dalamnya terdapat pokok pajak yang terutang, Surat Ketetapan Pajak Kurang Bayar, Surat Ketetapan Pajak Kurang Bayar Tambahan, Surat Keputusan Pembetulan, Surat Keputusan Keberatan, Putusan Banding dan Putusan Peninjauan Kembali yang menyebabkan jumlah pajak yang masih harus dibayar bertambah termasuk pajak yang seharusnya tidak dikembalikan, sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan .</div></li><li><div>Uang Tebusan adalah sejumlah uang yang dibayarkan ke kas negara untuk mendapatkan Pengampunan Pajak.</div></li><li><div>Tindak Pidana di Bidang Perpajakan adalah tindak pidana sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan.</div></li><li><div>Surat Pernyataan Harta untuk Pengampunan Pajak yang selanjutnya disebut Surat Pernyataan adalah surat yang digunakan oleh Wajib Pajak untuk melaporkan Harta, Utang, nilai Harta Bersih, penghitungan dan pembayaran Uang Tebusan.</div></li><li><div>Menteri adalah menteri yang menyelenggarakan urusan pemerintahan di bidang keuangan negara.</div></li><li><div>Surat Keterangan Pengampunan Pajak yang selanjutnya disebut Surat Keterangan adalah surat yang diterbitkan oleh Menteri sebagai bukti pemberian Pengampunan Pajak.</div></li><li>Surat Pemberitahuan Tahunan Pajak Penghasilan Terakhir yang selanjutnya disebut SPT PPh Terakhir adalah:</li><li><div>Surat Pemberitahuan Tahunan Pajak Penghasilan adalah Surat Pemberitahuan Pajak Penghasilan untuk suatu Tahun Pajak atau bagian Tahun Pajak.</div></li><li><div>Manajemen Data dan Informasi adalah sistem administrasi data dan informasi Wajib Pajak yang berkaitan dengan Pengampunan Pajak yang dikelola oleh Menteri.</div></li><li><div>Kantor Wilayah Direktorat Jenderal Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut Kanwil DJP Wajib Pajak Terdaftar adalah Kantor Wilayah Direktorat Jenderal Pajak yang wilayah kerjanya meliputi Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Kantor Pelayanan Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut KPP Tempat Wajib Pajak Terdaftar adalah Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Bank Persepsi adalah bank umum yang ditunjuk oleh Menteri untuk menerima setoran penerimaan negara dan berdasarkan Undang-Undang Pengampunan Pajak ditunjuk untuk menerima setoran Uang Tebusan dan/atau dana yang dialihkan ke dalam wilayah Negara Kesatuan Republik Indonesia dalam rangka pelaksanaan Pengampunan Pajak.</div></li><li><div>Tahun Pajak Terakhir adalah Tahun Pajak yang berakhir pada jangka waktu 1 Januari 2015 sampai dengan 31 Desember 2015.</div></li></ol>";
        
		/*
		$tes .= "<div style='page-break-inside:auto;display:block;'>";
		$tes .= "<table border='0' cellpadding='0' cellspacing='0' style='page-break-inside:auto;display:block;'>";
        $tes .= "<tbody style='page-break-inside:auto;display:block;'>";
        $tes .= "<tr style='page-break-inside:auto;display:block;'><td style='page-break-inside:auto;display:block;'>";
        $tes .= "<div style='page-break-inside:auto;display:block;'>";
		$tes .= "<ol style='page-break-inside:auto;display:block;'><li><div>Undang-Undang Pengampunan Pajak adalah Undang-Undang Nomor 11 Tahun 2016 tentang Pengampunan Pajak.</div></li><li><div>Pengampunan Pajak adalah penghapusan pajak yang seharusnya terutang, tidak dikenai sanksi administrasi perpajakan dan sanksi pidana di bidang perpajakan, dengan cara mengungkap Harta dan membayar Uang Tebusan sebagaimana diatur dalam Undang-Undang Pengampunan Pajak.</div></li><li><div>Wajib Pajak adalah orang pribadi atau badan yang mempunyai hak dan kewajiban perpajakan sesuai dengan ketentuan peraturan perundang-undangan di bidang perpajakan.</div></li><li><div>Harta adalah akumulasi tambahan kemampuan ekonomis berupa seluruh kekayaan, baik berwujud maupun tidak berwujud, baik bergerak maupun tidak bergerak, baik yang digunakan untuk usaha maupun bukan untuk usaha, yang berada di dalam dan/atau di luar wilayah Negara Kesatuan Republik Indonesia.</div></li><li><div>Utang adalah jumlah pokok utang yang belum dibayar yang berkaitan langsung dengan perolehan Harta.</div></li><li><div>Tahun Pajak adalah jangka waktu 1 (satu) tahun kalender kecuali jika Wajib Pajak menggunakan tahun buku yang tidak sama dengan tahun kalender.</div></li><li><div>Tunggakan Pajak adalah jumlah pokok pajak yang belum dilunasi berdasarkan Surat Tagihan Pajak yang di dalamnya terdapat pokok pajak yang terutang, Surat Ketetapan Pajak Kurang Bayar, Surat Ketetapan Pajak Kurang Bayar Tambahan, Surat Keputusan Pembetulan, Surat Keputusan Keberatan, Putusan Banding dan Putusan Peninjauan Kembali yang menyebabkan jumlah pajak yang masih harus dibayar bertambah termasuk pajak yang seharusnya tidak dikembalikan, sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan .</div></li><li><div>Uang Tebusan adalah sejumlah uang yang dibayarkan ke kas negara untuk mendapatkan Pengampunan Pajak.</div></li><li><div>Tindak Pidana di Bidang Perpajakan adalah tindak pidana sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan.</div></li><li><div>Surat Pernyataan Harta untuk Pengampunan Pajak yang selanjutnya disebut Surat Pernyataan adalah surat yang digunakan oleh Wajib Pajak untuk melaporkan Harta, Utang, nilai Harta Bersih, penghitungan dan pembayaran Uang Tebusan.</div></li><li><div>Menteri adalah menteri yang menyelenggarakan urusan pemerintahan di bidang keuangan negara.</div></li><li><div>Surat Keterangan Pengampunan Pajak yang selanjutnya disebut Surat Keterangan adalah surat yang diterbitkan oleh Menteri sebagai bukti pemberian Pengampunan Pajak.</div></li><li>Surat Pemberitahuan Tahunan Pajak Penghasilan Terakhir yang selanjutnya disebut SPT PPh Terakhir adalah:</li><li><div>Surat Pemberitahuan Tahunan Pajak Penghasilan adalah Surat Pemberitahuan Pajak Penghasilan untuk suatu Tahun Pajak atau bagian Tahun Pajak.</div></li><li><div>Manajemen Data dan Informasi adalah sistem administrasi data dan informasi Wajib Pajak yang berkaitan dengan Pengampunan Pajak yang dikelola oleh Menteri.</div></li><li><div>Kantor Wilayah Direktorat Jenderal Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut Kanwil DJP Wajib Pajak Terdaftar adalah Kantor Wilayah Direktorat Jenderal Pajak yang wilayah kerjanya meliputi Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Kantor Pelayanan Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut KPP Tempat Wajib Pajak Terdaftar adalah Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Bank Persepsi adalah bank umum yang ditunjuk oleh Menteri untuk menerima setoran penerimaan negara dan berdasarkan Undang-Undang Pengampunan Pajak ditunjuk untuk menerima setoran Uang Tebusan dan/atau dana yang dialihkan ke dalam wilayah Negara Kesatuan Republik Indonesia dalam rangka pelaksanaan Pengampunan Pajak.</div></li><li><div>Tahun Pajak Terakhir adalah Tahun Pajak yang berakhir pada jangka waktu 1 Januari 2015 sampai dengan 31 Desember 2015.</div></li></ol>";
		$tes .= "</div>";
		$tes .= "</td></tr>";
		$tes .= "</tbody>";
		$tes .= "</table>";
		$tes .= "</div>";
		*/
		$tes .= "<div>";
		$tes .= "<table border='0' cellpadding='0' cellspacing='0' style='page-break-inside:auto;'>";
		$tes .= "<tbody style='page-break-inside:auto;'>";
		$tes .= "<tr style='page-break-inside:auto;'><td style='page-break-inside:auto;'>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
        $tes .= "<p>tes</p>";
		//$tes .= "<ol><li><div>Undang-Undang Pengampunan Pajak adalah Undang-Undang Nomor 11 Tahun 2016 tentang Pengampunan Pajak.</div></li><li><div>Pengampunan Pajak adalah penghapusan pajak yang seharusnya terutang, tidak dikenai sanksi administrasi perpajakan dan sanksi pidana di bidang perpajakan, dengan cara mengungkap Harta dan membayar Uang Tebusan sebagaimana diatur dalam Undang-Undang Pengampunan Pajak.</div></li><li><div>Wajib Pajak adalah orang pribadi atau badan yang mempunyai hak dan kewajiban perpajakan sesuai dengan ketentuan peraturan perundang-undangan di bidang perpajakan.</div></li><li><div>Harta adalah akumulasi tambahan kemampuan ekonomis berupa seluruh kekayaan, baik berwujud maupun tidak berwujud, baik bergerak maupun tidak bergerak, baik yang digunakan untuk usaha maupun bukan untuk usaha, yang berada di dalam dan/atau di luar wilayah Negara Kesatuan Republik Indonesia.</div></li><li><div>Utang adalah jumlah pokok utang yang belum dibayar yang berkaitan langsung dengan perolehan Harta.</div></li><li><div>Tahun Pajak adalah jangka waktu 1 (satu) tahun kalender kecuali jika Wajib Pajak menggunakan tahun buku yang tidak sama dengan tahun kalender.</div></li><li><div>Tunggakan Pajak adalah jumlah pokok pajak yang belum dilunasi berdasarkan Surat Tagihan Pajak yang di dalamnya terdapat pokok pajak yang terutang, Surat Ketetapan Pajak Kurang Bayar, Surat Ketetapan Pajak Kurang Bayar Tambahan, Surat Keputusan Pembetulan, Surat Keputusan Keberatan, Putusan Banding dan Putusan Peninjauan Kembali yang menyebabkan jumlah pajak yang masih harus dibayar bertambah termasuk pajak yang seharusnya tidak dikembalikan, sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan .</div></li><li><div>Uang Tebusan adalah sejumlah uang yang dibayarkan ke kas negara untuk mendapatkan Pengampunan Pajak.</div></li><li><div>Tindak Pidana di Bidang Perpajakan adalah tindak pidana sebagaimana diatur dalam Undang-Undang mengenai Ketentuan Umum dan Tata Cara Perpajakan.</div></li><li><div>Surat Pernyataan Harta untuk Pengampunan Pajak yang selanjutnya disebut Surat Pernyataan adalah surat yang digunakan oleh Wajib Pajak untuk melaporkan Harta, Utang, nilai Harta Bersih, penghitungan dan pembayaran Uang Tebusan.</div></li><li><div>Menteri adalah menteri yang menyelenggarakan urusan pemerintahan di bidang keuangan negara.</div></li><li><div>Surat Keterangan Pengampunan Pajak yang selanjutnya disebut Surat Keterangan adalah surat yang diterbitkan oleh Menteri sebagai bukti pemberian Pengampunan Pajak.</div></li><li>Surat Pemberitahuan Tahunan Pajak Penghasilan Terakhir yang selanjutnya disebut SPT PPh Terakhir adalah:</li><li><div>Surat Pemberitahuan Tahunan Pajak Penghasilan adalah Surat Pemberitahuan Pajak Penghasilan untuk suatu Tahun Pajak atau bagian Tahun Pajak.</div></li><li><div>Manajemen Data dan Informasi adalah sistem administrasi data dan informasi Wajib Pajak yang berkaitan dengan Pengampunan Pajak yang dikelola oleh Menteri.</div></li><li><div>Kantor Wilayah Direktorat Jenderal Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut Kanwil DJP Wajib Pajak Terdaftar adalah Kantor Wilayah Direktorat Jenderal Pajak yang wilayah kerjanya meliputi Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Kantor Pelayanan Pajak Tempat Wajib Pajak Terdaftar yang selanjutnya disebut KPP Tempat Wajib Pajak Terdaftar adalah Kantor Pelayanan Pajak tempat Wajib Pajak memenuhi kewajiban perpajakan Pajak Penghasilan badan atau Pajak Penghasilan orang pribadi.</div></li><li><div>Bank Persepsi adalah bank umum yang ditunjuk oleh Menteri untuk menerima setoran penerimaan negara dan berdasarkan Undang-Undang Pengampunan Pajak ditunjuk untuk menerima setoran Uang Tebusan dan/atau dana yang dialihkan ke dalam wilayah Negara Kesatuan Republik Indonesia dalam rangka pelaksanaan Pengampunan Pajak.</div></li><li><div>Tahun Pajak Terakhir adalah Tahun Pajak yang berakhir pada jangka waktu 1 Januari 2015 sampai dengan 31 Desember 2015.</div></li></ol>";
		$tes .= "</td></tr>";
		$tes .= "</tbody>";
		$tes .= "</table>";		
		$tes .= "</div>";		
		
		$tes .= "</td></tr>";
		$tes .= "</tbody>";
		$tes .= "</table>";
		$tes .= "</div>";
		$tes .= "</div>";
		$tes .= "</div>";
		$tes .= "<script type=\"text/javascript\">";
		$tes .= "var html2pdf = {";
		$tes .= "footer: {";
		$tes .= "height:\"1.5cm\",";
		$tes .= "contents: '<div style=\"height:50px;margin-top:-100px;z-index: 9 !important;\"></div><div style=\"z-index: 9 !important;padding-top:0;margin-top:-200px;height:262px;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom center;background-size:570px 262px;\"></div>'";
		//$tes .= "contents: '<div style=\"height:0.2cm;\"></div><div style=\"border-bottom:10px solid #f77b04;padding-top:0;margin-top:0;height:0.7cm;text-align:left;background:url(https://engine.ddtc.co.id/assets/themes/images/newdocsfooter.png) no-repeat bottom left;background-size:700px 262px;\"></div>'";
		$tes .= "}";
		$tes .= "};";
		$tes .= "</script>";
		$tes .= "</body></html>";
		echo $tes;
	}
	
	public function checkid()
	{
		$nomordokumen = $this->input->get('nomordokumen', TRUE);
        $dokumen = $this->regulasi_pajak_model->get_by('nomordokumen', $nomordokumen);
		$dokumen_id = $dokumen['id'];
		if($dokumen_id) {
			echo $dokumen_id;
		} else {
			echo 'not exist';
		}
	}
}
