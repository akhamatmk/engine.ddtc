<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model('regulasi_pajak_model');
        $this->load->model('putusan_pengadilan_model');
        $this->load->model('p3b_model');
        $this->load->model('putusan_ma_model');
        $this->load->model('topik_model');
        $this->load->model('jenis_dokumen_model');
        $this->load->model('favourite_model');

        $this->load->library('facebook');

        //----------------------
        //GET Facebook Login URL
        //----------------------
        /*$fb_data = $this->facebook->login();

        if(!isset($fb_data['me']))
        {
            $this->template->set('pop_facebook_login', $fb_data['loginUrl']);
        }
        else
        {
            $this->template->set('pop_facebook_login', '');
        }*/
        //----------------------

        //----------------------
        //GET Facebook Login URL
        //----------------------
        if($this->session->userdata('fb_data'))
        {
            $session = $this->session->userdata();
            $loginUrl = $session['fb_data']['loginUrl'];

            $this->template->set('pop_facebook_login', $loginUrl);
        }
        else
        {
            $fb_data = $this->facebook->login();

            if(!isset($fb_data['me']))
            {
                $this->template->set('pop_facebook_login', $fb_data['loginUrl']);
            }
            else
            {
                $this->template->set('pop_facebook_login', '');
            }
        }
        //----------------------

        /*Dokumen Favorit*/
        $favourite_document = $this->favourite_model->get_favourite_document_by_user_limit($this->session->userdata('user_id'), 10);
        $this->template->set('favourite_document', $favourite_document);
        /*----------------*/

        /*Dokumen Terakhir*/
        $latest_document = $this->regulasi_pajak_model->get_latest_document(2);
        $this->template->set('latest_document', $latest_document);

        $latest_document_pp = $this->putusan_pengadilan_model->get_latest_document(2);
        $this->template->set('latest_document_pp', $latest_document_pp);

        $latest_document_p3b = $this->p3b_model->get_latest_document(2);
        $this->template->set('latest_document_p3b', $latest_document_p3b);

        $latest_document_ma = $this->putusan_ma_model->get_latest_document(2);
        $this->template->set('latest_document_ma', $latest_document_ma);
        /*----------------*/
		
        /*Dokumen Terakhir 1*/
        $latest_document_1 = $this->regulasi_pajak_model->get_latest_document(1);
        $this->template->set('latest_document_1', $latest_document_1);

        $latest_document_pp_1 = $this->putusan_pengadilan_model->get_latest_document(1);
        $this->template->set('latest_document_pp_1', $latest_document_pp_1);

        $latest_document_p3b_1 = $this->p3b_model->get_latest_document(1);
        $this->template->set('latest_document_p3b_1', $latest_document_p3b_1);

        $latest_document_ma_1 = $this->putusan_ma_model->get_latest_document(1);
        $this->template->set('latest_document_ma_1', $latest_document_ma_1);
        /*----------------*/

        /*Nofikasi Dokumen Terbaru*/
        $notif_new_document_1 = $this->regulasi_pajak_model->get_notif_new_document();
        $notif_new_document_1_date = $notif_new_document_1[0]['tanggal'];
        $notif_new_document_1_count = count($notif_new_document_1);
        $this->template->set('notif_new_document_1_date', $notif_new_document_1_date);
        $this->template->set('notif_new_document_1_count', $notif_new_document_1_count);

        $notif_new_document_2 = $this->putusan_pengadilan_model->get_notif_new_document();
        $notif_new_document_2_date = $notif_new_document_2[0]['modified'];
        $notif_new_document_2_count = count($notif_new_document_2);
        $this->template->set('notif_new_document_2_date', $notif_new_document_2_date);
        $this->template->set('notif_new_document_2_count', $notif_new_document_2_count);

        $notif_new_document_3 = $this->p3b_model->get_notif_new_document();
        $notif_new_document_3_date = $notif_new_document_3[0]['p3b_create'];
        $notif_new_document_3_count = count($notif_new_document_3);
        $this->template->set('notif_new_document_3_date', $notif_new_document_3_date);
        $this->template->set('notif_new_document_3_count', $notif_new_document_3_count);

        $notif_new_document_4 = $this->putusan_ma_model->get_notif_new_document();
        $notif_new_document_4_date = $notif_new_document_4[0]['ma_create'];
        $notif_new_document_4_count = count($notif_new_document_4);
        $this->template->set('notif_new_document_4_date', $notif_new_document_4_date);
        $this->template->set('notif_new_document_4_count', $notif_new_document_4_count);
        /*------------------------*/
    }

}