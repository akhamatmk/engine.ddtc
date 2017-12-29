<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mahkamahagung_model extends MY_Model {
    
    protected $table = 'mahkamahagung';
    protected $primary_key = 'ma_id';
    protected $create_date = 'ma_create';
    protected $update_date = 'ma_update';
    
    function __construct()
    {
        parent::__construct();
    }

   	function get_all_by_user($ma_user)
   	{
   		$this->db->where('ma_user_create', $ma_user);

   		return $this->db->get($this->table)->result_array();
   	}
}