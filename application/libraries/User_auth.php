<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_auth
{
    private $CI;
    private $user_email;
    private $user_password;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function do_login($user_email, $user_password)
    {
        $this->user_email = $user_email;
        $this->user_password = $user_password;

        $this->CI->db->where('user_email', $this->user_email);
        $user_count = $this->CI->db->count_all_results('user');

        if($user_count === 1)
        {
            $this->CI->db->where('user_email', $this->user_email);
            $user = $this->CI->db->get('user')->row_array();

            $user_password_db = $user['user_password'];

            if($user_password_db == "")
            {
                return false;
            }
            else
            {
                $check_password = $this->check_password($this->user_password, $user_password_db);

                if($check_password)
                {
                    $user_id = $user['user_id'];
                    $user_name = $user['user_name'];
                    $user_email = $user['user_email'];
                    $user_image = $user['user_image'];

                    $data_session = array(
                                        'user_id'   => $user_id,
                                        'user_name' => $user_name,
                                        'user_email' => $user_email,
                                        'user_image' => $user_image,
                                        'user_auth'  => 'Website'
                                    );
                    $this->CI->session->set_userdata($data_session);

                    $this->CI->load->model('user_model');
                    $this->CI->user_model->update_login_current($user_id);

                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    }

    public function is_logged_in()
    {
        if($this->CI->session->userdata('user_id') == '')
        {
            return false;
        }

        return true;
    }

    public function do_logout()
    {
        $this->CI->load->helper('cookie');
        delete_cookie('user_logged_in_cookies');

        $this->CI->session->sess_destroy();
    }

    public function create_cookies($user_id)
    {
        $this->CI->load->helper('cookie');

        $cookie = array(
                        'name'   => 'user_logged_in_cookies',
                        'value'  => $user_id,                            
                        'expire' => time() + 2592000
                        );

        set_cookie($cookie);
    }

    /*Password*/
    public function create_password($user_password)
    {
        $this->user_password = $this->crypt_password($user_password);

        return $this->user_password;
    }

    private function crypt_password($input, $rounds = 10)
    {
        $crypt_options = array(
            'cost' => $rounds
        );

        return password_hash($input, PASSWORD_BCRYPT, $crypt_options);
    }

    private function check_password($input, $user_password)
    {
        if(password_verify($input, $user_password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /*Passwod*/
}