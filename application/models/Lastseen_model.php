<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lastseen_model extends MY_Model {
    
    protected $table = 'lastseen';
    protected $primary_key = 'lastseen_id';
    protected $create_date = 'lastseen_date';
    
    function __construct()
    {
        parent::__construct();
    }

    function check_last_id($lastseen_user)
    {
        $this->db->where('lastseen_user', $lastseen_user);
        $this->db->order_by('lastseen_date', 'desc');
        $this->db->limit(1);

        return $this->db->get($this->table)->row_array();        
    }

    function check($lastseen_user, $lastseen_type, $lastseen_document_id)
    {
        $this->db->where('lastseen_user', $lastseen_user);
        $this->db->where('lastseen_type', $lastseen_type);
        $this->db->where('lastseen_document_id', $lastseen_document_id);

        return $this->db->count_all_results($this->table);
    }  

    function get_lastseen($lastseen_user, $lastseen_type, $lastseen_document_id)
    {
        $this->db->where('lastseen_user', $lastseen_user);
        $this->db->where('lastseen_type', $lastseen_type);
        $this->db->where('lastseen_document_id', $lastseen_document_id);

        return $this->db->get($this->table)->row_array();
    }  

    function get_lastseen_by_user($lastseen_user)
    {
        $this->db->where('lastseen_user', $lastseen_user);
        $this->db->order_by('lastseen_date', 'desc');

        return $this->db->get($this->table)->result_array();
    }
}