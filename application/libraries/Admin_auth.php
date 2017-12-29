<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_auth
{
	private $CI;
    private $email;
    private $password;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

    public function do_login($email, $password)
    {
    	$this->email = $email;
    	$this->password = $password;

        $this->CI->db->where('admin_email', $this->email);
    	$this->CI->db->where('admin_password', md5($this->password));

    	$count = $this->CI->db->count_all_results('admin');

    	if($count === 1)
    	{
            $this->CI->db->where('admin_email', $this->email);
    		$this->CI->db->where('admin_password', md5($this->password));

    		$admin = $this->CI->db->get('admin')->row_array();

    		$admin_id = $admin['admin_id'];
            $admin_name = $admin['admin_name'];
            $admin_email = $admin['admin_email'];
            $admin_avatar = $admin['admin_avatar'];
            $admin_status = $admin['admin_status'];
            $admin_level = $admin['admin_level'];

            if($admin_status == 1)
            {
                $data_session = array(
                                    'admin_id'   => $admin_id,
                                    'admin_name' => $admin_name,
                                    'admin_email' => $admin_email,
                                    'admin_avatar' => $admin_avatar,
                                    'admin_level' => $admin_level
                                );
                $this->CI->session->set_userdata($data_session);

                return 'success';
            }
            else
            {
                return '<p class="help-block text-red">Your account is not active</p>';
            }
    	}
        else
        {
            return '<p class="help-block text-red">Wrong email or password</p>';
        }
    }

    public function is_logged_in()
    {
    	if($this->CI->session->userdata('admin_id') == '')
		{
			return false;
		}

		return true;
    }

    public function do_logout()
    {
    	$this->CI->session->sess_destroy();
    }
}