<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();

    	if(!$this->admin_auth->is_logged_in())
    	{
    		redirect('webcontrol/signin');
    	}

    	$this->load->model('admin_model');

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
		$data['admin'] = $this->admin_model->get_all_order_by('admin_id', 'desc');

		$this->template->set('title', 'Admin - '.$this->config->item('web_title'));
		$this->template->load('webcontrol/template/template-table', 'webcontrol/admin/admin', $data);
	}

	public function level_check($user_level)
    {
        if ($user_level == '0')
        {
            $this->form_validation->set_message('level_check', 'Plase choose the {field} field');

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

		$this->form_validation->set_rules('admin_name', 'Admin Name', 'trim|required');
		$this->form_validation->set_rules('admin_email', 'Admin Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('admin_password', 'Admin Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('admin_repassword', 'Admin Re-Password', 'trim|required|min_length[6]|matches[admin_password]');
		$this->form_validation->set_rules('admin_level', 'Admin Level', 'callback_level_check');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$data['error'] = "";

        	$this->template->set('title', 'Admin - Add - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-add', $data);
        }
        else
        {
        	if(!empty($_FILES['admin_image']['name']))
        	{
        		$config['upload_path']          = './assets/upload/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1024;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;

                $new_name = time().'_'.$_FILES["admin_image"]['name'];
				$config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('admin_image'))
                {
                    $data['error'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $this->template->set('title', 'Admin - Add - '.$this->config->item('web_title'));
					$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-add', $data);
                }
                else
                {
                	$admin_name = $this->input->post('admin_name');
		         	$admin_email = $this->input->post('admin_email');
		         	$admin_password = $this->input->post('admin_password');
		         	$admin_level = $this->input->post('admin_level');
		         	$admin_image = $this->upload->data('file_name');

		         	$data = array(
		         			'admin_name'		=> $admin_name,
		         			'admin_email'		=> $admin_email,
		         			'admin_password'	=> md5($admin_password),
		         			'admin_level'		=> $admin_level,
		         			'admin_avatar'		=> $admin_image,
		         			'admin_status'		=> 1
		         		);

		         	$insert = $this->admin_model->insert($data);

		         	if($insert)
		         	{
		         		redirect('webcontrol/admin');
		         	}
		         	else
		         	{
		         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

		         		$data['error'] = "";

		         		$this->template->set('title', 'Admin - Add - '.$this->config->item('web_title'));
						$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-add', $data);
		         	}
                }
        	}
        	else
        	{
        		$admin_name = $this->input->post('admin_name');
	         	$admin_email = $this->input->post('admin_email');
	         	$admin_password = $this->input->post('admin_password');
	         	$admin_level = $this->input->post('admin_level');
	         	$admin_image = "avatar.png";

	         	$data = array(
	         			'admin_name'		=> $admin_name,
	         			'admin_email'		=> $admin_email,
	         			'admin_password'	=> md5($admin_password),
	         			'admin_level'		=> $admin_level,
	         			'admin_avatar'		=> $admin_image,
	         			'admin_status'		=> 1
	         		);

	         	$insert = $this->admin_model->insert($data);

	         	if($insert)
	         	{
	         		redirect('webcontrol/admin');
	         	}
	         	else
	         	{
	         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot insert data to database.</p>');

	         		$data['error'] = "";

	         		$this->template->set('title', 'Admin - Add - '.$this->config->item('web_title'));
					$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-add', $data);
	         	}	
        	}
        }
	}

	public function edit($admin_id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('admin_name', 'Admin Name', 'trim|required');
		$this->form_validation->set_rules('admin_email', 'Admin Email', 'trim|required|valid_email');

		if($this->input->post('admin_password') || $this->input->post('admin_repassword'))
		{
			$this->form_validation->set_rules('admin_password', 'Admin Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('admin_repassword', 'Admin Re-Password', 'trim|required|min_length[6]|matches[admin_password]');
		}


		$this->form_validation->set_rules('admin_level', 'Admin Level', 'callback_level_check');

		$this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');

		if($this->form_validation->run() == FALSE)
        {
        	$data['error'] = "";

			$data['admin'] = $this->admin_model->get($admin_id);

        	$this->template->set('title', 'Admin - Edit - '.$this->config->item('web_title'));
			$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-edit', $data);
        }
        else
        {
        	if(!empty($_FILES['admin_image']['name']))
        	{
        		$config['upload_path']          = './assets/upload/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1024;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;

                $new_name = time().'_'.$_FILES["admin_image"]['name'];
				$config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('admin_image'))
                {
                    $data['error'] = $this->upload->display_errors('<p class="help-block text-red">', '</p>');

                    $data['admin'] = $this->admin_model->get($admin_id);

                    $this->template->set('title', 'Admin - Edit - '.$this->config->item('web_title'));
					$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-edit', $data);
                }
                else
                {
                	$admin_name = $this->input->post('admin_name');
		         	$admin_email = $this->input->post('admin_email');
		         	$admin_password = $this->input->post('admin_password');
		         	$admin_level = $this->input->post('admin_level');
		         	$admin_image = $this->upload->data('file_name');

		         	if($this->input->post('admin_password'))
					{
						$user_password = $this->input->post('user_password');

			         	$data = array(
			         			'admin_name'		=> $admin_name,
			         			'admin_email'		=> $admin_email,
			         			'admin_password'	=> md5($admin_password),
			         			'admin_level'		=> $admin_level,
			         			'admin_avatar'	=> $admin_image
			         		);
			        }
			        else
			        {
			        	$data = array(
			         			'admin_name'		=> $admin_name,
			         			'admin_email'		=> $admin_email,
			         			'admin_level'		=> $admin_level,
			         			'admin_avatar'		=> $admin_image
			         		);
			        }

		         	$update = $this->admin_model->update($admin_id, $data);

		         	if($update)
		         	{
		         		redirect('webcontrol/admin');
		         	}
		         	else
		         	{
		         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot update data to database.</p>');

		         		$data['error'] = "";

		         		$data['admin'] = $this->admin_model->get($admin_id);

		         		$this->template->set('title', 'Admin - Edit - '.$this->config->item('web_title'));
						$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-edit', $data);
		         	}
                }
        	}
        	else
        	{
        		$admin_name = $this->input->post('admin_name');
	         	$admin_email = $this->input->post('admin_email');
	         	$admin_password = $this->input->post('admin_password');
	         	$admin_level = $this->input->post('admin_level');

	         	if($this->input->post('admin_password'))
				{
					$user_password = $this->input->post('user_password');

		         	$data = array(
		         			'admin_name'		=> $admin_name,
		         			'admin_email'		=> $admin_email,
		         			'admin_password'	=> md5($admin_password),
		         			'admin_level'		=> $admin_level
		         		);
		        }
		        else
		        {
		        	$data = array(
		         			'admin_name'		=> $admin_name,
		         			'admin_email'		=> $admin_email,
		         			'admin_level'		=> $admin_level
		         		);
		        }

	         	$update = $this->admin_model->update($admin_id, $data);

	         	if($update)
	         	{
	         		redirect('webcontrol/admin');
	         	}
	         	else
	         	{
	         		$this->session->set_flashdata('warning', '<p class="help-block text-red">Cannot update data to database.</p>');

	         		$data['error'] = "";

	         		$data['admin'] = $this->admin_model->get($admin_id);

	         		$this->template->set('title', 'Admin - Edit - '.$this->config->item('web_title'));
					$this->template->load('webcontrol/template/template-form', 'webcontrol/admin/admin-edit', $data);
	         	}
        	}         	
        }
	}

	public function signout()
	{
		$this->admin_auth->do_logout();

		redirect('webcontrol/signin');
	}

	public function publish($admin_id)
	{
		$data = array('admin_status' => 1);

		$update = $this->admin_model->update($admin_id, $data);

		if($update)
		{
			redirect('webcontrol/admin');
		}
		else
		{
			redirect('webcontrol/admin');
		}
	}

	public function unpublish($admin_id)
	{
		$data = array('admin_status' => 0);

		$update = $this->admin_model->update($admin_id, $data);

		if($update)
		{
			redirect('webcontrol/admin');
		}
		else
		{
			redirect('webcontrol/admin');
		}
	}

	public function delete($admin_id)
	{
		$delete = $this->admin_model->delete($admin_id);

		if($delete)
		{
			redirect('webcontrol/admin');
		}
		else
		{
			redirect('webcontrol/admin');
		}
	}
}
