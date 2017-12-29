<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favourite_model extends MY_Model {
    
    protected $table = 'favourite';
    protected $primary_key = 'favourite_id';
    protected $create_date = 'favourite_date';
    
    function __construct()
    {
        parent::__construct();
    }

    function check($favourite_user, $favourite_type, $favourite_document_id)
    {
        $this->db->where('favourite_user', $favourite_user);
        $this->db->where('favourite_type', $favourite_type);
        $this->db->where('favourite_document_id', $favourite_document_id);

        return $this->db->count_all_results($this->table);
    }  

    function get_favourite($favourite_user, $favourite_type, $favourite_document_id)
    {
        $this->db->where('favourite_user', $favourite_user);
        $this->db->where('favourite_type', $favourite_type);
        $this->db->where('favourite_document_id', $favourite_document_id);

        return $this->db->get($this->table)->row_array();
    }  

    function get_favourite_by_user($favourite_user, $favourite_folder = 0)
    {
        $this->db->where('favourite_user', $favourite_user);
        $this->db->where('favourite_folder', $favourite_folder);
        $this->db->order_by('favourite_date', 'desc');

        return $this->db->get($this->table)->result_array();
    }

    function get_favourite_document_by_user_limit($favourite_user, $limit = 2)
    {
        $this->db->where('favourite_user', $favourite_user);
        $this->db->order_by('favourite_date', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function count_document_by_folder($favourite_folder)
    {
        $this->db->where('favourite_folder', $favourite_folder);

        return $this->db->count_all_results($this->table);
    }

    function update_to_root($favourite_folder, $data)
    {
        $this->db->where('favourite_folder', $favourite_folder);

        return $this->db->update($this->table, $data);
    }
}