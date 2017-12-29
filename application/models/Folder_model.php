<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Folder_model extends MY_Model {
    
    protected $table = 'folder';
    protected $primary_key = 'folder_id';
    protected $create_date = 'folder_create';
    protected $update_date = 'folder_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_folder_by_user($folder_user)
    {
        $this->db->where('folder_user', $folder_user);
        $this->db->order_by('folder_id', 'desc');

        return $this->db->get($this->table)->result_array();
    }

    function check_folder_by_user($folder_id, $folder_user)
    {
    	$this->db->where('folder_id', $folder_id);
    	$this->db->where('folder_user', $folder_user);

    	return $this->db->count_all_results($this->table);
    }
}