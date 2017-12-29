<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');

        $this->load->library('facebook');
    }
    
    public function facebook()
    {
        $fb_data = $this->facebook->login();

        $data['error_facebook_login'] = "";
        
        if(isset($fb_data['me']))
        {
            $user_name = $fb_data['me']['name'];
            $user_email = $fb_data['me']['email'];
            $user_facebook_id = $fb_data['me']['id'];
            $user_facebook_token = $this->session->userdata('fb_token');
            //$user_status = $fb_data['me']['verified'];
            $user_status = 1;
			
			$post = [
				'nama' => $user_name,
				'email' => $user_email,
				'reqtype' => 'registrationfb',
			];
			$ch = curl_init('http://dannydarussalam.com/apps/access');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_exec($ch);
			curl_close($ch);

            $check_user = $this->user_model->check_user('user_email', $user_email);

            if($check_user == 0)
            {
                $data_user = array(
                                'user_name'           => $user_name,
                                'user_email'          => $user_email,
                                'user_facebook_id'    => $user_facebook_id,
                                'user_facebook_token' => $user_facebook_token,
                                'user_status'         => $user_status,
                                'user_activation_code'=> md5($user_email)
                            );

                $this->user_model->insert($data_user);

                $user_id = $this->db->insert_id();

                $data_session = array(
                                    'user_id'    => $user_id,
                                    'user_name'  => $user_name,
                                    'user_email' => $user_email,
                                    'user_image' => 'prof_pic.png',
                                    'user_auth'  => 'Facebook'
                                );
                $this->session->set_userdata($data_session);

                $this->user_model->update_login_current($user_id);
            }
            else
            {
                $user = $this->user_model->get_by('user_email', $user_email);

                $user_id = $user['user_id'];
                $user_name = $user['user_name'];
                $user_email = $user['user_email'];
                $user_image = $user['user_image'];

                $data_session = array(
                                    'user_id'   => $user_id,
                                    'user_name' => $user_name,
                                    'user_email' => $user_email,
                                    'user_image' => $user_image,
                                    'user_auth'  => 'Facebook'
                                );
                $this->session->set_userdata($data_session);

                $this->user_model->update_login_current($user_id);
            }

            redirect('peraturan-pajak'); 
        } 
        else 
        {
            if(isset($_GET['error']))
            {
                $error_description = $_GET['error_description'];

                $this->session->set_flashdata('error_facebook_login', '<p>Facebook login failed: '.$error_description.'.</p>');
            }

            redirect('home'); 
        }
    }
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */