<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('favourite_model');
        $this->load->model('lastseen_model');

        $this->load->model('feedback_model');

    	$this->load->helper('peraturan_pajak_helper');
    }

	public function index()
	{
		redirect('user/settings');
	}
	
	public function verify()
	{
		$user_email = $this->input->post('user_email');
		$user_password = $this->input->post('user_password');
		$user_name = $this->input->post('user_name');
		/*
		$user = $this->user_model->get_by('user_email', $user_email);
		if($user) {
			$user_id = $user['user_id'];
			$data = array(
					'user_status' => 1
				);
			$update = $this->user_model->update($user_id, $data);
		}
		*/
		$user = $this->user_model->get_by('user_email', $user_email);
		if(!$user) {
			$data_user = array(
							'user_name' => $user_name,
							'user_email' => $user_email,
							'user_password' => $this->user_auth->create_password($user_password),
							'user_status' => 1,
							'user_activation_code' => md5($user_email)
						);
			$this->user_model->insert($data_user);
		}
	}
	
	public function updatepassword()
	{
		$user_email = $this->input->post('user_email');
		$user_password = $this->input->post('user_password');
		$user = $this->user_model->get_by('user_email', $user_email);
		if($user) {
			$data = array(
					'user_password' => $this->user_auth->create_password($user_password)
				);
			$this->user_model->update($user['user_id'], $data);
		}
	}

	public function testing()
	{
		$post = [
				'email' => 'taufiq@nufolder.com',
				'kunci' => '5n4r3th3b35T!',
				'reqtype' => 'login',
			];

			$ch = curl_init('http://dannydarussalam.com/apps/access');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			$response = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($response);

			echo '<pre>';
			print_r($response);
			echo '</pre>';
	}

	public function login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
		//$this->form_validation->set_rules('user_password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(
						array(
							'st' => 0, 'msg' => validation_errors()
							)
						);
		}
		else
		{
		
		
			$post = [
				'email' => $this->input->post('user_email'),
				'kunci' => $this->input->post('user_password'),
				'reqtype' => 'login',
			];

			$ch = curl_init('http://dannydarussalam.com/apps/access');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			$response = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($response);
			
			if($response->status == 'success') {
				$do_login = $this->user_auth->do_login($this->input->post('user_email'), $this->input->post('user_password'));
				if($do_login)
				{
					if($this->input->post('keep_login'))
					{
						$this->user_auth->create_cookies($this->session->userdata('user_id'));
					}

					echo json_encode(
							array(
								'st' =>1 , 'msg' => '<p class="help-block message-success">Mengarahkan...</p>'
								)
							);
				}
				else
				{
					$data_user = array(
									'user_name' => $response->name,
									'user_email' => $this->input->post('user_email'),
									'user_password' => $this->user_auth->create_password($this->input->post('user_password')),
									'user_status' => 1,
									'user_activation_code' => md5($this->input->post('user_email'))
								);
					$this->user_model->insert($data_user);
					$this->user_auth->do_login($this->input->post('user_email'), $this->input->post('user_password'));

					if($this->input->post('keep_login'))
					{
						$this->user_auth->create_cookies($this->session->userdata('user_id'));
					}

					echo json_encode(
							array(
								'st' =>1 , 'msg' => '<p class="help-block message-success">Mengarahkan...</p>'
								)
							);
				}
			} else {
				$user_email = $this->input->post('user_email');
				$user_password = $this->input->post('user_password');

				$do_login = $this->user_auth->do_login($user_email, $user_password);

				if($do_login)
				{
					if($this->input->post('keep_login'))
					{
						$this->user_auth->create_cookies($this->session->userdata('user_id'));
					}
					
					echo json_encode(
							array(
								'st' =>1 , 'msg' => '<p class="help-block message-success">Mengarahkan...</p>'
								)
							);
				}
				else
				{
					echo json_encode(
							array(
								'st' => 0, 'msg' => '<p class="help-block message-error">Wrong email or password.</p>'
								)
							);
				}
			}
			
		}
	}

	public function register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[user.user_email]');
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_message('is_unique', 'The %s is already taken.');
		$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(
						array(
								'st' => 0, 
								'msg' => validation_errors()
							)
						);
		}
		else
		{
			$user_name = $this->input->post('user_name');
			$user_email = $this->input->post('user_email');
			$user_password = $this->input->post('user_password');
		
			$post = [
				'nama' => $user_name,
				'email' => $user_email,
				'kunci' => $user_password,
				'reqtype' => 'registration',
			];

			// $ch = curl_init('http://dannydarussalam.com/apps/access');
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			// $response = curl_exec($ch);
			// curl_close($ch);

			// $response = json_decode($response);
			
			// if($response->status == 'success') {
			// 	echo json_encode(
			// 			array(
			// 					'st' => 0, 
			// 					'msg' => '<p class="help-block message-success">Registration successfull. Pleace check your email to activate your account.</p>'
			// 				)
			// 			);
			// } else {
			// 	echo json_encode(
			// 			array(
			// 					'st' => 0, 
			// 					'msg' => '<p class="help-block message-error">'.$response->message.'.</p>'
			// 				)
			// 			);
			// }

			
			//$this->load->helper('password_helper');

			//if(valid_pass($user_password))
			//{
				$data_user = array(
								'user_name' => $user_name,
								'user_email' => $user_email,
								'user_password' => $this->user_auth->create_password($user_password),
								'user_status' => 0,
								'user_activation_code' => md5($user_email)
							);
				$this->user_model->insert($data_user);

				$do_login = $this->user_auth->do_login($user_email, $user_password);

				if($do_login)
				{
					//SEND EMAIL ACCOUNT AND ACTIVATION
					
					echo json_encode(
							array(
									'st' => 1, 
									'msg' => '<p class="help-block message-success">Mengarahkan...</p>'
								)
							);
				}
				else
				{
					echo json_encode(
							array(
									'st' => 0, 
									'msg' => '<p class="help-block message-error">Wrong email or password.</p>'
								)
							);
				}
			//}
			//else
			//{
			//	echo json_encode(
			//				array(
			//						'st' => 0, 
			//						'msg' => '<p class="help-block message-error">Password harus memiliki setidaknya 8 karakter. Terdiri dari 1 digit, 1 huruf besar, dan 1 karakter non-alfanumerik.</p>'
			//					)
			//				);
			//}

		}
	}

	public function feedback()
	{
		if(!$this->user_auth->is_logged_in())
		{
			echo json_encode(
						array(
							'st' => 0, 'msg' => '<p class="help-block message-error">Anda harus login terlebih dahulu</p>'
							)
						);
		}	
		else
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('feedback_content', 'Kritik dan Saran', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');	

			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(
							array(
								'st' => 0, 'msg' => validation_errors()
								)
							);
			}
			else
			{
				$feedback_content = $this->input->post('feedback_content');

				$data = array(
						'feedback_user' => $this->session->userdata('user_id'),
						'feedback_content' => $feedback_content,
						'feedback_status' => 0
					);

				$insert = $this->feedback_model->insert($data);

				if($insert)
				{
					echo json_encode(
							array(
								'st' => 1, 'msg' => '<p class="help-block message-success">Kritik dan saran sudah tersimpan.</p>'
								)
							);
				}
				else
				{
					echo json_encode(
							array(
								'st' => 0, 'msg' => '<p class="help-block message-error">Kritik dan saran tidak berhasil tersimpan.</p>'
								)
							);
				}
			}
		}
	}

	public function forgotpassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(
						array(
							'st' => 0, 'msg' => validation_errors()
							)
						);
		}
		else
		{
			$user_email = $this->input->post('user_email');

			$user = $this->user_model->get_by('user_email', $user_email);

			if(count($user) > 0)
			{
				if($user['user_password'] == "" || !$user['user_password'])
				{
					echo json_encode(
								array(
									'st' =>0 , 'msg' => '<p class="help-block message-error">Email ini terdaftar menggunakan Facebook, silahlan login dengan Facebook.</p>'
									)
								);	
				}
				else
				{
					//send email
					$this->load->library('email');

					$config['crlf'] = '\r\n';
					$config['newline'] = '\r\n';
					$config['wordwrap'] = TRUE;

					$this->email->initialize($config);

					$this->email->from('info@dannydarussalam.com', 'Tax Engine');
					$this->email->to($user_email);

					$this->email->subject('[Tax Engine] Forgot Password');

					$message = "Halo, ". $user['user_name'] .".\n\n";
					$message .= "Lupa dengan password Anda? Klik link dibawah untuk mengganti:\n\n";
					$message .= site_url("user/resetpassword/". $user['user_activation_code']) ."\n\n";
					$message .= "Terimakasih\n\nTax Engine by Danny Darussalam";

					$this->email->message($message);

					if (!$this->email->send())
					{
						echo json_encode(
									array(
										'st' =>0 , 'msg' => '<p class="help-block message-error">Oops, tidak berhasil mengirimkan email.</p>'
										)
									);	
					}
					else
					{
						echo json_encode(
									array(
										'st' =>1 , 'msg' => '<p class="help-block message-success-alt-1">Silahkan cek email Anda.</p>'
										)
									);
					}
				}
			}
			else
			{
				echo json_encode(
							array(
								'st' =>0 , 'msg' => '<p class="help-block message-error">Email ini tidak terdaftar.</p>'
								)
							);	
			}
		}
	}

	public function resetpassword($code)
	{
		$user = $this->user_model->get_by('user_activation_code', $code);

		if(count($user) > 0)
		{
			$this->load->helper('string');
			$new_password = random_string('alnum', 8);

			$data = array(
					'user_password' => $this->user_auth->create_password($new_password)
				);

			$update = $this->user_model->update($user['user_id'], $data);

			if($update)
			{
				//send email
				$this->load->library('email');

				$config['crlf'] = '\r\n';
				$config['newline'] = '\r\n';
				$config['wordwrap'] = TRUE;

				$this->email->initialize($config);

				$this->email->from('info@dannydarussalam.com', 'Tax Engine');
				$this->email->to($user['user_email']);

				$this->email->subject('[Tax Engine] Reset Password');

				$message = "Halo, ". $user['user_name'] .".\n\n";
				$message .= "Berikut info akun baru Anda:\n\n";
				$message .= "Email: " . $user['user_email'] . "\n";
				$message .= "Password: " . $new_password . "\n\n";
				$message .= "Terimakasih\n\nTax Engine by Danny Darussalam";

				$this->email->message($message);
				//----------

				if (!$this->email->send())
				{
					$this->session->set_flashdata('msg_changepassword', '<p>Oops, tidak berhasil mengirimkan email.</p>');

					redirect('home');
				}
				else
				{
					$this->session->set_flashdata('msg_changepassword', '<p>Reset password berhasil, silahkan cek email untuk melihat password baru.</p>');

					redirect('home');
				}
			}
			else
			{
				$this->session->set_flashdata('msg_changepassword', '<p>Reset password gagal.</p>');

				redirect('home');
			}
		}
		else
		{
			$this->session->set_flashdata('msg_changepassword', '<p>Reset password gagal.</p>');

			redirect('home');
		}
	}

	public function settings()
	{
		if(!$this->user_auth->is_logged_in())
		{
			redirect('home');
		}
		else
		{
			$favourite = $this->favourite_model->get_favourite_by_user($this->session->userdata('user_id'));
			$data['favourite'] = $favourite;

			$lastseen = $this->lastseen_model->get_lastseen_by_user($this->session->userdata('user_id'));
			$data['lastseen'] = $lastseen;

			$this->template->set('container_class', '');
			$this->template->set('title', 'User Setting - '.$this->config->item('web_title'));
			$this->template->load('web/template/template-2', 'web/user/user-settings', $data);
		}
	}

	public function do_settings()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('setting_name', 'Nama', 'trim|required');

		if(!empty($this->input->post('setting_password')))
		{
			$this->form_validation->set_rules('setting_password', 'Kata sandi', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('setting_repassword', 'Ulang Kata sandi', 'trim|required|min_length[8]|matches[setting_password]');
		}

		$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');

		if($this->form_validation->run() == FALSE)
		{
			echo json_encode(
						array(
								'st' => 0, 
								'msg' => validation_errors()
							)
						);
		}
		else
		{
			if(!empty($_FILES['setting_image']['name']))
        	{
        		$config['upload_path']          = './assets/upload/images/';
	            $config['allowed_types']        = 'gif|jpg|jpeg|png';
	            $config['max_size']             = 1024;
	            //$config['max_width']            = 1024;
	           	//$config['max_height']           = 1024;

	            $new_name = time().'_'.$_FILES["setting_image"]['name'];
				$config['file_name'] = $new_name;

	            $this->load->library('upload', $config);

	            if (!$this->upload->do_upload('setting_image'))
	            {
	                   echo json_encode(
						array(
								'st' => 0, 
								'msg' => $this->upload->display_errors('<p class="help-block message-error">', '</p>')
							)
						);
	            }
	            else
	            {
	            	$user_id = $this->session->userdata('user_id');
					$user = $this->user_model->get_by('user_id', $user_id);

					$setting_name = $this->input->post('setting_name');
					$setting_email = $user['user_email'];
					$setting_password = $this->input->post('setting_password');
					$setting_repassword = $this->input->post('setting_repassword');
					$setting_image = $this->upload->data('file_name');

					if(empty($setting_password))
					{
						$data = array(
								'user_name' => $setting_name,
								'user_image' => $setting_image
							);

						$update = $this->user_model->update($user_id, $data);

						if($update)
						{
							$this->session->set_userdata('user_name', $setting_name);
							$this->session->set_userdata('user_image', $setting_image);
							
							$post = [
								'nama' => $setting_name,
								'email' => $setting_email,
								'reqtype' => 'updateprofile',
							];
							$ch = curl_init('http://dannydarussalam.com/apps/access');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
							curl_exec($ch);
							curl_close($ch);
							
							echo json_encode(
									array(
											'st' => 1, 
											'msg' => '<p class="help-block message-success-alt-1">Data berhasil disimpan.</p>'
										)
									);
						}
						else
						{
							echo json_encode(
									array(
											'st' => 0, 
											'msg' => '<p class="help-block message-error">Data tidak berhasil disimpan.</p>'
										)
									);
						}
					}
					else
					{
						if($user['user_password'] == "" || !$user['user_password'])
						{
							echo json_encode(
										array(
											'st' =>0 , 'msg' => '<p class="help-block message-error">Email ini terdaftar menggunakan Facebook, silahlan login dengan Facebook.</p>'
											)
										);	
							exit();
						}
						if(valid_pass($setting_password))
						{
							$data = array(
											'user_name' => $setting_name,
											'user_image' => $setting_image,
											'user_password' => $this->user_auth->create_password($setting_password)
										);

							$update = $this->user_model->update($user_id, $data);

							if($update)
							{
								$this->session->set_userdata('user_name', $setting_name);
								$this->session->set_userdata('user_image', $setting_image);
								
								$post = [
									'nama' => $setting_name,
									'email' => $setting_email,
									'kunci' => $setting_password,
									'reqtype' => 'updateprofile',
								];
								$ch = curl_init('http://dannydarussalam.com/apps/access');
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
								curl_exec($ch);
								curl_close($ch);

								echo json_encode(
										array(
												'st' => 1, 
												'msg' => '<p class="help-block message-success-alt-1">Data berhasil disimpan.</p>'
											)
										);
							}
							else
							{
								echo json_encode(
										array(
												'st' => 0, 
												'msg' => '<p class="help-block message-error">Data tidak berhasil disimpan.</p>'
											)
										);
							}
						}
						else
						{
							echo json_encode(
										array(
												'st' => 0, 
												'msg' => '<p class="help-block message-error">Password harus memiliki setidaknya 8 karakter. Terdiri dari 1 digit, 1 huruf besar, dan 1 karakter non-alfanumerik.</p>'
											)
										);
						}
					}
	            }
            }
            else
            {
            	$user_id = $this->session->userdata('user_id');
				$user = $this->user_model->get_by('user_id', $user_id);

				$setting_name = $this->input->post('setting_name');
				$setting_email = $user['user_email'];
				$setting_password = $this->input->post('setting_password');
				$setting_repassword = $this->input->post('setting_repassword');

				if(empty($setting_password))
				{
					$data = array(
							'user_name' => $setting_name
						);

					$update = $this->user_model->update($user_id, $data);

					if($update)
					{
						$this->session->set_userdata('user_name', $setting_name);
						
						$post = [
							'nama' => $setting_name,
							'email' => $setting_email,
							'reqtype' => 'updateprofile',
						];
						$ch = curl_init('http://dannydarussalam.com/apps/access');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
						curl_exec($ch);
						curl_close($ch);
						
						echo json_encode(
								array(
										'st' => 1, 
										'msg' => '<p class="help-block message-success-alt-1">Data berhasil disimpan.</p>'
									)
								);
					}
					else
					{
						echo json_encode(
								array(
										'st' => 0, 
										'msg' => '<p class="help-block message-error">Data tidak berhasil disimpan.</p>'
									)
								);
					}
				}
				else
				{
					if($user['user_password'] == "" || !$user['user_password'])
					{
						echo json_encode(
									array(
										'st' =>0 , 'msg' => '<p class="help-block message-error">Email ini terdaftar menggunakan Facebook, silahlan login dengan Facebook.</p>'
										)
									);	
						exit();
					}
					if(valid_pass($setting_password))
					{
						$data = array(
										'user_name' => $setting_name,
										'user_password' => $this->user_auth->create_password($setting_password)
									);

						$update = $this->user_model->update($user_id, $data);

						if($update)
						{
							$this->session->set_userdata('user_name', $setting_name);
							
							$post = [
								'nama' => $setting_name,
								'email' => $setting_email,
								'kunci' => $setting_password,
								'reqtype' => 'updateprofile',
							];
							$ch = curl_init('http://dannydarussalam.com/apps/access');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
							curl_exec($ch);
							curl_close($ch);

							echo json_encode(
									array(
											'st' => 1, 
											'msg' => '<p class="help-block message-success-alt-1">Data berhasil disimpan.</p>'
										)
									);
						}
						else
						{
							echo json_encode(
									array(
											'st' => 0, 
											'msg' => '<p class="help-block message-error">Data tidak berhasil disimpan.</p>'
										)
									);
						}
					}
					else
					{
						echo json_encode(
									array(
											'st' => 0, 
											'msg' => '<p class="help-block message-error">Password harus memiliki setidaknya 8 karakter. Terdiri dari 1 digit, 1 huruf besar, dan 1 karakter non-alfanumerik.</p>'
										)
									);
					}
				}
            }
		}
	}

	public function favourite()
	{
		if(!$this->user_auth->is_logged_in())
		{
			redirect('home');
		}
		else
		{
			$this->load->model('folder_model');

			$action = $this->uri->segment(3);

			if(!$action || $action == "" || $action == null)
			{
				$favourite = $this->favourite_model->get_favourite_by_user($this->session->userdata('user_id'));
				$data['favourite'] = $favourite;

				$folder = $this->folder_model->get_folder_by_user($this->session->userdata('user_id'));
				$data['folder'] = $folder;

				$this->template->set('container_class', '');
				$this->template->set('title', 'User Favourite - '.$this->config->item('web_title'));
				$this->template->load('web/template/template-2', 'web/user/user-favourite', $data);
			}

			if($action == "folder")
			{
				$folder_id = $this->uri->segment(4);

				$favourite = $this->favourite_model->get_favourite_by_user($this->session->userdata('user_id'), $folder_id);
				$data['favourite'] = $favourite;

				$folder = $this->folder_model->get_folder_by_user($this->session->userdata('user_id'));
				$data['folder'] = $folder;

				$cfolder = $this->folder_model->get($folder_id);
				$data['cfolder'] = $cfolder;

				$user_id = $this->session->userdata('user_id');

				$check_folder = $this->folder_model->check_folder_by_user($folder_id, $user_id);

				if($check_folder > 0)
				{
					$this->template->set('container_class', '');
					$this->template->set('title', 'User Favourite - '.$cfolder['folder_name'].' - '.$this->config->item('web_title'));
					$this->template->load('web/template/template-2', 'web/user/user-favourite-folder', $data);
				}
				else
				{
					redirect('user/favourite');	
				}
			}

			if($action == "move")
			{
				$favourite_id = $this->uri->segment(4);
				$folder_id = $this->uri->segment(5);

				$user_id = $this->session->userdata('user_id');

				$check_folder = $this->folder_model->check_folder_by_user($folder_id, $user_id);

				if($check_folder > 0)
				{
					$data = array(
							'favourite_folder' => $folder_id
						);
					$update = $this->favourite_model->update($favourite_id, $data);

					redirect('user/favourite');
				}
				else
				{
					redirect('user/favourite');
				}

			}

			if($action == "delete_folder")
			{
				$folder_id = $this->uri->segment(4);
				$user_id = $this->session->userdata('user_id');

				$check_folder = $this->folder_model->check_folder_by_user($folder_id, $user_id);

				if($check_folder > 0)
				{
					$data = array('favourite_folder' => 0);
					$update = $this->favourite_model->update_to_root($folder_id, $data);

					if($update)
					{
						$this->folder_model->delete($folder_id);

						redirect('user/favourite');
					}
					else
					{
						redirect('user/favourite');	
					}
				}
				else
				{
					redirect('user/favourite');	
				}
			}

			if($action == "edit_folder")
			{
				$folder_id = $this->uri->segment(4);

				$this->load->library('form_validation');
				$this->form_validation->set_rules('folder_name', 'Nama Folder', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');
				
				if ($this->form_validation->run() == FALSE)
				{
					echo json_encode(
								array(
									'st' => 0, 'msg' => validation_errors()
									)
								);
				}
				else
				{
					$folder_name = $this->input->post('folder_name');
					$folder_url = url_title($folder_name, '-', TRUE);

					$data = array(
							'folder_name' => $folder_name,
							'folder_url' => $folder_url,
						);
					$update = $this->folder_model->update($folder_id, $data);

					if($update)
					{
						echo json_encode(
								array(
									'st' => 1, 'msg' => '<p class="help-block message-success-alt-1">Folder berhasil disimpan.</p>', 'url' => site_url().'user/favourite/folder/'.$folder_id.'/'.$folder_url
									)
								);
					}
					else
					{
						echo json_encode(
								array(
									'st' => 0, 'msg' => '<p class="help-block message-error">Folder tidak berhasil disimpan.</p>'
									)
								);
					}
				}
			}

			if($action == "add_folder")
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('folder_name', 'Nama Folder', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="help-block message-error">', '</p>');
				
				if ($this->form_validation->run() == FALSE)
				{
					echo json_encode(
								array(
									'st' => 0, 'msg' => validation_errors()
									)
								);
				}
				else
				{
					$folder_user = $this->session->userdata('user_id');
					$folder_name = $this->input->post('folder_name');
					$folder_url = url_title($folder_name, '-', TRUE);

					$data = array(
							'folder_user' => $folder_user,
							'folder_name' => $folder_name,
							'folder_url' => $folder_url,
							'folder_status' => 1,
						);
					$insert = $this->folder_model->insert($data);

					if($insert)
					{
						echo json_encode(
								array(
									'st' => 1, 'msg' => '<p class="help-block message-success-alt-1">Folder berhasil disimpan.</p>', 'url' => site_url().'user/favourite'
									)
								);
					}
					else
					{
						echo json_encode(
								array(
									'st' => 0, 'msg' => '<p class="help-block message-error">Folder tidak berhasil disimpan.</p>'
									)
								);
					}
				}
			}
		}
	}

	public function logout()
	{
		$user_id = $this->session->userdata('user_id');
		$this->user_model->update_login_last($user_id);

		$this->user_auth->do_logout();

		redirect('home');
	}
}
