<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends MY_Model {
    
    protected $table = 'page';
    protected $primary_key = 'page_id';
    protected $create_date = 'page_create';
    protected $update_date = 'page_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_by($find, $key)
    {
        $this->db->where($find, $key);

        return $this->db->get($this->table)->row_array();
    }
}