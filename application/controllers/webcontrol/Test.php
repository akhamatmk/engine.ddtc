<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{
		$this->load->library('email');
		$query = $this->db->query("SELECT user_email FROM user where user_status = 1 and user_email IS NOT NULL and user_email != ''");
		$data = $query->result();
		$email = [];
		foreach ($data as $key => $value) {
			$email[] = $value->user_email;
		}

		$this->email->from('Enginerddtc@noreply');
		$this->email->to("akhamatmkhoir@gmail.com");
		
		$this->email->subject('Weekly Subcribe Email');
		$this->email->message('test');
		$this->email->send();
	}

	public function time()
	{
		echo 1;
	}
}
